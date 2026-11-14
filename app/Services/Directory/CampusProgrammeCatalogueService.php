<?php

declare(strict_types=1);

namespace App\\Services\\Directory;

use App\\Domain\\Governance\\GovernancePolicy;
use Illuminate\\Support\\Facades\\DB;
use Illuminate\\Support\\Str;
use Illuminate\\Validation\\ValidationException;

final class CampusProgrammeCatalogueService
{
    private const TYPES = [
        'campus' => 'campus',
        'delivery_site' => 'delivery_site',
        'programme' => 'programme',
        'qualification' => 'qualification',
        'awarding_body' => 'awarding_body',
    ];

    public function materializeAcceptedRecord(array $actor, string $claimVersionId, string $idempotencyKey): string
    {
        $capability = (new GovernancePolicy)->requireCapability($actor, 'materialize_catalogue_record');
        if ($capability['allowed'] === false || ($actor['actor_class'] ?? null) !== 'human' || trim($idempotencyKey) === '') {
            throw ValidationException::withMessages(['actor' => 'A human materialize_catalogue_record capability and idempotency key are required.']);
        }

        return DB::transaction(function () use ($actor, $claimVersionId, $idempotencyKey): string {
            $fingerprint = hash('sha256', json_encode([$actor['actor_id'], $claimVersionId], JSON_THROW_ON_ERROR));
            $prior = DB::table('audit_events')
                ->where('action', 'campus_programme_record_materialized')
                ->where('metadata->idempotency_key', $idempotencyKey)
                ->first(['target_id', 'metadata']);
            if ($prior !== null) {
                $metadata = json_decode((string) $prior->metadata, true) ?: [];
                if (($metadata['fingerprint'] ?? null) !== $fingerprint || ($metadata['actor_id'] ?? null) !== $actor['actor_id']) {
                    throw ValidationException::withMessages(['idempotency_key' => 'Key reused for a different catalogue command.']);
                }

                return (string) $prior->target_id;
            }

            $version = DB::table('claim_versions')->where('id', $claimVersionId)->lockForUpdate()->first();
            if ($version === null || $version->disposition !== 'accepted' || DB::table('claim_versions')->where('supersedes_version_id', $claimVersionId)->exists()) {
                throw ValidationException::withMessages(['claim_version' => 'A current accepted claim version is required.']);
            }
            $claim = DB::table('claims')->where('id', $version->claim_id)->first();
            if ($claim === null || isset(self::TYPES[$claim->predicate]) === false) {
                throw ValidationException::withMessages(['claim' => 'Unsupported P02 catalogue claim predicate.']);
            }
            $decision = DB::table('adjudication_decisions')
                ->join('adjudication_cases', 'adjudication_cases.id', '=', 'adjudication_decisions.adjudication_case_id')
                ->where('adjudication_cases.claim_version_id', $claimVersionId)
                ->where('adjudication_decisions.outcome', 'accepted')
                ->where('adjudication_decisions.actor_class', 'human')
                ->orderByDesc('adjudication_decisions.decided_at')
                ->first(['adjudication_decisions.actor_id']);
            if ($decision === null || $decision->actor_id === $actor['actor_id']) {
                throw ValidationException::withMessages(['adjudication' => 'A distinct human adjudicator is required.']);
            }

            $evidence = DB::table('claim_evidence_links')
                ->join('evidence_references', 'evidence_references.id', '=', 'claim_evidence_links.evidence_reference_id')
                ->join('source_authorizations', 'source_authorizations.id', '=', 'evidence_references.source_authorization_id')
                ->where('claim_evidence_links.claim_version_id', $claimVersionId)
                ->get(['evidence_references.id', 'evidence_references.status', 'source_authorizations.revoked_at']);
            if ($evidence->isEmpty()) {
                throw ValidationException::withMessages(['evidence' => 'Supporting evidence is required.']);
            }
            foreach ($evidence as $item) {
                if ($item->status !== 'eligible_for_review' || $item->revoked_at !== null) {
                    throw ValidationException::withMessages(['evidence' => 'Evidence must remain admissible and unrevoked.']);
                }
                $event = DB::table('audit_events')->where('target_type', 'evidence_reference')->where('target_id', $item->id)->where('action', 'evidence_reference_registered')->value('metadata');
                $evidenceActor = is_string($event) ? (json_decode($event, true)['actor_id'] ?? null) : null;
                if ($evidenceActor === $actor['actor_id']) {
                    throw ValidationException::withMessages(['actor' => 'An evidence submitter cannot materialize the catalogue record.']);
                }
            }

            $value = json_decode((string) $version->value, true);
            if (is_array($value) === false) {
                throw ValidationException::withMessages(['claim_value' => 'Claim value must be a JSON object.']);
            }
            $subject = DB::table('directory_entities')->where('id', $claim->subject_entity_id)->first(['id', 'entity_type']);
            if ($subject === null || $subject->entity_type !== self::TYPES[$claim->predicate]) {
                throw ValidationException::withMessages(['subject' => 'Claim subject identity type does not match its catalogue predicate.']);
            }

            $targetId = (string) $subject->id;
            $now = now();
            switch ($claim->predicate) {
                case 'campus':
                    $institution = $this->requireEntity($value['institution_entity_id'] ?? null, 'institution');
                    $this->assertDates($version->valid_from, $version->valid_to);
                    DB::table('directory_campuses')->insert([
                        'entity_id' => $targetId, 'institution_entity_id' => $institution,
                        'location_label' => $this->nullableText($value['location_label'] ?? null),
                        'status' => 'active', 'valid_from' => $version->valid_from, 'valid_to' => $version->valid_to,
                        'claim_version_id' => $claimVersionId, 'created_at' => $now, 'updated_at' => $now,
                    ]);
                    break;
                case 'delivery_site':
                    $institution = $this->requireEntity($value['institution_entity_id'] ?? null, 'institution');
                    $this->assertDates($version->valid_from, $version->valid_to);
                    DB::table('directory_delivery_sites')->insert([
                        'entity_id' => $targetId, 'institution_entity_id' => $institution,
                        'location_label' => $this->nullableText($value['location_label'] ?? null),
                        'status' => 'active', 'valid_from' => $version->valid_from, 'valid_to' => $version->valid_to,
                        'claim_version_id' => $claimVersionId, 'created_at' => $now, 'updated_at' => $now,
                    ]);
                    break;
                case 'programme':
                    $title = trim((string) ($value['title'] ?? ''));
                    if ($title === '' || mb_strlen($title) > 255) {
                        throw ValidationException::withMessages(['title' => 'A programme title of 1–255 characters is required.']);
                    }
                    DB::table('programme_catalogue_entries')->insert([
                        'entity_id' => $targetId, 'title' => $title,
                        'description' => $this->nullableText($value['description'] ?? null),
                        'level' => $this->nullableText($value['level'] ?? null),
                        'status' => 'active', 'claim_version_id' => $claimVersionId,
                        'created_at' => $now, 'updated_at' => $now,
                    ]);
                    break;
                case 'qualification':
                case 'awarding_body':
                    throw ValidationException::withMessages(['claim' => 'Qualification and awarding-body identities are reserved for explicit programme qualification links; no implicit association is materialized.']);
                case 'programme_qualification':
                    $programme = $this->requireEntity($value['programme_entity_id'] ?? null, 'programme');
                    $qualification = $this->requireEntity($value['qualification_entity_id'] ?? null, 'qualification');
                    $awarder = $this->requireEntity($value['awarding_body_entity_id'] ?? null, 'awarding_body');
                    $id = (string) Str::uuid();
                    DB::table('programme_qualification_links')->insert([
                        'id' => $id, 'programme_entity_id' => $programme, 'qualification_entity_id' => $qualification,
                        'awarding_body_entity_id' => $awarder, 'status' => 'active', 'claim_version_id' => $claimVersionId,
                        'created_at' => $now, 'updated_at' => $now,
                    ]);
                    $targetId = $id;
                    break;
                case 'programme_offer':
                    $programme = $this->requireEntity($value['programme_entity_id'] ?? null, 'programme');
                    $location = $this->requireDeliveryLocation($value['delivery_location_entity_id'] ?? null);
                    $cycle = trim((string) ($value['admission_cycle'] ?? ''));
                    if ($cycle === '' || mb_strlen($cycle) > 80) {
                        throw ValidationException::withMessages(['admission_cycle' => 'An explicit admission cycle is required.']);
                    }
                    $this->assertDates($version->valid_from, $version->valid_to);
                    $id = (string) Str::uuid();
                    DB::table('programme_offers')->insert([
                        'id' => $id, 'programme_entity_id' => $programme, 'delivery_location_entity_id' => $location,
                        'admission_cycle' => $cycle, 'status' => 'active', 'valid_from' => $version->valid_from,
                        'valid_to' => $version->valid_to, 'claim_version_id' => $claimVersionId,
                        'created_at' => $now, 'updated_at' => $now,
                    ]);
                    $targetId = $id;
                    break;
                default:
                    throw ValidationException::withMessages(['claim' => 'Unsupported P02 catalogue command.']);
            }

            DB::table('audit_events')->insert([
                'id' => (string) Str::uuid(), 'actor_class' => $actor['actor_class'],
                'action' => 'campus_programme_record_materialized', 'target_type' => $claim->predicate,
                'target_id' => $targetId, 'reason_code' => 'accepted_governed_p02_projection',
                'occurred_at' => $now,
                'metadata' => json_encode(['actor_id' => $actor['actor_id'], 'claim_version_id' => $claimVersionId, 'idempotency_key' => $idempotencyKey, 'fingerprint' => $fingerprint], JSON_THROW_ON_ERROR),
                'created_at' => $now, 'updated_at' => $now,
            ]);

            return $targetId;
        });
    }

