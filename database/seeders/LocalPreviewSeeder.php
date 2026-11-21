<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Services\Directory\CampusProgrammeCatalogueService;
use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Explicitly invoked local-only synthetic directory preview data.
 *
 * This seeder is deliberately not called by DatabaseSeeder.
 */
final class LocalPreviewSeeder extends Seeder
{
    private const MARKER = 'LOCAL PREVIEW ONLY — FICTIONAL';

    /** @var array<int, array<string, string>> */
    private const INSTITUTIONS = [
        [
            'name' => 'Synthetic Crescent Learning Institute',
            'overview' => 'Fictional example institution for checking directory cards and profile presentation.',
            'province' => 'Punjab',
            'district' => 'Lahore',
            'city' => 'Lahore',
            'locality' => 'Gulberg',
        ],
        [
            'name' => 'Synthetic Riverbend College',
            'overview' => 'Fictional example college used to exercise search, locality filters and profile facts.',
            'province' => 'Sindh',
            'district' => 'Karachi East',
            'city' => 'Karachi',
            'locality' => 'Gulshan',
        ],
        [
            'name' => 'Synthetic Frontier Skills Academy',
            'overview' => 'Fictional example skills institution for testing directory result diversity.',
            'province' => 'Khyber Pakhtunkhwa',
            'district' => 'Peshawar',
            'city' => 'Peshawar',
            'locality' => 'University Road',
        ],
        [
            'name' => 'Synthetic Makran Science College',
            'overview' => 'Fictional example college for testing province and city discovery.',
            'province' => 'Balochistan',
            'district' => 'Quetta',
            'city' => 'Quetta',
            'locality' => 'Jinnah Town',
        ],
        [
            'name' => 'Synthetic Capital Research Institute',
            'overview' => 'Fictional example institution for testing a separate federal-territory locality.',
            'province' => 'Islamabad Capital Territory',
            'district' => 'Islamabad',
            'city' => 'Islamabad',
            'locality' => 'G-10',
        ],
    ];

