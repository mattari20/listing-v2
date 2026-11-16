<?php

declare(strict_types=1);

namespace App\\Services\\Directory;

use Illuminate\\Support\\Facades\\DB;
use Illuminate\\Support\\Str;
use Illuminate\\Validation\\ValidationException;

final class AgentFieldProposalSubmissionService
{
    private const AGENT_ID = 'synthetic-agent-proposal-adapter-v1';

    private const FIXTURE_ID = 'synthetic-institution-alpha-v1';

    /**
     * Submit the one fixed synthetic fixture. Candidate field, version, value,
     * scope and source context are fixed inside the I3 service, never supplied here.
     *
     * @param  list<string>  $evidenceReferenceIds
     * @return array{claim_id: string, claim_version_id: string, editorial_review_case_id: string}
     */
    public function submit(string $fixtureId, string $subjectEntityId, array $evidenceReferenceIds, string $idempotencyKey): array
    {
        if ($fixtureId !== self::FIXTURE_ID) {
            $this->reject('fixture', 'Unknown synthetic agent fixture.');
        }

        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-8][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/iD', $subjectEntityId) !== 1 ||
            preg_match('/^i6-synthetic-agent-[0-9a-f]{64}$/D', $idempotencyKey) !== 1 ||
            $evidenceReferenceIds === [] || array_is_list($evidenceReferenceIds) === false ||
            count($evidenceReferenceIds) > 20 ||
            count(array_unique($evidenceReferenceIds)) !== count($evidenceReferenceIds)) {
            $this->reject('fixture', 'Synthetic fixture bindings are malformed or exceed their bounds.');
        }

        foreach ($evidenceReferenceIds as $evidenceId) {
            if (is_string($evidenceId) === false ||
                preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-8][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/iD', $evidenceId) !== 1) {
                $this->reject('evidence', 'Only bounded evidence reference identifiers are accepted.');
            }
        }

        return app(FieldAwareClaimProposalService::class)->proposeForSyntheticAgent(
            $subjectEntityId,
            $evidenceReferenceIds,
            $idempotencyKey
        );
    }

    /**
     * Record only a bounded action code and a one-way idempotency reference.
     * Raw attempted text and the rejected payload are never persisted.
     */
    public function recordDeniedAction(string $attemptedAction, string $idempotencyReference): void
    {
        if (preg_match('/^[0-9a-f]{64}$/D', $idempotencyReference) !== 1) {
            $this->reject('audit', 'A bounded denial reference is required.');
        }

        $allowedActions = [
            'create_field_definition',
            'activate_field_definition',
            'retire_field_definition',
            'change_taxonomy',
            'review',
            'adjudicate',
            'publish',
            'correct',
            'withdraw',
            'reinstate',
            'suppress',
            'restore',
            'erase',
        ];
        $actionCode = in_array($attemptedAction, $allowedActions, true)
            ? $attemptedAction
            : 'unknown_privileged_action';
        $fingerprint = hash('sha256', self::AGENT_ID.'|'.$actionCode.'|'.$idempotencyReference);

        $prior = DB::table('audit_events')
            ->where('action', 'synthetic_agent_privileged_action_denied')
            ->where('metadata->idempotency_reference', $idempotencyReference)
            ->first(['metadata']);
        if ($prior !== null) {
            $metadata = json_decode((string) $prior->metadata, true);
            if (is_array($metadata) === false ||
                hash_equals((string) ($metadata['fingerprint'] ?? ''), $fingerprint) === false) {
                $this->reject('audit', 'Denial audit reference was reused for a different action.');
            }

            return;
        }

        $now = now();
        DB::table('audit_events')->insert([
            'id' => (string) Str::uuid(),
            'actor_class' => 'agent',
            'action' => 'synthetic_agent_privileged_action_denied',
            'target_type' => 'agent_submission',
            'target_id' => self::AGENT_ID,
            'reason_code' => 'agent_capability_denied',
            'occurred_at' => $now,
            'metadata' => json_encode([
                'actor_id' => self::AGENT_ID,
                'attempted_action_code' => $actionCode,
                'idempotency_reference' => $idempotencyReference,
                'fingerprint' => $fingerprint,
            ], JSON_THROW_ON_ERROR),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    private function reject(string $field, string $message): never
    {
        throw ValidationException::withMessages([$field => $message]);
    }
}
