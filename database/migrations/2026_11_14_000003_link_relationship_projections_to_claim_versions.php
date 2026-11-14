<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::table('entity_relationships', function (Blueprint $table): void {
            $table->dropUnique('entity_relationship_identity_unique');
            $table->uuid('claim_version_id')->nullable();
            $table->string('status', 24)->default('unverified');
            $table->foreign('claim_version_id')->references('id')->on('claim_versions')->restrictOnDelete();
            $table->unique('claim_version_id');
            $table->index(['from_entity_id', 'to_entity_id', 'relationship_type', 'status'], 'entity_relationship_lookup_index');
        });
    }
    public function down(): void
    {
        Schema::table('entity_relationships', function (Blueprint $table): void {
            $table->dropIndex('entity_relationship_lookup_index');
            $table->dropUnique(['claim_version_id']);
            $table->dropForeign(['claim_version_id']);
            $table->dropColumn(['claim_version_id', 'status']);
            $table->unique(['from_entity_id', 'to_entity_id', 'relationship_type', 'scope'], 'entity_relationship_identity_unique');
        });
    }
};