    public function run(): void
    {
        $this->assertSafeTarget();

        if (DB::table('directory_entities')->where('label', 'like', self::MARKER.'%')->exists()) {
            throw new RuntimeException(
                'Local preview records already exist. Use a fresh, dedicated .local-preview.sqlite database; this seeder never deletes or overwrites data.'
            );
        }

        DB::transaction(function (): void {
            foreach (self::INSTITUTIONS as $index => $institution) {
                $entityId = (string) Str::uuid();
                $now = now();

                DB::table('directory_entities')->insert([
                    'id' => $entityId,
                    'entity_type' => 'institution',
                    'label' => self::MARKER.' '.$institution['name'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                foreach ($institution as $field => $value) {
                    $predicate = match ($field) {
                        'name' => 'display_name',
                        default => $field,
                    };

                    $this->publishSyntheticFact($entityId, $predicate, $value, $index, $field);
                }

                $campusId = $this->createSyntheticEntity(
                    'campus',
                    'Synthetic '.$institution['city'].' Campus'
                );
                $this->publishSyntheticFact($campusId, 'display_name', 'Synthetic '.$institution['city'].' Campus', $index, 'campus-name');
                $campusVersionId = $this->publishSyntheticFact(
                    $campusId,
                    'campus',
                    [
                        'institution_entity_id' => $entityId,
                        'location_label' => $institution['locality'],
                    ],
                    $index,
                    'campus-catalogue',
                    true
                );
                $this->materializeCatalogueClaim($campusVersionId, $index, 'campus');

                $programmeTitle = 'Synthetic '.$institution['city'].' Computing Programme';
                $programmeId = $this->createSyntheticEntity('programme', $programmeTitle);
                $this->publishSyntheticFact($programmeId, 'display_name', $programmeTitle, $index, 'programme-name');
                $programmeVersionId = $this->publishSyntheticFact(
                    $programmeId,
                    'programme',
                    [
                        'institution_entity_id' => $entityId,
                        'title' => $programmeTitle,
                        'description' => 'Fictional programme fixture for local preview only.',
                        'level' => 'Synthetic undergraduate',
                    ],
                    $index,
                    'programme-catalogue',
                    true
                );
                $this->materializeCatalogueClaim($programmeVersionId, $index, 'programme');

                $offerVersionId = $this->publishSyntheticFact(
                    $programmeId,
                    'programme_offer',
                    [
                        'programme_entity_id' => $programmeId,
                        'delivery_location_entity_id' => $campusId,
                        'admission_cycle' => 'Synthetic 2027 Intake',
                    ],
                    $index,
                    'programme-offer',
                    true
                );
                $this->materializeCatalogueClaim($offerVersionId, $index, 'programme-offer');
            }
        });

        $this->command?->info('Created 5 fictional institutions, 5 campuses, 5 programmes and 5 admission offers for local preview only.');
        $this->command?->info('No real institution, student, child, guardian or staff records were used.');
    }

    private function assertSafeTarget(): void
    {
        if (! app()->environment('local')) {
            throw new RuntimeException('LocalPreviewSeeder is permitted only when APP_ENV=local.');
        }

        if (DB::connection()->getDriverName() !== 'sqlite') {
            throw new RuntimeException('LocalPreviewSeeder requires SQLite; remote and server database drivers are refused.');
        }

        if (basename((string) config('database.connections.sqlite.database')) !== '.local-preview.sqlite') {
            throw new RuntimeException('Use the dedicated .local-preview.sqlite database file; the default or any other SQLite database is refused.');
        }

        if (env('LOCAL_PREVIEW_SEED') !== 'allow') {
            throw new RuntimeException('Set LOCAL_PREVIEW_SEED=allow for this one explicit local preview seed operation.');
        }
    }

    private function createSyntheticEntity(string $type, string $name): string
    {
        $entityId = (string) Str::uuid();
        $now = now();

        DB::table('directory_entities')->insert([
            'id' => $entityId,
            'entity_type' => $type,
            'label' => self::MARKER.' '.$name,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $entityId;
    }

    private function materializeCatalogueClaim(string $claimVersionId, int $entityIndex, string $field): void
    {
        app(CampusProgrammeCatalogueService::class)->materializeAcceptedRecord(
            [
                'actor_id' => 'preview-materializer-'.$entityIndex.'-'.$field,
                'actor_class' => 'human',
                'capabilities' => ['materialize_catalogue_record'],
            ],
            $claimVersionId,
            'local-preview-materialize-'.$entityIndex.'-'.$field
        );
    }

    private function publishSyntheticFact(
        string $entityId,
        string $predicate,
        mixed $value,
        int $entityIndex,
        string $field,
        bool $catalogueValue = false
    ): string {
        $now = now();
        $authorizationId = (string) Str::uuid();
        $evidenceId = (string) Str::uuid();
        $claimId = (string) Str::uuid();
        $versionId = (string) Str::uuid();
        $suffix = 'local-preview-'.$entityIndex.'-'.$field;

        DB::table('source_authorizations')->insert([
            'id' => $authorizationId,
            'source_family_id' => 'local-synthetic-preview',
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['directory_publication', 'synthetic_test_only'], JSON_THROW_ON_ERROR),
            'permitted_methods' => json_encode(['approved_projection', 'fixture_reference'], JSON_THROW_ON_ERROR),
            'territories' => json_encode(['synthetic'], JSON_THROW_ON_ERROR),
            'permitted_scopes' => json_encode(['processing' => true, 'publication' => true], JSON_THROW_ON_ERROR),
            'valid_from' => $now->copy()->subDay(),
            'valid_to' => $now->copy()->addDay(),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

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
            'reason_code' => 'local_synthetic_preview',
            'occurred_at' => $now,
            'metadata' => json_encode(['actor_id' => 'preview-evidence-author-'.$suffix], JSON_THROW_ON_ERROR),
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
            'value' => json_encode($catalogueValue ? $value : ['value' => $value], JSON_THROW_ON_ERROR),
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

        $workflow = app(PersistedGovernanceWorkflowService::class);
        $caseId = $workflow->openAdjudicationCase(
            ['actor_id' => 'preview-case-opener-'.$suffix, 'actor_class' => 'human', 'capabilities' => ['open_adjudication']],
            $versionId,
            'preview-case-'.$suffix
        );
        $decisionId = $workflow->decideAdjudication(
            ['actor_id' => 'preview-adjudicator-'.$suffix, 'actor_class' => 'human', 'capabilities' => ['adjudicate_claim']],
            $caseId,
            'accepted',
            'synthetic_preview_acceptance',
            'Accepted fictional local preview fixture; not a real-world assertion.',
            'local-preview-policy-v1'
        );
        $publicationId = $workflow->authorizePublication(
            ['actor_id' => 'preview-publisher-'.$suffix, 'actor_class' => 'human', 'capabilities' => ['authorize_publication']],
            $versionId,
            $decisionId,
            'directory',
            'anonymous',
            'local-preview-policy-v1',
            'preview-publication-'.$suffix
        );

        $workflow->processOutbox();

        if (! DB::table('publication_snapshots')->where('publication_decision_id', $publicationId)->exists()) {
            throw new RuntimeException('Synthetic preview publication did not produce its expected snapshot.');
        }

        return $versionId;
    }
}
