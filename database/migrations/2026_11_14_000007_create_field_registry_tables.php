<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_definitions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('field_key', 80)->unique('field_definitions_key_unique');
            $table->timestamps();
        });

        Schema::create('field_definition_versions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('field_definition_id')->constrained('field_definitions')->restrictOnDelete();
            $table->unsignedInteger('version_number');
            $table->string('lifecycle_state', 24);
            $table->string('semantic_version', 40);
            $table->string('compatibility_class', 40);
            $table->string('value_type', 32);
            $table->string('cardinality', 24);
            $table->string('scope_key', 48);
            $table->string('privacy_class', 32);
            $table->string('visibility_class', 32);
            $table->boolean('searchable')->default(false);
            $table->boolean('filterable')->default(false);
            $table->boolean('sortable')->default(false);
            $table->json('validation_schema');
            $table->json('presentation_metadata');
            $table->json('evidence_policy');
            $table->json('freshness_policy');
            $table->timestamp('effective_from')->nullable();
            $table->timestamp('effective_to')->nullable();
            $table->foreignUuid('successor_field_definition_id')->nullable()->constrained('field_definitions')->restrictOnDelete();
            $table->string('proposed_by_actor_id', 120)->nullable();
            $table->string('rationale_reference', 160)->nullable();
            $table->timestamps();

            $table->unique(
                ['field_definition_id', 'version_number'],
                'field_definition_versions_identity_version_unique'
            );
            $table->index(
                ['lifecycle_state', 'effective_from', 'effective_to'],
                'field_definition_versions_state_effective_idx'
            );
        });

        Schema::create('field_definition_version_entity_types', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('field_definition_version_id')
                ->constrained('field_definition_versions')
                ->restrictOnDelete();
            $table->string('entity_type', 40);
            $table->timestamps();
            $table->unique(
                ['field_definition_version_id', 'entity_type'],
                'field_definition_version_entity_type_unique'
            );
            $table->index(['entity_type', 'field_definition_version_id'], 'field_definition_entity_type_lookup_idx');
        });

        Schema::create('field_definition_version_provider_categories', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('field_definition_version_id')
                ->constrained('field_definition_versions')
                ->restrictOnDelete();
            $table->string('provider_category', 64);
            $table->timestamps();
            $table->unique(
                ['field_definition_version_id', 'provider_category'],
                'field_definition_provider_category_unique'
            );
            $table->index(
                ['provider_category', 'field_definition_version_id'],
                'field_definition_provider_category_lookup_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('field_definition_version_provider_categories');
        Schema::dropIfExists('field_definition_version_entity_types');
        Schema::dropIfExists('field_definition_versions');
        Schema::dropIfExists('field_definitions');
    }
};
