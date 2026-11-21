<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Authorization\ScopedAuthorization;
use App\Models\RoleAssignment;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

final class AdministrationWorkspaceController extends Controller
{
    public function index(Request $request, ScopedAuthorization $authorization): View
    {
        $user = $request->user();
        abort_unless($user instanceof User && $user->is_active && $user->email_verified_at !== null, 403);

        $requestedLocale = $request->query('lang', $request->session()->get('directory_locale', 'en'));
        $locale = is_string($requestedLocale) && in_array($requestedLocale, ['en', 'ur'], true)
            ? $requestedLocale
            : 'en';
        $request->session()->put('directory_locale', $locale);
        App::setLocale($locale);

        $assignments = RoleAssignment::query()
            ->where('user_id', $user->getKey())
            ->whereIn('role', ['institution_representative', 'data_reviewer'])
            ->where('scope_type', 'institution')
            ->whereNotNull('scope_id')
            ->whereNull('revoked_at')
            ->where(function ($query): void {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->get(['role', 'scope_id']);

        $representativeScopes = [];
        $reviewerScopes = [];
        $scopeIds = $assignments->pluck('scope_id')->unique()->values()->all();

        if ($scopeIds !== []) {
            $eligibleInstitutions = DB::table('directory_entities')
                ->join('directory_provider_category_assignments', 'directory_provider_category_assignments.entity_id', '=', 'directory_entities.id')
                ->whereIn('directory_entities.id', $scopeIds)
                ->where('directory_entities.entity_type', 'institution')
                ->where('directory_provider_category_assignments.provider_category', 'university')
                ->pluck('directory_entities.id')
                ->map(static fn ($id): string => (string) $id)
                ->all();

            foreach ($assignments as $assignment) {
                $scopeId = (string) $assignment->scope_id;
                if (! in_array($scopeId, $eligibleInstitutions, true)) {
                    continue;
                }

                if ($assignment->role === 'institution_representative'
                    && $authorization->allows($user, 'institution.claim.submit', 'institution', $scopeId)) {
                    $representativeScopes[] = $scopeId;
                }

                if ($assignment->role === 'data_reviewer'
                    && $authorization->allows($user, 'claim.review', 'institution', $scopeId)) {
                    $reviewerScopes[] = $scopeId;
                }
            }
        }

        $representativeScopes = array_values(array_unique($representativeScopes));
        $reviewerScopes = array_values(array_unique($reviewerScopes));
        abort_unless($representativeScopes !== [] || $reviewerScopes !== [], 403);

        $actorId = 'user:'.$user->getKey();
        $submissions = [];

        if ($representativeScopes !== []) {
            $submissions = DB::table('editorial_review_cases as cases')
                ->join('directory_entities as entities', 'entities.id', '=', 'cases.entity_id')
                ->join('claim_versions as versions', 'versions.id', '=', 'cases.claim_version_id')
                ->join('claims', 'claims.id', '=', 'versions.claim_id')
                ->whereIn('cases.entity_id', $representativeScopes)
                ->where('cases.submitted_by_actor_id', $actorId)
                ->orderByDesc('cases.created_at')
                ->limit(50)
                ->get([
                    'cases.id',
                    'cases.entity_id',
                    'entities.label as institution_name',
                    'claims.predicate',
                    'versions.version_number',
                    'cases.status',
                    'cases.created_at',
                ])
                ->map(static fn ($row): array => [
                    'case_id' => (string) $row->id,
                    'institution_id' => (string) $row->entity_id,
                    'institution_name' => (string) $row->institution_name,
                    'predicate' => (string) $row->predicate,
                    'version_number' => (int) $row->version_number,
                    'status' => (string) $row->status,
                    'created_at' => (string) $row->created_at,
                ])
                ->all();
        }

        $reviewQueue = [];

        if ($reviewerScopes !== []) {
            $cases = DB::table('editorial_review_cases as cases')
                ->join('directory_entities as entities', 'entities.id', '=', 'cases.entity_id')
                ->join('claim_versions as versions', 'versions.id', '=', 'cases.claim_version_id')
                ->join('claims', 'claims.id', '=', 'versions.claim_id')
                ->whereIn('cases.entity_id', $reviewerScopes)
                ->where('cases.status', 'submitted')
                ->where('cases.submitted_by_actor_id', '!=', $actorId)
                ->orderBy('cases.created_at')
                ->limit(100)
                ->get([
                    'cases.id',
                    'cases.entity_id',
                    'entities.label as institution_name',
                    'claims.predicate',
                    'versions.id as claim_version_id',
                    'versions.version_number',
                    'cases.created_at',
                ]);

            foreach ($cases as $case) {
                if ($this->isEvidenceContributor($case->claim_version_id, $actorId)) {
                    continue;
                }

                $reviewQueue[] = [
                    'case_id' => (string) $case->id,
                    'institution_id' => (string) $case->entity_id,
                    'institution_name' => (string) $case->institution_name,
                    'predicate' => (string) $case->predicate,
                    'version_number' => (int) $case->version_number,
                    'status' => 'submitted',
                    'created_at' => (string) $case->created_at,
                ];
            }
        }

        return response()->view('workspace.index', [
            'locale' => $locale,
            'direction' => $locale === 'ur' ? 'rtl' : 'ltr',
            'representative' => $representativeScopes !== [],
            'reviewer' => $reviewerScopes !== [],
            'submissions' => $submissions,
            'reviewQueue' => $reviewQueue,
        ])->header('Cache-Control', 'private, no-store, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }

    private function isEvidenceContributor(string $claimVersionId, string $actorId): bool
    {
        $evidenceIds = DB::table('claim_evidence_links')
            ->where('claim_version_id', $claimVersionId)
            ->pluck('evidence_reference_id');

        foreach ($evidenceIds as $evidenceId) {
            $event = DB::table('audit_events')
                ->where('target_type', 'evidence_reference')
                ->where('target_id', $evidenceId)
                ->where('action', 'evidence_reference_registered')
                ->first(['metadata']);

            $metadata = $event === null ? [] : (json_decode((string) $event->metadata, true) ?: []);
            if (($metadata['actor_id'] ?? null) === $actorId) {
                return true;
            }
        }

        return false;
    }
}
