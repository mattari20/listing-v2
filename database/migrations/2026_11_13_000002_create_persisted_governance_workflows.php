<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adjudication_cases', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('claim_version_id')->constrained('claim_versions')->restrictOnDelete();
            $table->string('status', 24);
            $table->string('opened_by_actor_id', 120);
            $table->string('case_kind', 24)->default('initial');
            $table->uuid('parent_case_id')->nullable();
            $table->string('idempotency_key', 160)->unique();
            $table->timestamps();
            $table->index(['claim_version_id', 'status']);
        });

        Schema::create('adjudication_decisions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('adjudication_case_id')->constrained('adjudication_cases')->restrictOnDelete();
            $table->string('outcome', 24);
            $table->string('actor_id', 120);
            $table->string('actor_class', 40);
            $table->string('rationale_code', 100);
            $table->text('rationale');
            $table->string('policy_version', 80);
            $table->timestamp('decided_at');
            $table->timestamps();
            $table->index(['adjudication_case_id', 'decided_at']);
        });

        Schema::create('publication_decisions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('claim_version_id')->constrained('claim_versions')->restrictOnDelete();
            $table->string('decision', 24);
            $table->string('surface', 60);
            $table->string('audience', 60);
            $table->string('actor_id', 120);
            $table->string('actor_class', 40);
            $table->string('adjudication_decision_id', 36);
            $table->string('policy_version', 80);
            $table->string('idempotency_key', 160)->unique();
            $table->string('reason_code', 100);
            $table->timestamp('decided_at');
            $table->timestamps();
            $table->index(['claim_version_id', 'decision']);
        });

        Schema::create('publication_snapshots', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('publication_decision_id')->constrained('publication_decisions')->restrictOnDelete();
            $table->foreignUuid('claim_version_id')->constrained('claim_versions')->restrictOnDelete();
            $table->unsignedInteger('snapshot_version');
            $table->json('payload');
            $table->string('payload_digest', 64);
            $table->string('surface', 60);
            $table->string('audience', 60);
            $table->string('status', 24);
            $table->timestamp('created_at');
            $table->unique(['claim_version_id', 'snapshot_version']);
            $table->index(['status', 'surface', 'audience']);
        });

        Schema::create('public_projections', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('publication_snapshot_id')->constrained('publication_snapshots')->restrictOnDelete();
            $table->string('projection_key', 180)->unique();
            $table->string('surface', 60);
            $table->string('audience', 60);
            $table->string('status', 24);
            $table->boolean('is_deeni_madaris')->default(false);
            $table->timestamp('projected_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'surface', 'audience', 'is_deeni_madaris']);
        });

        Schema::create('governance_outbox', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('event_type', 100);
            $table->string('aggregate_type', 60);
            $table->string('aggregate_id', 36);
            $table->json('payload');
            $table->string('idempotency_key', 180)->unique();
            $table->string('status', 20)->default('pending');
            $table->unsignedInteger('attempts')->default(0);
            $table->timestamp('available_at');
            $table->timestamp('processed_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();
            $table->index(['status', 'available_at']);
        });

        Schema::create('publication_suppressions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('publication_snapshot_id')->constrained('publication_snapshots')->restrictOnDelete();
            $table->string('reason_code', 100);
            $table->text('rationale');
            $table->string('actor_id', 120);
            $table->string('actor_class', 40);
            $table->string('status', 20);
            $table->timestamp('suppressed_at');
            $table->timestamps();
            $table->index(['publication_snapshot_id', 'status']);
        });

        Schema::create('publication_restorations', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('suppression_id')->constrained('publication_suppressions')->restrictOnDelete();
            $table->foreignUuid('publication_snapshot_id')->constrained('publication_snapshots')->restrictOnDelete();
            $table->string('actor_id', 120);
            $table->string('actor_class', 40);
            $table->string('policy_version', 80);
            $table->string('reason_code', 100);
            $table->timestamp('restored_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publication_restorations');
        Schema::dropIfExists('publication_suppressions');
        Schema::dropIfExists('governance_outbox');
        Schema::dropIfExists('public_projections');
        Schema::dropIfExists('publication_snapshots');
        Schema::dropIfExists('publication_decisions');
        Schema::dropIfExists('adjudication_decisions');
        Schema::dropIfExists('adjudication_cases');
    }
};
