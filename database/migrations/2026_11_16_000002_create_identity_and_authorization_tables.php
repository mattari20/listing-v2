<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('email', 254)->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('role_assignments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role', 64);
            $table->string('scope_type', 80)->nullable();
            $table->string('scope_id', 120)->nullable();
            $table->foreignId('granted_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'role', 'revoked_at'], 'role_assignment_active_lookup');
            $table->index(['scope_type', 'scope_id'], 'role_assignment_scope_lookup');
        });

        Schema::create('privileged_action_audits', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('actor_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 100);
            $table->string('subject_type', 80);
            $table->string('subject_id', 120);
            $table->string('scope_type', 80)->nullable();
            $table->string('scope_id', 120)->nullable();
            $table->string('reason_code', 64);
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['subject_type', 'subject_id', 'created_at'], 'privileged_audit_subject_lookup');
            $table->index(['actor_user_id', 'created_at'], 'privileged_audit_actor_lookup');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('privileged_action_audits');
        Schema::dropIfExists('role_assignments');
        Schema::dropIfExists('users');
    }
};
