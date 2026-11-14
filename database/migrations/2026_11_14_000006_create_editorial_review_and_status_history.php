<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('editorial_review_cases', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->foreignUuid('claim_version_id')->constrained('claim_versions')->restrictOnDelete();
            $table->string('status', 40);
            $table->string('submitted_by_actor_id', 120);
            $table->string('reviewer_actor_id', 120)->nullable();
            $table->uuid('adjudication_case_id')->nullable();
            $table->uuid('adjudication_decision_id')->nullable();
            $table->uuid('publication_decision_id')->nullable();
            $table->string('idempotency_key', 160)->unique();
            $table->string('fingerprint', 64);
            $table->timestamps();
            $table->index(['entity_id', 'status']);
            $table->index(['claim_version_id', 'status']);
        });

        Schema::create('directory_status_history', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->foreignUuid('claim_version_id')->nullable()->constrained('claim_versions')->restrictOnDelete();
            $table->foreignUuid('editorial_review_case_id')->nullable()->constrained('editorial_review_cases')->restrictOnDelete();
            $table->string('event_type', 48);
            $table->string('previous_status', 40)->nullable();
            $table->string('new_status', 40);
            $table->string('actor_id', 120);
            $table->string('actor_class', 24);
            $table->string('reason_code', 80);
            $table->string('idempotency_key', 160)->unique();
            $table->string('fingerprint', 64);
            $table->json('metadata')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();
            $table->index(['entity_id', 'occurred_at']);
            $table->index(['editorial_review_case_id', 'occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('directory_status_history');
        Schema::dropIfExists('editorial_review_cases');
    }
};
