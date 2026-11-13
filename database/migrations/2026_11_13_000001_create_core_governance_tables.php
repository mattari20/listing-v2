<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('directory_entities', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('entity_type', 40);
            $table->string('label');
            $table->timestamps();
            $table->index(['entity_type', 'label']);
        });

        Schema::create('entity_relationships', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('from_entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->foreignUuid('to_entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->string('relationship_type', 40);
            $table->string('scope')->nullable();
            $table->string('jurisdiction')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->timestamps();
            $table->index(['relationship_type', 'valid_from', 'valid_to']);
            $table->unique(['from_entity_id', 'to_entity_id', 'relationship_type', 'scope'], 'entity_relationship_identity_unique');
        });

        Schema::create('source_authorizations', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('source_family_id', 120);
            $table->string('status', 20);
            $table->json('permitted_purposes');
            $table->json('permitted_methods');
            $table->json('territories');
            $table->json('permitted_scopes');
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->string('revocation_reason')->nullable();
            $table->timestamps();
            $table->index(['source_family_id', 'status']);
        });

        Schema::create('evidence_references', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('source_authorization_id')->constrained('source_authorizations')->restrictOnDelete();
            $table->string('reference_kind', 40);
            $table->string('source_type', 40);
            $table->string('integrity_digest', 128)->nullable();
            $table->string('status', 24)->default('quarantined');
            $table->boolean('content_included')->default(false);
            $table->timestamp('observed_at')->nullable();
            $table->timestamp('recorded_at');
            $table->timestamps();
            $table->index(['source_authorization_id', 'status']);
        });

        Schema::create('claims', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('subject_entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->string('predicate', 100);
            $table->timestamps();
            $table->unique(['subject_entity_id', 'predicate', 'id'], 'claim_subject_predicate_identity_unique');
        });

        Schema::create('claim_versions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('claim_id')->constrained('claims')->restrictOnDelete();
            $table->unsignedInteger('version_number');
            $table->json('value');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->timestamp('recorded_at');
            $table->string('disposition', 24);
            $table->foreignUuid('supersedes_version_id')->nullable()->constrained('claim_versions')->restrictOnDelete();
            $table->string('correction_reason')->nullable();
            $table->timestamps();
            $table->unique(['claim_id', 'version_number']);
            $table->unique('supersedes_version_id');
            $table->index(['disposition', 'valid_from', 'valid_to']);
        });

        Schema::create('claim_evidence_links', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('claim_version_id')->constrained('claim_versions')->restrictOnDelete();
            $table->foreignUuid('evidence_reference_id')->constrained('evidence_references')->restrictOnDelete();
            $table->string('relationship_type', 24);
            $table->timestamps();
            $table->unique(['claim_version_id', 'evidence_reference_id', 'relationship_type'], 'claim_evidence_link_unique');
        });

        Schema::create('audit_events', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('actor_class', 60);
            $table->string('action', 80);
            $table->string('target_type', 60);
            $table->uuid('target_id');
            $table->string('reason_code', 100);
            $table->timestamp('occurred_at');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->index(['target_type', 'target_id', 'occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_events');
        Schema::dropIfExists('claim_evidence_links');
        Schema::dropIfExists('claim_versions');
        Schema::dropIfExists('claims');
        Schema::dropIfExists('evidence_references');
        Schema::dropIfExists('source_authorizations');
        Schema::dropIfExists('entity_relationships');
        Schema::dropIfExists('directory_entities');
    }
};
