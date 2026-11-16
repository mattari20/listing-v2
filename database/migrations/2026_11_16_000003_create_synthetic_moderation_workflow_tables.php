<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moderation_cases', function (Blueprint $table): void {
            $table->id();
            $table->string('scope_type', 80);
            $table->string('scope_id', 120);
            $table->string('category', 48);
            $table->string('status', 32)->default('pending');
            $table->foreignId('reporter_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('reviewer_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('outcome_code', 48)->nullable();
            $table->string('reason_code', 48)->nullable();
            $table->string('synthetic_reference', 80)->unique();
            $table->timestamps();
            $table->index(['scope_type', 'scope_id', 'status'], 'moderation_scope_state_lookup');
        });

        Schema::create('moderation_appeals', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('moderation_case_id')->unique()->constrained('moderation_cases')->cascadeOnDelete();
            $table->foreignId('appellant_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('reviewer_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status', 32)->default('submitted');
            $table->string('outcome_code', 48)->nullable();
            $table->string('reason_code', 48)->nullable();
            $table->string('synthetic_reference', 80)->unique();
            $table->timestamps();
        });

        Schema::create('moderation_events', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('moderation_case_id')->constrained('moderation_cases')->cascadeOnDelete();
            $table->foreignId('moderation_appeal_id')->nullable()->constrained('moderation_appeals')->nullOnDelete();
            $table->foreignId('actor_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('event_type', 48);
            $table->string('from_state', 32)->nullable();
            $table->string('to_state', 32);
            $table->string('reason_code', 48)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['moderation_case_id', 'created_at'], 'moderation_event_case_timeline');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moderation_events');
        Schema::dropIfExists('moderation_appeals');
        Schema::dropIfExists('moderation_cases');
    }
};
