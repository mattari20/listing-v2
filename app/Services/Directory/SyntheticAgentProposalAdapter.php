<?php

declare(strict_types=1);

namespace App\Services\Directory;

use Illuminate\Validation\ValidationException;

final class SyntheticAgentProposalAdapter
{
    private const FIXTURE_ID = 'synthetic-institution-alpha-v1';

    /**
     * Deterministically submit one known fixture. The only caller-supplied
     * bindings are an institution ID and existing evidence-reference IDs.
     *
     * @param  array<string, mixed>  $fixtureBindings
     * @return array{claim_id: string, claim_version_id: string, editorial_review_case_id: string}
     */
    public function submitFixture(string $fixtureId, array $fixtureBindings): array
    {
        if ($fixtureId !== self::FIXTURE_ID) {
            $this->reject('fixture', 'Unknown synthetic agent fixture.');
        }

        $expectedKeys = ['evidence_reference_ids', 'subject_entity_id'];
        $actualKeys = array_keys($fixtureBindings);
        sort($expectedKeys);
        sort($actualKeys);

        if ($actualKeys !== $expectedKeys) {
            foreach (['requested_action', 'action', 'tool', 'command', 'capabilities', 'actor'] as $privilegedKey) {
                if (array_key_exists($privilegedKey, $fixtureBindings)) {
                    $attempt = is_string($fixtureBindings[$privilegedKey]) ? $fixtureBindings[$privilegedKey] : '';
                    $reference = hash('sha256', self::FIXTURE_ID.'|'.
                        (is_string($fixtureBindings['subject_entity_id'] ?? null) ? $fixtureBindings['subject_entity_id'] : 'missing-subject').'|'.
                        $privilegedKey.'|'.hash('sha256', $attempt));
                    app(AgentFieldProposalSubmissionService::class)->recordDeniedAction($attempt, $reference);
                    break;
                }
            }

            $this->reject('fixture', 'Synthetic fixture bindings must contain only subject_entity_id and evidence_reference_ids.');
        }

        $subjectEntityId = $fixtureBindings['subject_entity_id'] ?? null;
        $evidenceReferenceIds = $fixtureBindings['evidence_reference_ids'] ?? null;
        if (is_string($subjectEntityId) === false ||
            preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-8][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/iD', $subjectEntityId) !== 1 ||
            is_array($evidenceReferenceIds) === false || array_is_list($evidenceReferenceIds) === false ||
            $evidenceReferenceIds === [] || count($evidenceReferenceIds) > 20) {
            $this->reject('fixture', 'Synthetic fixture bindings have an invalid shape or exceed their bounds.');
        }

        foreach ($evidenceReferenceIds as $evidenceId) {
            if (is_string($evidenceId) === false ||
                preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-8][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/iD', $evidenceId) !== 1) {
                $this->reject('evidence', 'Only bounded evidence reference identifiers are accepted.');
            }
        }
        if (count(array_unique($evidenceReferenceIds)) !== count($evidenceReferenceIds)) {
            $this->reject('evidence', 'Evidence reference identifiers must be unique.');
        }
        sort($evidenceReferenceIds);

        $idempotencyKey = 'i6-synthetic-agent-'.hash('sha256', json_encode([
            self::FIXTURE_ID,
            $subjectEntityId,
            $evidenceReferenceIds,
        ], JSON_THROW_ON_ERROR));

        return app(AgentFieldProposalSubmissionService::class)->submit(
            self::FIXTURE_ID,
            $subjectEntityId,
            array_values($evidenceReferenceIds),
            $idempotencyKey
        );
    }

    private function reject(string $field, string $message): never
    {
        throw ValidationException::withMessages([$field => $message]);
    }
}
