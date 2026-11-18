<?php

declare(strict_types=1);

namespace Database\\Seeders;

use App\\Services\\Governance\\PersistedGovernanceWorkflowService;
use Illuminate\\Database\\Seeder;
use Illuminate\\Support\\Facades\\DB;
use Illuminate\\Support\\Str;
use RuntimeException;

final class PrivatePreviewDirectorySeeder extends Seeder
{
    private const SOURCE_FAMILY = 'm3-12-synthetic-private-preview-v1';

    /**
     * Populate a local SQLite database with fictional directory examples.
     *
     * This seeder intentionally refuses production/staging and non-SQLite
     * connections. It is not a source-ingestion or production-data tool.
     */
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            throw new RuntimeException('The private preview seeder is restricted to local and testing environments.');
        }

        if (DB::connection()->getDriverName() !== 'sqlite') {
            throw new RuntimeException('The private preview seeder requires a SQLite connection.');
        }

        if (DB::table('source_authorizations')->where('source_family_id', self::SOURCE_FAMILY)->exists()) {
            $this->command?->info('Synthetic private-preview dataset already exists; no changes made.');

            return;
        }

        DB::transaction(function (): void {
            $now = now();
            $authorizationId = (string) Str::uuid();

            DB::table('source_authorizations')->insert([
                'id' => $authorizationId,
                'source_family_id' => self::SOURCE_FAMILY,
                'status' => 'approved_for_defined_purpose_and_method',
                'permitted_purposes' => json_encode(['directory_publication'], JSON_THROW_ON_ERROR),
                'permitted_methods' => json_encode(['approved_projection'], JSON_THROW_ON_ERROR),
                'territories' => json_encode(['synthetic'], JSON_THROW_ON_ERROR),
                'permitted_scopes' => json_encode(['publication' => true], JSON_THROW_ON_ERROR),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $examples = [
                [
                    'type' => 'provider',
                    'name' => 'Demo Learning Network',
                    'overview' => 'Fictional provider record created only to demonstrate the private V2 directory preview.',
                    'province' => 'Punjab',
                    'district' => 'Synthetic Lahore District',
                    'city' => 'Lahore',
                    'locality' => 'Demo Quarter',
                ],
                [
                    'type' => 'institution',
                    'name' => 'Example Knowledge Academy',
                    'overview' => 'Fictional institution record. This is not a real school and does not represent an operating provider.',
                    'province' => 'Punjab',
                    'district' => 'Synthetic Lahore District',
                    'city' => 'Lahore',
                    'locality' => 'Sample Block',
                ],
                [
                    'type' => 'institution',
                    'name' => 'Sample Future College',
                    'overview' => 'Fictional institution record for testing category browsing and profile presentation.',
                    'province' => 'Sindh',
                    'district' => 'Synthetic Karachi District',
                    'city' => 'Karachi',
                    'locality' => 'Preview Sector',
                ],
                [
                    'type' => 'campus',
                    'name' => 'Synthetic North Campus',
                    'overview' => 'Fictional campus entry; no physical campus or address is implied.',
                    'province' => 'Punjab',
                    'district' => 'Synthetic Lahore District',
                    'city' => 'Lahore',
                    'locality' => 'Campus Demo Zone',
                ],
                [
                    'type' => 'programme',
                    'name' => 'Sample Computing Programme',
                    'overview' => 'Fictional programme entry used to exercise programme category search.',
                    'province' => 'Punjab',
                    'district' => 'Synthetic Lahore District',
                    'city' => 'Lahore',
                    'locality' => 'Programme Demo Zone',
                ],
                [
                    'type' => 'programme',
                    'name' => 'Example Business Studies Programme',
                    'overview' => 'Fictional programme entry; it is not an admissions offer.',
                    'province' => 'Sindh',
                    'district' => 'Synthetic Karachi District',
                    'city' => 'Karachi',
                    'locality' => 'Study Demo Zone',
                ],
                [
                    'type' => 'qualification',
                    'name' => 'Fictional Secondary Certificate',
                    'overview' => 'Fictional qualification label for preview purposes only; it is not an accredited award.',
                    'province' => 'Islamabad Capital Territory',
                    'district' => 'Synthetic Capital District',
                    'city' => 'Islamabad',
                    'locality' => 'Qualification Demo Zone',
                ],
            ];

            $workflow = app(PersistedGovernanceWorkflowService::class);

            foreach ($examples as $example) {
                $entityId = (string) Str::uuid();

                DB::table('directory_entities')->insert([
                    'id' => $entityId,
                    'entity_type' => $example['type'],
                    'label' => 'Synthetic private-preview fixture',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                foreach ([
                    'display_name' => $example['name'],
                    'overview' => $example['overview'],
                    'province' => $example['province'],
                    'district' => $example['district'],
                    'city' => $example['city'],
                    'locality' => $example['locality'],
                ] as $predicate => $value) {
                    $this->publishSyntheticFact(
                        $workflow,
                        $entityId,
                        $predicate,
                        $value,
                        $authorizationId,
                        $now
                    );
                }
            }

            $workflow->processOutbox();
        });

        $this->command?->info('Created 7 fictional private-preview entities across all 5 supported directory categories.');
    }

    private function publishSyntheticFact(
        PersistedGovernanceWorkflowService $workflow,
        string $entityId,
        string $predicate,
        string $value,
        string $authorizationId,
        mixed $now
    ): void {
        $evidenceId = (string) Str::uuid();
        $claimId = (string) Str::uuid();
        $versionId = (string) Str::uuid();

        DB::table('evidence_references')->insert([
            'id' => $evidenceId,
            'source_authorization_id' => $authorizationId,
            'reference_kind' => 'synthetic_fixture',
            'source_type' => 'synthetic',
            'status' => 'eligible_for_review',
            'content_included' => false,
            'observed_at' => $now,
            'recorded_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('audit_events')->insert([
            'id' => (string) Str::uuid(),
            'actor_class' => 'human',
            'action' => 'evidence_reference_registered',
            'target_type' => 'evidence_reference',
            'target_id' => $evidenceId,
            'reason_code' => 'synthetic_private_preview_fixture',
            'occurred_at' => $now,
            'metadata' => json_encode(['actor_id' => 'm3-12-synthetic-evidence-recorder'], JSON_THROW_ON_ERROR),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('claims')->insert([
            'id' => $claimId,
            'subject_entity_id' => $entityId,
            'predicate' => $predicate,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('claim_versions')->insert([
            'id' => $versionId,
            'claim_id' => $claimId,
            'field_definition_version_id' => null,
            'version_number' => 1,
            'value' => json_encode(['value' => $value], JSON_THROW_ON_ERROR),
            'recorded_at' => $now,
            'disposition' => 'proposed',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('claim_evidence_links')->insert([
            'id' => (string) Str::uuid(),
            'claim_version_id' => $versionId,
            'evidence_reference_id' => $evidenceId,
            'relationship_type' => 'supports',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $caseId = $workflow->openAdjudicationCase(
            [
                'actor_id' => 'm3-12-synthetic-adjudicator',
                'actor_class' => 'human',
                'capabilities' => ['open_adjudication'],
            ],
            $versionId,
            'm3-12-preview-case-'.$versionId
        );

        $decisionId = $workflow->decideAdjudication(
            [
                'actor_id' => 'm3-12-synthetic-adjudicator',
                'actor_class' => 'human',
                'capabilities' => ['adjudicate_claim'],
            ],
            $caseId,
            'accepted',
            'synthetic_preview_fixture',
            'Accepted only as a fictional local preview fixture.',
            'm3-12-synthetic-preview-policy-v1'
        );

        $workflow->authorizePublication(
            [
                'actor_id' => 'm3-12-synthetic-publisher',
                'actor_class' => 'human',
                'capabilities' => ['authorize_publication'],
            ],
            $versionId,
            $decisionId,
            'directory',
            'anonymous',
            'm3-12-synthetic-preview-policy-v1',
            'm3-12-preview-publication-'.$versionId
        );
    }
}
