<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_definition_review_cases', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('field_definition_version_id')
                ->constrained('field_definition_versions')
                ->restrictOnDelete();
            $table->string('submitted_by_actor_id', 120);
            $table->string('assigned_reviewer_actor_id', 120)->nullable();
            $table->string('status', 24);
            $table->string('idempotency_key', 160)->unique();
            $table->char('command_fingerprint', 64);
            $table->timestamps();
            $table->index(['field_definition_version_id', 'status'], 'field_definition_review_case_version_status_idx');
            $table->index(['assigned_reviewer_actor_id', 'status'], 'field_definition_review_case_reviewer_status_idx');
        });

        Schema::create('field_definition_review_decisions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('review_case_id')
                ->constrained('field_definition_review_cases')
                ->restrictOnDelete();
            $table->string('outcome', 32);
            $table->string('actor_id', 120);
            $table->string('actor_class', 40);
            $table->string('rationale_code', 100);
            $table->string('rationale', 1000);
            $table->string('policy_version', 80);
            $table->string('idempotency_key', 160)->unique();
            $table->char('command_fingerprint', 64);
            $table->timestamp('decided_at');
            $table->timestamps();
            $table->index(['review_case_id', 'decided_at'], 'field_definition_review_decision_case_time_idx');
            $table->index(['actor_id', 'outcome'], 'field_definition_review_decision_actor_outcome_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('field_definition_review_decisions');
        Schema::dropIfExists('field_definition_review_cases');
    }
};
