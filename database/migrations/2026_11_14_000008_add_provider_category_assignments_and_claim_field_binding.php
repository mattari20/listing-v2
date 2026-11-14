<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('directory_provider_category_assignments', function (Blueprint $table): void {
            $table->foreignUuid('entity_id')->primary()->constrained('directory_entities')->restrictOnDelete();
            $table->string('provider_category', 64);
            $table->string('assigned_by_actor_id', 120);
            $table->string('reason_code', 100);
            $table->string('idempotency_key', 160)->unique();
            $table->string('fingerprint', 64);
            $table->timestamp('assigned_at');
            $table->timestamps();
            $table->index(['provider_category', 'entity_id'], 'directory_provider_category_lookup_idx');
        });

        Schema::table('claim_versions', function (Blueprint $table): void {
            $table->foreignUuid('field_definition_version_id')
                ->nullable()
                ->after('claim_id')
                ->constrained('field_definition_versions')
                ->restrictOnDelete();
            $table->index(
                ['field_definition_version_id', 'disposition'],
                'claim_versions_field_definition_disposition_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::table('claim_versions', function (Blueprint $table): void {
            $table->dropIndex('claim_versions_field_definition_disposition_idx');
            $table->dropConstrainedForeignId('field_definition_version_id');
        });

        Schema::dropIfExists('directory_provider_category_assignments');
    }
};