    private function requireEntity(mixed $id, string $type): string
    {
        if (is_string($id) === false || $id === '') {
            throw ValidationException::withMessages(['entity' => 'A typed entity reference is required.']);
        }
        $entity = DB::table('directory_entities')->where('id', $id)->first(['id', 'entity_type']);
        if ($entity === null || $entity->entity_type !== $type) {
            throw ValidationException::withMessages(['entity' => 'Referenced entity does not have the required identity type.']);
        }

        return (string) $entity->id;
    }

    private function requireDeliveryLocation(mixed $id): string
    {
        if (is_string($id) === false) {
            throw ValidationException::withMessages(['delivery_location' => 'An explicit campus or delivery-site identity is required.']);
        }
        $entity = DB::table('directory_entities')->where('id', $id)->first(['id', 'entity_type']);
        if ($entity === null || in_array($entity->entity_type, ['campus', 'delivery_site'], true) === false) {
            throw ValidationException::withMessages(['delivery_location' => 'Programme offers require a campus or delivery-site identity.']);
        }

        return (string) $entity->id;
    }

    private function assertDates(?string $from, ?string $to): void
    {
        if ($from !== null && $to !== null && $to < $from) {
            throw ValidationException::withMessages(['validity' => 'End date cannot precede start date.']);
        }
    }

    private function nullableText(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }
        if (is_string($value) === false || mb_strlen($value) > 5000) {
            throw ValidationException::withMessages(['text' => 'Optional text must be a string of at most 5000 characters.']);
        }

        return trim($value);
    }
}
