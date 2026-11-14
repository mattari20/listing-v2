<?php

declare(strict_types=1);

namespace App\Services\Directory;

use App\Domain\Governance\GovernancePolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class ProviderCategoryAssignmentService
{
    /**
     * Initial controlled vocabulary is deliberately limited to D4's four synthetic pilot categories.
     * Taxonomy expansion is a separately reviewed decision.
     */
    private const PILOT_CATEGORIES = ['private_school', 'college', 'academy', 'university'];

    public function assign(array $actor, string $entityId, string $providerCategory, string $reasonCode, string $idempotencyKey): void
    {
        $this->requireHumanCapability($actor, 'assign_provider_category');

        if (in_array($providerCategory, self::PILOT_CATEGORIES, true) === false) {
            $this->reject('provider_category', 'Provider category is outside the controlled I3 pilot vocabulary.');
        }
        if (trim($reasonCode) === '' || strlen($reasonCode) > 100 || trim($idempotencyKey) === '' || strlen($idempotencyKey) > 160) {
            $this->reject('assignment', 'A bounded reason code and idempotency key are required.');
        }

        DB::transaction(function () use ($actor, $entityId, $providerCategory, $reasonCode, $idempotencyKey): void {
            $entity = DB::table('directory_entities')->where('id', $entityId)->lockForUpdate()->first();
            if ($entity === null || $entity->entity_type !== 'institution') {
                $this->reject('entity', 'Provider categories may be assigned only to an existing institution entity.');
            }

            $fingerprint = hash('sha256', json_encode([
                $actor['actor_id'], $actor['actor_class'], $entityId, $providerCategory, $reasonCode,
            ], JSON_THROW_ON_ERROR));
            $prior = DB::table('audit_events')
                ->where('action', 'provider_category_assigned')
                ->where('metadata->idempotency_key', $idempotencyKey)
                ->first(['target_id', 'metadata']);

            if ($prior !== null) {
                $metadata = json_decode((string) $prior->metadata, true);
                if (! is_array($metadata) || ! hash_equals((string) ($metadata['idempotency_fingerprint'] ?? ''), $fingerprint)) {
                    $this->reject('idempotency_key', 'The idempotency key was already used for a different assignment.');
                }

                return;
            }

            $now = now();
            $previous = DB::table('directory_provider_category_assignments')->where('entity_id', $entityId)->value('provider_category');
            $assignment = [
                'provider_category' => $providerCategory,
                'assigned_by_actor_id' => $actor['actor_id'],
                'reason_code' => $reasonCode,
                'idempotency_key' => $idempotencyKey,
                'fingerprint' => $fingerprint,
                'assigned_at' => $now,
                'updated_at' => $now,
            ];
            if ($previous === null) {
                DB::table('directory_provider_category_assignments')->insert(
                    ['entity_id' => $entityId, 'created_at' => $now] + $assignment
                );
            } else {
                DB::table('directory_provider_category_assignments')->where('entity_id', $entityId)->update($assignment);
            }

            DB::table('audit_events')->insert([
                'id' => (string) Str::uuid(),
                'actor_class' => $actor['actor_class'],
                'action' => 'provider_category_assigned',
                'target_type' => 'directory_entity',
                'target_id' => $entityId,
                'reason_code' => $reasonCode,
                'occurred_at' => $now,
                'metadata' => json_encode([
                    'actor_id' => $actor['actor_id'],
                    'provider_category' => $providerCategory,
                    'previous_provider_category' => $previous,
                    'idempotency_key' => $idempotencyKey,
                    'idempotency_fingerprint' => $fingerprint,
                ], JSON_THROW_ON_ERROR),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        });
    }

    /** @return list<string> */
    public function allowedPilotCategories(): array
    {
        return self::PILOT_CATEGORIES;
    }

    private function requireHumanCapability(array $actor, string $capability): void
    {
        $decision = (new GovernancePolicy)->requireCapability($actor, $capability);
        if ($decision['allowed'] === false || ($actor['actor_class'] ?? null) !== 'human') {
            $this->reject('actor', 'A human actor with the required capability is required.');
        }
    }

    private function reject(string $field, string $message): never
    {
        throw ValidationException::withMessages([$field => $message]);
    }
}
