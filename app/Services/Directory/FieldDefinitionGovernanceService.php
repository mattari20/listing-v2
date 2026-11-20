<?php

declare(strict_types=1);

namespace App\Services\Directory;

use App\Domain\Governance\GovernancePolicy;
use Carbon\CarbonImmutable;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class FieldDefinitionGovernanceService
{
    private const POLICY_VERSION = 'field-definition-governance-v1';

    private const VALUE_TYPES = [
        'short_text', 'long_text', 'integer', 'decimal', 'boolean', 'date',
        'date_range', 'url', 'email', 'phone', 'enum', 'money', 'duration',
        'language_code', 'entity_reference', 'bounded_object', 'bounded_collection',
    ];

    private const RESTRICTED_CATEGORIES = ['deeni_madaris', 'madrasah', 'deeni_education'];

    public function propose(
        array $actor,
        array $definition,
        string $rationaleCode,
        string $rationale,
        string $idempotencyKey,
        ?string $predecessorVersionId = null
    ): string {
        $this->requireHumanCapability($actor, 'propose_field_definition');
        $this->assertBoundedText($rationaleCode, 100, 'rationale_code');
        $this->assertBoundedText($rationale, 1000, 'rationale');
        $this->assertIdempotencyKey($idempotencyKey);
        $normalized = $this->validateDefinition($definition);
        $fingerprint = $this->fingerprint([
            $actor['actor_id'], $normalized, $rationaleCode, $rationale, $predecessorVersionId,
        ]);

        return DB::transaction(function () use (
            $actor, $normalized, $rationaleCode, $rationale, $idempotencyKey, $predecessorVersionId, $fingerprint
        ): string {
            $prior = DB::table('field_definition_review_cases')->where('idempotency_key', $idempotencyKey)->first();
            if ($prior !== null) {
                $this->assertFingerprint($prior->command_fingerprint, $fingerprint);

                return (string) $prior->field_definition_version_id;
            }

            $existing = DB::table('field_definitions')->where('field_key', $normalized['field_key'])->lockForUpdate()->first();
            if ($predecessorVersionId === null && $existing !== null) {
                $this->reject('field_key', 'A field key is reserved once created; use an explicit successor version.');
            }
            if ($predecessorVersionId !== null && $existing === null) {
                $this->reject('predecessor', 'A successor version must reference an existing field definition.');
            }

            if ($existing === null) {
                $definitionId = (string) Str::uuid();
                DB::table('field_definitions')->insert([
                    'id' => $definitionId,
                    'field_key' => $normalized['field_key'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $versionNumber = 1;
            } else {
                $definitionId = (string) $existing->id;
                $predecessor = DB::table('field_definition_versions')
                    ->where('id', $predecessorVersionId)
                    ->where('field_definition_id', $definitionId)
                    ->lockForUpdate()
                    ->first();
                if ($predecessor === null) {
                    $this->reject('predecessor', 'The predecessor must belong to the same stable field key.');
                }
                $latestVersionNumber = (int) DB::table('field_definition_versions')
                    ->where('field_definition_id', $definitionId)->max('version_number');
                if ((int) $predecessor->version_number !== $latestVersionNumber) {
                    $this->reject('predecessor', 'A successor must reference the latest existing version for this stable field key.');
                }
                if (in_array($predecessor->lifecycle_state, ['active', 'deprecated', 'retired'], true) === false) {
                    $this->reject('predecessor', 'Only an active, deprecated or retired version can have a successor.');
                }
                $versionNumber = (int) DB::table('field_definition_versions')
                    ->where('field_definition_id', $definitionId)
                    ->max('version_number') + 1;
            }

            $versionId = (string) Str::uuid();
            $now = now();
            DB::table('field_definition_versions')->insert([
                'id' => $versionId,
                'field_definition_id' => $definitionId,
                'version_number' => $versionNumber,
                'lifecycle_state' => 'proposed',
                'semantic_version' => $normalized['semantic_version'],
                'compatibility_class' => $normalized['compatibility_class'],
                'value_type' => $normalized['value_type'],
                'cardinality' => $normalized['cardinality'],
                'scope_key' => $normalized['scope_key'],
                'privacy_class' => $normalized['privacy_class'],
                'visibility_class' => $normalized['visibility_class'],
                'searchable' => $normalized['searchable'],
                'filterable' => $normalized['filterable'],
                'sortable' => $normalized['sortable'],
                'validation_schema' => json_encode($normalized['validation_schema'], JSON_THROW_ON_ERROR),
                'presentation_metadata' => json_encode($normalized['presentation_metadata'], JSON_THROW_ON_ERROR),
                'evidence_policy' => json_encode($normalized['evidence_policy'], JSON_THROW_ON_ERROR),
                'freshness_policy' => json_encode($normalized['freshness_policy'], JSON_THROW_ON_ERROR),
                'effective_from' => $normalized['effective_from'],
                'effective_to' => $normalized['effective_to'],
                'successor_field_definition_id' => null,
                'proposed_by_actor_id' => $actor['actor_id'],
                'rationale_reference' => $rationaleCode,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach ($normalized['entity_types'] as $entityType) {
                DB::table('field_definition_version_entity_types')->insert([
                    'id' => (string) Str::uuid(),
                    'field_definition_version_id' => $versionId,
                    'entity_type' => $entityType,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            foreach ($normalized['provider_categories'] as $category) {
                DB::table('field_definition_version_provider_categories')->insert([
                    'id' => (string) Str::uuid(),
                    'field_definition_version_id' => $versionId,
                    'provider_category' => $category,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $caseId = (string) Str::uuid();
            DB::table('field_definition_review_cases')->insert([
                'id' => $caseId,
                'field_definition_version_id' => $versionId,
                'submitted_by_actor_id' => $actor['actor_id'],
                'assigned_reviewer_actor_id' => null,
                'status' => 'submitted',
                'idempotency_key' => $idempotencyKey,
                'command_fingerprint' => $fingerprint,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $decisionId = $this->recordDecision(
                $caseId, 'proposed', $actor, $rationaleCode, $rationale,
                $idempotencyKey, $fingerprint, 'proposal'
            );
            $this->auditAndEnqueue(
                $actor, 'field_definition_proposed', $versionId, null, 'proposed',
                $rationaleCode, $rationale, $caseId, $decisionId, $idempotencyKey, $fingerprint
            );

            return $versionId;
        });
    }

    public function assignReviewer(
        array $actor,
        string $reviewCaseId,
        string $reviewerActorId,
        string $rationaleCode,
        string $rationale,
        string $idempotencyKey
    ): string {
        $this->requireHumanCapability($actor, 'review_field_definition');
        $this->assertActorId($reviewerActorId);
        $this->assertBoundedText($rationaleCode, 100, 'rationale_code');
        $this->assertBoundedText($rationale, 1000, 'rationale');
        $this->assertIdempotencyKey($idempotencyKey);
        $fingerprint = $this->fingerprint([$actor['actor_id'], $reviewCaseId, $reviewerActorId, $rationaleCode, $rationale]);

        return DB::transaction(function () use ($actor, $reviewCaseId, $reviewerActorId, $rationaleCode, $rationale, $idempotencyKey, $fingerprint): string {
            $priorDecision = $this->idempotentDecision($idempotencyKey, $fingerprint);
            if ($priorDecision !== null) {
                return (string) $priorDecision->id;
            }
            $case = $this->lockCase($reviewCaseId);
            if ($case->status !== 'submitted') {
                $this->reject('review_case', 'A reviewer can only be assigned to a submitted or changes-requested case.');
            }
            if ($reviewerActorId === $case->submitted_by_actor_id || $reviewerActorId === $actor['actor_id']) {
                $this->reject('reviewer', 'The proposer and reviewer assigner cannot be assigned as the reviewer.');
            }

            DB::table('field_definition_review_cases')->where('id', $reviewCaseId)->update([
                'assigned_reviewer_actor_id' => $reviewerActorId,
                'status' => 'in_review',
                'updated_at' => now(),
            ]);
            $decisionId = $this->recordDecision($reviewCaseId, 'reviewer_assigned', $actor, $rationaleCode, $rationale, $idempotencyKey, $fingerprint, 'assignment');
            $this->auditAndEnqueue($actor, 'field_definition_reviewer_assigned', $case->field_definition_version_id, $case->status, 'in_review', $rationaleCode, $rationale, $reviewCaseId, $decisionId, $idempotencyKey, $fingerprint);

            return $decisionId;
        });
    }

    public function review(
        array $actor,
        string $reviewCaseId,
        string $outcome,
        string $rationaleCode,
        string $rationale,
        string $idempotencyKey
    ): string {
        $this->requireHumanCapability($actor, 'review_field_definition');
        if (in_array($outcome, ['recommend_approval', 'request_changes', 'reject'], true) === false) {
            $this->reject('outcome', 'Unsupported review outcome.');
        }
        $this->assertBoundedText($rationaleCode, 100, 'rationale_code');
        $this->assertBoundedText($rationale, 1000, 'rationale');
        $this->assertIdempotencyKey($idempotencyKey);
        $fingerprint = $this->fingerprint([$actor['actor_id'], $reviewCaseId, $outcome, $rationaleCode, $rationale]);

        return DB::transaction(function () use ($actor, $reviewCaseId, $outcome, $rationaleCode, $rationale, $idempotencyKey, $fingerprint): string {
            $priorDecision = $this->idempotentDecision($idempotencyKey, $fingerprint);
            if ($priorDecision !== null) {
                return (string) $priorDecision->id;
            }
            $case = $this->lockCase($reviewCaseId);
            if ($case->status !== 'in_review' || $case->assigned_reviewer_actor_id !== $actor['actor_id']) {
                $this->reject('review_case', 'Only the assigned independent reviewer may review this case.');
            }
            if ($actor['actor_id'] === $case->submitted_by_actor_id) {
                $this->reject('reviewer', 'The proposer cannot review their own definition.');
            }

            $next = match ($outcome) {
                'recommend_approval' => 'awaiting_approval',
                'request_changes' => 'changes_requested',
                'reject' => 'rejected',
            };
            DB::table('field_definition_review_cases')->where('id', $reviewCaseId)->update([
                'status' => $next,
                'updated_at' => now(),
            ]);
            $decisionId = $this->recordDecision($reviewCaseId, $outcome, $actor, $rationaleCode, $rationale, $idempotencyKey, $fingerprint, 'review');
            $this->auditAndEnqueue($actor, 'field_definition_reviewed', $case->field_definition_version_id, $case->status, $next, $rationaleCode, $rationale, $reviewCaseId, $decisionId, $idempotencyKey, $fingerprint);

            return $decisionId;
        });
    }

    public function editChangesRequestedProposal(
        array $actor,
        string $reviewCaseId,
        array $definition,
        string $rationaleCode,
        string $rationale,
        string $idempotencyKey
    ): string {
        $this->requireHumanCapability($actor, 'propose_field_definition');
        $normalized = $this->validateDefinition($definition);
        $this->assertBoundedText($rationaleCode, 100, 'rationale_code');
        $this->assertBoundedText($rationale, 1000, 'rationale');
        $this->assertIdempotencyKey($idempotencyKey);
        $fingerprint = $this->fingerprint([$actor['actor_id'], $reviewCaseId, $normalized, $rationaleCode, $rationale]);

        return DB::transaction(function () use ($actor, $reviewCaseId, $normalized, $rationaleCode, $rationale, $idempotencyKey, $fingerprint): string {
            $priorDecision = $this->idempotentDecision($idempotencyKey, $fingerprint);
            if ($priorDecision !== null) {
                return (string) $priorDecision->id;
            }
            $case = $this->lockCase($reviewCaseId);
            if ($case->status !== 'changes_requested' || $case->submitted_by_actor_id !== $actor['actor_id']) {
                $this->reject('review_case', 'Only the original proposer may edit a changes-requested proposal.');
            }
            $version = DB::table('field_definition_versions')->where('id', $case->field_definition_version_id)->lockForUpdate()->first();
            $fieldKey = DB::table('field_definitions')->where('id', $version?->field_definition_id)->value('field_key');
            if ($fieldKey !== $normalized['field_key']) {
                $this->reject('field_key', 'A proposed version cannot be edited to use a different stable field key.');
            }
            if ($version === null || $version->lifecycle_state !== 'proposed') {
                $this->reject('definition', 'Only a proposed definition may be edited.');
            }

            DB::table('field_definition_versions')->where('id', $version->id)->update($this->definitionUpdate($normalized) + ['updated_at' => now()]);
            DB::table('field_definition_version_entity_types')->where('field_definition_version_id', $version->id)->delete();
            DB::table('field_definition_version_provider_categories')->where('field_definition_version_id', $version->id)->delete();
            foreach ($normalized['entity_types'] as $entityType) {
                DB::table('field_definition_version_entity_types')->insert([
                    'id' => (string) Str::uuid(), 'field_definition_version_id' => $version->id,
                    'entity_type' => $entityType, 'created_at' => now(), 'updated_at' => now(),
                ]);
            }
            foreach ($normalized['provider_categories'] as $category) {
                DB::table('field_definition_version_provider_categories')->insert([
                    'id' => (string) Str::uuid(), 'field_definition_version_id' => $version->id,
                    'provider_category' => $category, 'created_at' => now(), 'updated_at' => now(),
                ]);
            }
            DB::table('field_definition_review_cases')->where('id', $reviewCaseId)->update([
                'assigned_reviewer_actor_id' => null,
                'status' => 'submitted',
                'updated_at' => now(),
            ]);
            $decisionId = $this->recordDecision($reviewCaseId, 'proposal_edited', $actor, $rationaleCode, $rationale, $idempotencyKey, $fingerprint, 'edit');
            $this->auditAndEnqueue($actor, 'field_definition_proposal_edited', $version->id, 'changes_requested', 'submitted', $rationaleCode, $rationale, $reviewCaseId, $decisionId, $idempotencyKey, $fingerprint);

            return $decisionId;
        });
    }

    public function approve(
        array $actor,
        string $reviewCaseId,
        string $rationaleCode,
        string $rationale,
        string $idempotencyKey
    ): string {
        $this->requireHumanCapability($actor, 'approve_field_definition');
        $this->assertBoundedText($rationaleCode, 100, 'rationale_code');
        $this->assertBoundedText($rationale, 1000, 'rationale');
        $this->assertIdempotencyKey($idempotencyKey);
        $fingerprint = $this->fingerprint([$actor['actor_id'], $reviewCaseId, $rationaleCode, $rationale]);

        return DB::transaction(function () use ($actor, $reviewCaseId, $rationaleCode, $rationale, $idempotencyKey, $fingerprint): string {
            $priorDecision = $this->idempotentDecision($idempotencyKey, $fingerprint);
            if ($priorDecision !== null) {
                return (string) $priorDecision->id;
            }
            $case = $this->lockCase($reviewCaseId);
            if ($case->status !== 'awaiting_approval' || $case->assigned_reviewer_actor_id === null) {
                $this->reject('review_case', 'Only a reviewed proposal awaiting approval may be approved.');
            }
            if (in_array($actor['actor_id'], [$case->submitted_by_actor_id, $case->assigned_reviewer_actor_id], true)) {
                $this->reject('approver', 'Approver must be distinct from proposer and reviewer.');
            }
            $version = DB::table('field_definition_versions')->where('id', $case->field_definition_version_id)->lockForUpdate()->first();
            if ($version === null || $version->lifecycle_state !== 'proposed') {
                $this->reject('definition', 'Only a proposed definition may be approved.');
            }
            DB::table('field_definition_versions')->where('id', $version->id)->update(['lifecycle_state' => 'approved', 'updated_at' => now()]);
            DB::table('field_definition_review_cases')->where('id', $reviewCaseId)->update(['status' => 'approved', 'updated_at' => now()]);
            $decisionId = $this->recordDecision($reviewCaseId, 'approve', $actor, $rationaleCode, $rationale, $idempotencyKey, $fingerprint, 'approval');
            $this->auditAndEnqueue($actor, 'field_definition_approved', $version->id, 'proposed', 'approved', $rationaleCode, $rationale, $reviewCaseId, $decisionId, $idempotencyKey, $fingerprint);

            return $decisionId;
        });
    }

    public function activate(
        array $actor,
        string $reviewCaseId,
        string $rationaleCode,
        string $rationale,
        string $idempotencyKey
    ): string {
        $this->requireHumanCapability($actor, 'activate_field_definition');
        $this->assertBoundedText($rationaleCode, 100, 'rationale_code');
        $this->assertBoundedText($rationale, 1000, 'rationale');
        $this->assertIdempotencyKey($idempotencyKey);
        $fingerprint = $this->fingerprint([$actor['actor_id'], $reviewCaseId, $rationaleCode, $rationale]);

        return DB::transaction(function () use ($actor, $reviewCaseId, $rationaleCode, $rationale, $idempotencyKey, $fingerprint): string {
            $priorDecision = $this->idempotentDecision($idempotencyKey, $fingerprint);
            if ($priorDecision !== null) {
                return (string) $priorDecision->id;
            }
            $case = $this->lockCase($reviewCaseId);
            if ($case->status !== 'approved') {
                $this->reject('review_case', 'Only an approved definition may be activated.');
            }
            if ($actor['actor_id'] === $case->submitted_by_actor_id) {
                $this->reject('activator', 'The proposer cannot activate their own definition.');
            }
            $approval = DB::table('field_definition_review_decisions')
                ->where('review_case_id', $reviewCaseId)->where('outcome', 'approve')
                ->orderByDesc('decided_at')->first();
            if ($approval === null || $approval->actor_id === $actor['actor_id']) {
                $this->reject('activator', 'Activation requires a human distinct from the approver.');
            }

            $version = DB::table('field_definition_versions')->where('id', $case->field_definition_version_id)->lockForUpdate()->first();
            if ($version === null || $version->lifecycle_state !== 'approved') {
                $this->reject('definition', 'Only an approved definition may be activated.');
            }
            $now = now();
            if ($version->effective_from !== null && now()->lt($version->effective_from)) {
                $this->reject('effective_from', 'A definition cannot be activated before its effective start.');
            }
            if ($version->effective_to !== null && now()->gte($version->effective_to)) {
                $this->reject('effective_to', 'An expired definition cannot be activated.');
            }
            // Serialize activations for this stable key before checking the single-active invariant.
            DB::table('field_definitions')->where('id', $version->field_definition_id)->lockForUpdate()->first();
            $active = DB::table('field_definition_versions')
                ->where('field_definition_id', $version->field_definition_id)
                ->where('lifecycle_state', 'active')
                ->lockForUpdate()->first();
            if ($active !== null) {
                $this->reject('active_version', 'Retire the prior active version before activating its successor.');
            }

            DB::table('field_definition_versions')->where('id', $version->id)->update(['lifecycle_state' => 'active', 'updated_at' => $now]);
            $decisionId = $this->recordDecision($reviewCaseId, 'activate', $actor, $rationaleCode, $rationale, $idempotencyKey, $fingerprint, 'activation');
            $this->auditAndEnqueue($actor, 'field_definition_activated', $version->id, 'approved', 'active', $rationaleCode, $rationale, $reviewCaseId, $decisionId, $idempotencyKey, $fingerprint);

            return $decisionId;
        });
    }

    public function deprecate(
        array $actor,
        string $reviewCaseId,
        string $effectiveTo,
        string $rationaleCode,
        string $rationale,
        string $idempotencyKey
    ): string {
        $this->requireHumanCapability($actor, 'retire_field_definition');
        $this->assertBoundedText($rationaleCode, 100, 'rationale_code');
        $this->assertBoundedText($rationale, 1000, 'rationale');
        $this->assertIdempotencyKey($idempotencyKey);
        $fingerprint = $this->fingerprint([$actor['actor_id'], $reviewCaseId, $effectiveTo, $rationaleCode, $rationale]);

        return DB::transaction(function () use ($actor, $reviewCaseId, $effectiveTo, $rationaleCode, $rationale, $idempotencyKey, $fingerprint): string {
            $priorDecision = $this->idempotentDecision($idempotencyKey, $fingerprint);
            if ($priorDecision !== null) {
                return (string) $priorDecision->id;
            }
            $case = $this->lockCase($reviewCaseId);
            $version = DB::table('field_definition_versions')->where('id', $case->field_definition_version_id)->lockForUpdate()->first();
            if ($version === null || $version->lifecycle_state !== 'active') {
                $this->reject('definition', 'Only an active definition may be deprecated.');
            }
            DB::table('field_definitions')->where('id', $version->field_definition_id)->lockForUpdate()->first();
            $end = $this->parseDate($effectiveTo);
            if ($end === null || CarbonImmutable::parse($end)->lessThanOrEqualTo(now())) {
                $this->reject('effective_to', 'Deprecation must use a valid future effective boundary.');
            }
            DB::table('field_definition_versions')->where('id', $version->id)->update([
                'lifecycle_state' => 'deprecated',
                'effective_to' => $end,
                'updated_at' => now(),
            ]);
            $decisionId = $this->recordDecision($reviewCaseId, 'deprecate', $actor, $rationaleCode, $rationale, $idempotencyKey, $fingerprint, 'deprecation');
            $this->auditAndEnqueue($actor, 'field_definition_deprecated', $version->id, 'active', 'deprecated', $rationaleCode, $rationale, $reviewCaseId, $decisionId, $idempotencyKey, $fingerprint);

            return $decisionId;
        });
    }

    public function retire(
        array $actor,
        string $reviewCaseId,
        string $rationaleCode,
        string $rationale,
        string $idempotencyKey,
        ?string $successorFieldKey = null
    ): string {
        $this->requireHumanCapability($actor, 'retire_field_definition');
        $this->assertBoundedText($rationaleCode, 100, 'rationale_code');
        $this->assertBoundedText($rationale, 1000, 'rationale');
        $this->assertIdempotencyKey($idempotencyKey);
        $fingerprint = $this->fingerprint([$actor['actor_id'], $reviewCaseId, $rationaleCode, $rationale, $successorFieldKey]);

        return DB::transaction(function () use ($actor, $reviewCaseId, $rationaleCode, $rationale, $idempotencyKey, $successorFieldKey, $fingerprint): string {
            $priorDecision = $this->idempotentDecision($idempotencyKey, $fingerprint);
            if ($priorDecision !== null) {
                return (string) $priorDecision->id;
            }
            $case = $this->lockCase($reviewCaseId);
            $version = DB::table('field_definition_versions')->where('id', $case->field_definition_version_id)->lockForUpdate()->first();
            if ($version === null || in_array($version->lifecycle_state, ['active', 'deprecated'], true) === false) {
                $this->reject('definition', 'Only an active or deprecated definition may be retired.');
            }
            DB::table('field_definitions')->where('id', $version->field_definition_id)->lockForUpdate()->first();
            $successorId = null;
            if ($successorFieldKey !== null) {
                $successorId = DB::table('field_definitions')->where('field_key', $successorFieldKey)->value('id');
                if ($successorId === null || $successorId === $version->field_definition_id) {
                    $this->reject('successor', 'Successor must be a different existing field key.');
                }
            }
            if ($version->successor_field_definition_id !== null && (string) $version->successor_field_definition_id !== (string) $successorId) {
                $this->reject('successor', 'A recorded successor mapping cannot be changed.');
            }
            DB::table('field_definition_versions')->where('id', $version->id)->update([
                'lifecycle_state' => 'retired',
                'effective_to' => $version->effective_to ?? now(),
                'successor_field_definition_id' => $successorId,
                'updated_at' => now(),
            ]);
            $decisionId = $this->recordDecision($reviewCaseId, 'retire', $actor, $rationaleCode, $rationale, $idempotencyKey, $fingerprint, 'retirement');
            $this->auditAndEnqueue($actor, 'field_definition_retired', $version->id, $version->lifecycle_state, 'retired', $rationaleCode, $rationale, $reviewCaseId, $decisionId, $idempotencyKey, $fingerprint);

            return $decisionId;
        });
    }

    public function restore(
        array $actor,
        string $retiredReviewCaseId,
        array $definition,
        string $rationaleCode,
        string $rationale,
        string $idempotencyKey
    ): string {
        $this->requireHumanCapability($actor, 'propose_field_definition');
        $priorCase = DB::table('field_definition_review_cases')->where('id', $retiredReviewCaseId)->first();
        if ($priorCase === null) {
            $this->reject('review_case', 'The retired field definition review case does not exist.');
        }
        $priorVersion = DB::table('field_definition_versions')->where('id', $priorCase->field_definition_version_id)->first();
        if ($priorVersion === null || $priorVersion->lifecycle_state !== 'retired') {
            $this->reject('definition', 'Only a retired field definition can be restored through a new version.');
        }
        $definition['field_key'] = DB::table('field_definitions')->where('id', $priorVersion->field_definition_id)->value('field_key');
        $newVersionId = $this->propose($actor, $definition, $rationaleCode, $rationale, $idempotencyKey, (string) $priorVersion->id);
        $case = DB::table('field_definition_review_cases')->where('field_definition_version_id', $newVersionId)->first();

        return (string) $case->id;
    }

    private function validateDefinition(array $definition): array
    {
        $allowed = [
            'field_key', 'semantic_version', 'compatibility_class', 'value_type', 'cardinality',
            'scope_key', 'privacy_class', 'visibility_class', 'searchable', 'filterable', 'sortable',
            'validation_schema', 'presentation_metadata', 'evidence_policy', 'freshness_policy',
            'effective_from', 'effective_to', 'entity_types', 'provider_categories',
        ];
        if (array_diff(array_keys($definition), $allowed) !== []) {
            $this->reject('definition', 'Definition contains unsupported properties.');
        }
        $fieldKey = $definition['field_key'] ?? null;
        if (is_string($fieldKey) === false || app(TypedFieldValueValidator::class)->validateFieldKey($fieldKey)['valid'] === false) {
            $this->reject('field_key', 'Field key must use canonical lowercase snake_case.');
        }
        foreach (['semantic_version' => 40, 'compatibility_class' => 40, 'value_type' => 32, 'cardinality' => 24, 'scope_key' => 48, 'privacy_class' => 32, 'visibility_class' => 32] as $key => $max) {
            if (is_string($definition[$key] ?? null) === false || $definition[$key] === '' || strlen($definition[$key]) > $max) {
                $this->reject($key, 'A bounded non-empty '.$key.' is required.');
            }
        }
        if (in_array($definition['value_type'], self::VALUE_TYPES, true) === false ||
            in_array($definition['cardinality'], ['one', 'zero_or_one', 'many'], true) === false ||
            in_array($definition['scope_key'], ['institution', 'programme'], true) === false ||
            in_array($definition['privacy_class'], ['public_eligible', 'editorial_restricted'], true) === false ||
            in_array($definition['visibility_class'], ['public_eligible', 'editorial_restricted', 'internal_only', 'restricted'], true) === false) {
            $this->reject('definition', 'Type, cardinality, scope, privacy or visibility is unsupported by the bounded I4 package.');
        }
        if (preg_match('/^\d+\.\d+\.\d+(?:-[a-z0-9.-]+)?$/D', $definition['semantic_version']) !== 1 ||
            preg_match('/^[a-z][a-z0-9_]{0,39}$/D', $definition['compatibility_class']) !== 1) {
            $this->reject('definition', 'Semantic version or compatibility class is invalid.');
        }
        foreach (['searchable', 'filterable', 'sortable'] as $flag) {
            if (is_bool($definition[$flag] ?? null) === false) {
                $this->reject($flag, 'Search/filter/sort eligibility must be explicitly boolean.');
            }
        }
        foreach (['validation_schema', 'presentation_metadata', 'evidence_policy', 'freshness_policy'] as $key) {
            if (is_array($definition[$key] ?? null) === false || strlen(json_encode($definition[$key], JSON_THROW_ON_ERROR)) > 16000) {
                $this->reject($key, 'A bounded JSON object is required.');
            }
        }
        if (is_int($definition['validation_schema']['schema_version'] ?? null) === false || $definition['validation_schema']['schema_version'] < 1) {
            $this->reject('validation_schema', 'A positive validation schema version is required.');
        }
        if (isset($definition['freshness_policy']['max_age_days']) &&
            (is_int($definition['freshness_policy']['max_age_days']) === false || $definition['freshness_policy']['max_age_days'] < 0)) {
            $this->reject('freshness_policy', 'Freshness max_age_days must be a non-negative integer.');
        }
        if (isset($definition['evidence_policy']['accepted_reference_kinds']) &&
            (is_array($definition['evidence_policy']['accepted_reference_kinds']) === false || $definition['evidence_policy']['accepted_reference_kinds'] === [])) {
            $this->reject('evidence_policy', 'Accepted evidence reference kinds must be a non-empty allowlist.');
        }
        $entityTypes = $definition['entity_types'] ?? null;
        $categories = $definition['provider_categories'] ?? null;
        $expectedEntityTypes = $definition['scope_key'] === 'programme' ? ['programme'] : ['institution'];
        if (is_array($entityTypes) === false || $entityTypes !== $expectedEntityTypes ||
            is_array($categories) === false || $categories === [] || count($categories) > 30) {
            $this->reject('applicability', 'Applicability must explicitly match the institution or programme scope and include a bounded provider-category allowlist.');
        }
        foreach ($categories as $category) {
            if (is_string($category) === false || preg_match('/^[a-z][a-z0-9_]{1,63}$/D', $category) !== 1 ||
                in_array($category, self::RESTRICTED_CATEGORIES, true)) {
                $this->reject('provider_categories', 'Provider categories must be explicit and must exclude restricted categories.');
            }
        }
        if (count(array_unique($categories)) !== count($categories)) {
            $this->reject('provider_categories', 'Provider categories must be unique.');
        }
        $from = $this->parseDate($definition['effective_from'] ?? null);
        $to = $this->parseDate($definition['effective_to'] ?? null);
        if (($definition['effective_from'] ?? null) !== null && $from === null ||
            ($definition['effective_to'] ?? null) !== null && $to === null ||
            $from !== null && $to !== null && $to <= $from) {
            $this->reject('effective_dates', 'Effective dates must be valid and end after start.');
        }

        $definition['effective_from'] = $from;
        $definition['effective_to'] = $to;
        $definition['entity_types'] = array_values($entityTypes);
        $definition['provider_categories'] = array_values($categories);

        return $definition;
    }

    private function definitionUpdate(array $definition): array
    {
        return [
            'semantic_version' => $definition['semantic_version'],
            'compatibility_class' => $definition['compatibility_class'],
            'value_type' => $definition['value_type'],
            'cardinality' => $definition['cardinality'],
            'scope_key' => $definition['scope_key'],
            'privacy_class' => $definition['privacy_class'],
            'visibility_class' => $definition['visibility_class'],
            'searchable' => $definition['searchable'],
            'filterable' => $definition['filterable'],
            'sortable' => $definition['sortable'],
            'validation_schema' => json_encode($definition['validation_schema'], JSON_THROW_ON_ERROR),
            'presentation_metadata' => json_encode($definition['presentation_metadata'], JSON_THROW_ON_ERROR),
            'evidence_policy' => json_encode($definition['evidence_policy'], JSON_THROW_ON_ERROR),
            'freshness_policy' => json_encode($definition['freshness_policy'], JSON_THROW_ON_ERROR),
            'effective_from' => $definition['effective_from'],
            'effective_to' => $definition['effective_to'],
        ];
    }

    private function lockCase(string $caseId): object
    {
        $case = DB::table('field_definition_review_cases')->where('id', $caseId)->lockForUpdate()->first();
        if ($case === null) {
            $this->reject('review_case', 'Field definition review case was not found.');
        }

        return $case;
    }

    private function recordDecision(
        string $caseId,
        string $outcome,
        array $actor,
        string $rationaleCode,
        string $rationale,
        string $idempotencyKey,
        string $fingerprint,
        string $eventSuffix
    ): string {
        $id = (string) Str::uuid();
        DB::table('field_definition_review_decisions')->insert([
            'id' => $id,
            'review_case_id' => $caseId,
            'outcome' => $outcome,
            'actor_id' => $actor['actor_id'],
            'actor_class' => $actor['actor_class'],
            'rationale_code' => $rationaleCode,
            'rationale' => $rationale,
            'policy_version' => self::POLICY_VERSION,
            'idempotency_key' => $idempotencyKey,
            'command_fingerprint' => $fingerprint,
            'decided_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $id;
    }

    private function idempotentDecision(string $key, string $fingerprint): ?object
    {
        $prior = DB::table('field_definition_review_decisions')->where('idempotency_key', $key)->first();
        if ($prior === null) {
            return null;
        }
        $this->assertFingerprint($prior->command_fingerprint, $fingerprint);

        return $prior;
    }

    private function auditAndEnqueue(
        array $actor,
        string $action,
        string $versionId,
        ?string $previousState,
        string $nextState,
        string $reasonCode,
        string $rationale,
        string $caseId,
        string $decisionId,
        string $idempotencyKey,
        string $fingerprint
    ): void {
        $metadata = [
            'actor_id' => $actor['actor_id'],
            'prior_state' => $previousState,
            'new_state' => $nextState,
            'policy_version' => self::POLICY_VERSION,
            'rationale' => $rationale,
            'review_case_id' => $caseId,
            'decision_id' => $decisionId,
            'idempotency_key' => $idempotencyKey,
            'idempotency_fingerprint' => $fingerprint,
        ];
        DB::table('audit_events')->insert([
            'id' => (string) Str::uuid(),
            'actor_class' => $actor['actor_class'],
            'action' => $action,
            'target_type' => 'field_definition_version',
            'target_id' => $versionId,
            'reason_code' => $reasonCode,
            'occurred_at' => now(),
            'metadata' => json_encode($metadata, JSON_THROW_ON_ERROR),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $versionState = DB::table('field_definition_versions')->where('id', $versionId)->value('lifecycle_state');
        $caseStatus = DB::table('field_definition_review_cases')->where('id', $caseId)->value('status');
        DB::table('governance_outbox')->insert([
            'id' => (string) Str::uuid(),
            'event_type' => 'field_definition.lifecycle.changed',
            'aggregate_type' => 'field_definition_version',
            'aggregate_id' => $versionId,
            'payload' => json_encode([
                'field_definition_version_id' => $versionId,
                'review_case_id' => $caseId,
                'decision_id' => $decisionId,
                'action' => $action,
                'prior_case_status' => $previousState,
                'review_case_status' => $caseStatus,
                'lifecycle_state' => $versionState,
                'actor_id' => $actor['actor_id'],
                'actor_class' => $actor['actor_class'],
                'idempotency_key' => $idempotencyKey,
                'idempotency_fingerprint' => $fingerprint,
            ], JSON_THROW_ON_ERROR),
            'idempotency_key' => 'field-definition:'.$idempotencyKey,
            'status' => 'pending',
            'attempts' => 0,
            'available_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function requireHumanCapability(array $actor, string $capability): void
    {
        $decision = (new GovernancePolicy)->requireCapability($actor, $capability);
        if ($decision['allowed'] === false || ($actor['actor_class'] ?? null) !== 'human' ||
            is_string($actor['actor_id'] ?? null) === false || $actor['actor_id'] === '' || strlen($actor['actor_id']) > 120) {
            $this->reject('actor', 'A human actor with the exact I4 capability is required.');
        }
    }

    private function assertActorId(string $id): void
    {
        if ($id === '' || strlen($id) > 120) {
            $this->reject('reviewer', 'A bounded reviewer actor identifier is required.');
        }
    }

    private function assertBoundedText(string $value, int $maximum, string $field): void
    {
        if ($value === '' || strlen($value) > $maximum) {
            $this->reject($field, 'A non-empty bounded '.$field.' is required.');
        }
    }

    private function assertIdempotencyKey(string $key): void
    {
        if ($key === '' || strlen($key) > 160) {
            $this->reject('idempotency_key', 'A non-empty idempotency key of at most 160 characters is required.');
        }
    }

    private function fingerprint(array $value): string
    {
        return hash('sha256', json_encode($value, JSON_THROW_ON_ERROR));
    }

    private function assertFingerprint(string $stored, string $provided): void
    {
        if (hash_equals($stored, $provided) === false) {
            $this->reject('idempotency_key', 'The idempotency key was reused with different command content.');
        }
    }

    private function parseDate(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }
        if (is_string($value) === false) {
            return null;
        }
        try {
            $date = new DateTimeImmutable($value);

            return $date->format('Y-m-d H:i:s');
        } catch (\Throwable) {
            return null;
        }
    }

    private function reject(string $key, string $message): never
    {
        throw ValidationException::withMessages([$key => $message]);
    }
}
