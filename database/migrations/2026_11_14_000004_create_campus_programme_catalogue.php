<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('directory_campuses', function (Blueprint $table): void {
            $table->uuid('entity_id')->primary();
            $table->foreign('entity_id')->references('id')->on('directory_entities')->restrictOnDelete();
            $table->foreignUuid('institution_entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->string('location_label')->nullable();
            $table->string('status', 24)->default('proposed');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->foreignUuid('claim_version_id')->unique()->constrained('claim_versions')->restrictOnDelete();
            $table->timestamps();
            $table->index(['institution_entity_id', 'status']);
        });

        Schema::create('directory_delivery_sites', function (Blueprint $table): void {
            $table->uuid('entity_id')->primary();
            $table->foreign('entity_id')->references('id')->on('directory_entities')->restrictOnDelete();
            $table->foreignUuid('institution_entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->string('location_label')->nullable();
            $table->string('status', 24)->default('proposed');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->foreignUuid('claim_version_id')->unique()->constrained('claim_versions')->restrictOnDelete();
            $table->timestamps();
            $table->index(['institution_entity_id', 'status']);
        });

        Schema::create('programme_catalogue_entries', function (Blueprint $table): void {
            $table->uuid('entity_id')->primary();
            $table->foreign('entity_id')->references('id')->on('directory_entities')->restrictOnDelete();
            $table->foreignUuid('institution_entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('level', 80)->nullable();
            $table->string('status', 24)->default('proposed');
            $table->foreignUuid('claim_version_id')->unique()->constrained('claim_versions')->restrictOnDelete();
            $table->timestamps();
            $table->index(['title', 'status']);
        });

        Schema::create('programme_qualification_links', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('programme_entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->foreignUuid('qualification_entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->foreignUuid('awarding_body_entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->string('status', 24)->default('proposed');
            $table->foreignUuid('claim_version_id')->unique()->constrained('claim_versions')->restrictOnDelete();
            $table->timestamps();
            $table->unique(['programme_entity_id', 'qualification_entity_id', 'awarding_body_entity_id'], 'programme_qualification_awarder_unique');
        });

        Schema::create('programme_offers', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('programme_entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->foreignUuid('delivery_location_entity_id')->constrained('directory_entities')->restrictOnDelete();
            $table->string('admission_cycle', 80);
            $table->string('status', 24)->default('proposed');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->foreignUuid('claim_version_id')->unique()->constrained('claim_versions')->restrictOnDelete();
            $table->timestamps();
            $table->unique(['programme_entity_id', 'delivery_location_entity_id', 'admission_cycle'], 'programme_offer_cycle_unique');
            $table->index(['delivery_location_entity_id', 'admission_cycle', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programme_offers');
        Schema::dropIfExists('programme_qualification_links');
        Schema::dropIfExists('programme_catalogue_entries');
        Schema::dropIfExists('directory_delivery_sites');
        Schema::dropIfExists('directory_campuses');
    }
};
