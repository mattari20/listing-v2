<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Authorization\ScopedAuthorization;
use App\Models\RoleAssignment;
use App\Models\User;
use App\Services\Directory\AdministrationWorkspaceQueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

final class AdministrationWorkspaceController extends Controller
{
    public function index(
        Request $request,
        ScopedAuthorization $authorization,
        AdministrationWorkspaceQueryService $workspace,
    ): Response {
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
        $eligibleInstitutions = $workspace->eligibleUniversityInstitutionIds($scopeIds);

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

        $representativeScopes = array_values(array_unique($representativeScopes));
        $reviewerScopes = array_values(array_unique($reviewerScopes));
        abort_unless($representativeScopes !== [] || $reviewerScopes !== [], 403);

        $actorId = 'user:'.$user->getKey();
        $submissions = $workspace->representativeSubmissions($representativeScopes, $actorId);
        $reviewQueue = $workspace->reviewQueue($reviewerScopes, $actorId);

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
}
