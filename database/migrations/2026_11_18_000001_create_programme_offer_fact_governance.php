<?php

declare(strict_types=1);

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programme_offer_facts', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('programme_offer_id')->constrained('programme_offers')->restrictOnDelete();
            $table->string('fact_key', 100);
            $table->string('category', 32);
            $table->timestamps();
            $table->unique(['programme_offer_id', 'fact_key'], 'programme_offer_fact_identity_unique');
            $table->index(['programme_offer_id', 'category']);
        });

        Schema::create('programme_offer_fact_versions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('programme_offer_fact_id')->constrained('programme_offer_facts')->restrictOnDelete();
            $table->unsignedInteger('version_number');
            $table->string('idempotency_key', 160)->unique();
            $table->json('value')->nullable();
            $table->string('fact_state', 24);
            $table->string('disposition', 24)->default('proposed');
            $table->timestamp('observed_at')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->string('freshness_policy_key', 100)->nullable();
            $table->unsignedSmallInteger('freshness_days')->nullable();
            $table->timestamp('recorded_at');
            $table->foreignUuid('supersedes_version_id')->nullable()->constrained('programme_offer_fact_versions')->restrictOnDelete();
            $table->string('correction_reason')->nullable();
            $table->timestamps();
            $table->unique(['programme_offer_fact_id', 'version_number'], 'offer_fact_version_number_unique');
            $table->unique('supersedes_version_id', 'offer_fact_successor_unique');
            $table->index(['disposition', 'fact_state', 'valid_from', 'valid_to'], 'offer_fact_version_public_state_idx');
        });

        Schema::create('programme_offer_fact_evidence_links', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('fact_version_id')->constrained('programme_offer_fact_versions')->restrictOnDelete();
            $table->foreignUuid('evidence_reference_id')->constrained('evidence_references')->restrictOnDelete();
            $table->string('relationship_type', 24);
            $table->timestamps();
            $table->unique(['fact_version_id', 'evidence_reference_id', 'relationship_type'], 'offer_fact_evidence_unique');
        });

        Schema::create('programme_offer_fact_adjudication_cases', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('fact_version_id')->constrained('programme_offer_fact_versions')->restrictOnDelete();
            $table->string('status', 24);
            $table->string('opened_by_actor_id', 120);
            $table->string('idempotency_key', 160)->unique();
            $table->timestamps();
            $table->index(['fact_version_id', 'status'], 'offer_fact_case_state_idx');
        });

        Schema::create('programme_offer_fact_adjudication_decisions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('adjudication_case_id')->constrained('programme_offer_fact_adjudication_cases')->restrictOnDelete();
            $table->string('outcome', 24);
            $table->string('actor_id', 120);
            $table->string('actor_class', 40);
            $table->string('rationale_code', 100);
            $table->text('rationale');
            $table->string('policy_version', 80);
            $table->timestamp('decided_at');
            $table->timestamps();
            $table->index(['adjudication_case_id', 'decided_at'], 'offer_fact_decision_case_idx');
        });

        Schema::create('programme_offer_fact_publication_decisions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('fact_version_id')->constrained('programme_offer_fact_versions')->restrictOnDelete();
            $table->string('decision', 24);
            $table->string('surface', 60);
            $table->string('audience', 60);
            $table->string('actor_id', 120);
            $table->string('actor_class', 40);
            $table->foreignUuid('adjudication_decision_id')->constrained('programme_offer_fact_adjudication_decisions')->restrictOnDelete();
            $table->string('policy_version', 80);
            $table->string('idempotency_key', 160)->unique();
            $table->string('reason_code', 100);
            $table->timestamp('decided_at');
            $table->timestamps();
            $table->index(['fact_version_id', 'decision'], 'offer_fact_publication_state_idx');
        });

        Schema::create('programme_offer_fact_publication_snapshots', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('publication_decision_id')->constrained('programme_offer_fact_publication_decisions')->restrictOnDelete();
            $table->foreignUuid('fact_version_id')->constrained('programme_offer_fact_versions')->restrictOnDelete();
            $table->unsignedInteger('snapshot_version');
            $table->json('payload');
            $table->string('payload_digest', 64);
            $table->string('surface', 60);
            $table->string('audience', 60);
            $table->string('status', 24);
            $table->timestamp('created_at');
            $table->unique(['fact_version_id', 'snapshot_version'], 'offer_fact_snapshot_version_unique');
            $table->index(['status', 'surface', 'audience'], 'offer_fact_snapshot_public_idx');
        });

        Schema::create('programme_offer_fact_public_projections', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('publication_snapshot_id')->constrained('programme_offer_fact_publication_snapshots')->restrictOnDelete();
            $table->string('projection_key', 220)->unique();
            $table->string('surface', 60);
            $table->string('audience', 60);
            $table->string('status', 24);
            $table->timestamp('projected_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'surface', 'audience'], 'offer_fact_projection_public_idx');
        });

        Schema::create('programme_offer_fact_publication_suppressions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('publication_snapshot_id')->constrained('programme_offer_fact_publication_snapshots')->restrictOnDelete();
            $table->string('reason_code', 100);
            $table->text('rationale');
            $table->string('actor_id', 120);
            $table->string('actor_class', 40);
            $table->string('status', 20);
            $table->timestamp('suppressed_at');
            $table->timestamps();
            $table->index(['publication_snapshot_id', 'status'], 'offer_fact_suppression_state_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programme_offer_fact_publication_suppressions');
        Schema::dropIfExists('programme_offer_fact_public_projections');
        Schema::dropIfExists('programme_offer_fact_publication_snapshots');
        Schema::dropIfExists('programme_offer_fact_publication_decisions');
        Schema::dropIfExists('programme_offer_fact_adjudication_decisions');
        Schema::dropIfExists('programme_offer_fact_adjudication_cases');
        Schema::dropIfExists('programme_offer_fact_evidence_links');
        Schema::dropIfExists('programme_offer_fact_versions');
        Schema::dropIfExists('programme_offer_facts');
    }
};
