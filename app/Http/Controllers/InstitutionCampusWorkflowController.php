<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Authorization\ScopedAuthorization;
use App\Models\User;
use App\Services\Directory\FieldAwareClaimProposalService;
use App\Services\Directory\ProviderInstitutionRelationshipService;
use App\Services\Directory\UniversityRepresentativeWorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class InstitutionCampusWorkflowController extends Controller
{
    public function __construct(
        private readonly ScopedAuthorization $authorization,
        private readonly UniversityRepresentativeWorkflowService $workflow,
        private readonly ProviderInstitutionRelationshipService $entities,
        private readonly FieldAwareClaimProposalService $proposals,
    ) {}

    public function information(Request $request, string $institution): JsonResponse
    {
        $this->assertAccess($request, $institution);

        $entity = DB::table('directory_entities')
            ->where('id', $institution)
            ->where('entity_type', 'institution')
            ->first(['id', 'label']);

        $campuses = DB::table('directory_campuses as locations')
            ->join('directory_entities as entities', 'entities.id', '=', 'locations.entity_id')
            ->join('claim_versions as versions', 'versions.id', '=', 'locations.claim_version_id')
            ->where('locations.institution_entity_id', $institution)
            ->where('locations.status', 'active')
            ->where('versions.disposition', 'accepted')
            ->whereNotExists(function ($query): void {
                $query->selectRaw('1')
                    ->from('claim_versions as successor')
                    ->whereColumn('successor.supersedes_version_id', 'versions.id');
            })
            ->orderBy('entities.label')
            ->get([
                'entities.id',
                'entities.label',
                'locations.location_label',
                'locations.valid_from',
                'locations.valid_to',
            ]);

        $deliverySites = DB::table('directory_delivery_sites as locations')
            ->join('directory_entities as entities', 'entities.id', '=', 'locations.entity_id')
            ->join('claim_versions as versions', 'versions.id', '=', 'locations.claim_version_id')
            ->where('locations.institution_entity_id', $institution)
            ->where('locations.status', 'active')
            ->where('versions.disposition', 'accepted')
            ->whereNotExists(function ($query): void {
                $query->selectRaw('1')
                    ->from('claim_versions as successor')
                    ->whereColumn('successor.supersedes_version_id', 'versions.id');
            })
            ->orderBy('entities.label')
            ->get([
                'entities.id',
                'entities.label',
                'locations.location_label',
                'locations.valid_from',
                'locations.valid_to',
            ]);

        return response()->json([
            'institution' => ['id' => (string) $entity->id, 'label' => (string) $entity->label],
            'campuses' => $campuses,
            'delivery_sites' => $deliverySites,
        ])->header('Cache-Control', 'private, no-store, max-age=0')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }

    public function storeCampus(Request $request, string $institution): JsonResponse
    {
        return $this->storeLocation($request, $institution, 'campus');
    }

    public function storeDeliverySite(Request $request, string $institution): JsonResponse
    {
        return $this->storeLocation($request, $institution, 'delivery_site');
    }

    private function storeLocation(Request $request, string $institution, string $entityType): JsonResponse
    {
        $actor = $this->assertAccess($request, $institution);
        $validated = $request->validate([
            'institution_entity_id' => ['prohibited'],
            'label' => ['required', 'string', 'min:1', 'max:255'],
            'location_label' => ['nullable', 'string', 'max:5000'],
            'definition_version' => ['required', 'integer', 'min:1'],
            'evidence_reference_ids' => ['required', 'array', 'min:1', 'max:20'],
            'evidence_reference_ids.*' => ['required', 'uuid', 'distinct'],
            'idempotency_key' => ['required', 'string', 'max:100'],
            'valid_from' => ['nullable', 'date_format:Y-m-d'],
            'valid_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:valid_from'],
        ]);

        $user = $request->user();
        abort_unless($user instanceof User, 403);
        $result = DB::transaction(function () use ($actor, $institution, $entityType, $validated, $user): array {
            $identityKey = $this->scopedIdempotencyKey($entityType.'-identity', $user, $validated['idempotency_key']);
            $proposalKey = $this->scopedIdempotencyKey($entityType.'-proposal', $user, $validated['idempotency_key']);
            $locationId = $this->entities->registerEntity(
                $actor,
                $entityType,
                trim($validated['label']),
                $identityKey,
            );

            $value = [
                'institution_entity_id' => $institution,
                'label' => trim($validated['label']),
            ];
            if (isset($validated['location_label']) && trim($validated['location_label']) !== '') {
                $value['location_label'] = trim($validated['location_label']);
            }

            $proposal = $this->proposals->propose(
                $actor,
                $locationId,
                $entityType,
                (int) $validated['definition_version'],
                $value,
                $validated['evidence_reference_ids'],
                $this->syntheticSourceContext(),
                $entityType,
                $proposalKey,
                [],
                $validated['valid_from'] ?? null,
                $validated['valid_to'] ?? null,
                $institution,
            );

            return ['entity_id' => $locationId, ...$proposal];
        });

        return response()->json([
            'status' => 'submitted_for_editorial_review',
            'entity_type' => $entityType,
            'entity_id' => $result['entity_id'],
            'claim_id' => $result['claim_id'],
            'claim_version_id' => $result['claim_version_id'],
            'editorial_review_case_id' => $result['editorial_review_case_id'],
            'publication' => 'not_published',
        ], 201);
    }

    private function assertAccess(Request $request, string $institution): array
    {
        abort_unless($this->workflow->isUniversityInstitution($institution), 404);
        $user = $request->user();
        abort_unless($user instanceof User && $user->is_active && $user->email_verified_at !== null, 403);
        abort_unless($this->authorization->allows($user, 'institution.claim.submit', 'institution', $institution), 403);

        return [
            'actor_id' => 'user:'.$user->getKey(),
            'actor_class' => 'human',
            'capabilities' => ['register_directory_entity', 'propose_field_value', 'submit_directory_proposal'],
        ];
    }

    private function scopedIdempotencyKey(string $operation, User $user, string $key): string
    {
        return hash('sha256', $operation.':'.$user->getKey().':'.$key);
    }

    private function syntheticSourceContext(): array
    {
        return [
            'purpose' => 'synthetic_test_only',
            'method' => 'fixture_reference',
            'territory' => 'synthetic',
        ];
    }
}
