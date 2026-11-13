<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claim_conflicts', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('claim_id')->constrained('claims')->restrictOnDelete();
            $table->string('conflict_kind', 48);
            $table->string('status', 24)->default('open');
            $table->string('fingerprint', 64)->unique();
            $table->string('idempotency_key', 160)->unique();
            $table->timestamp('evaluated_at');
            $table->foreignUuid('resolved_candidate_version_id')->nullable()->constrained('claim_versions')->restrictOnDelete();
            $table->foreignUuid('adjudication_decision_id')->nullable()->constrained('adjudication_decisions')->restrictOnDelete();
            $table->string('resolved_by_actor_id', 120)->nullable();
            $table->text('resolution_rationale')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            $table->index(['claim_id', 'status']);
        });

        Schema::create('claim_conflict_candidates', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('claim_conflict_id')->constrained('claim_conflicts')->restrictOnDelete();
            $table->foreignUuid('claim_version_id')->constrained('claim_versions')->restrictOnDelete();
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->timestamp('recorded_at');
            $table->string('value_digest', 64);
            $table->timestamps();
            $table->unique(['claim_conflict_id', 'claim_version_id'], 'claim_conflict_candidate_unique');
            $table->index(['claim_version_id', 'recorded_at']);
        });

        Schema::create('publication_rollbacks', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('current_snapshot_id')->constrained('publication_snapshots')->restrictOnDelete();
            $table->foreignUuid('target_snapshot_id')->constrained('publication_snapshots')->restrictOnDelete();
            $table->string('actor_id', 120);
            $table->string('actor_class', 40);
            $table->string('policy_version', 80);
            $table->string('reason_code', 100);
            $table->string('idempotency_key', 160)->unique();
            $table->timestamp('rolled_back_at');
            $table->timestamps();
            $table->index(['current_snapshot_id', 'target_snapshot_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publication_rollbacks');
        Schema::dropIfExists('claim_conflict_candidates');
        Schema::dropIfExists('claim_conflicts');
    }
};
