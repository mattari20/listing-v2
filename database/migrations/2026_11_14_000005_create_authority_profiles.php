<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authority_profiles', function (Blueprint $table): void {
            $table->uuid('entity_id')->primary();
            $table->foreign('entity_id')->references('id')->on('directory_entities')->restrictOnDelete();
            $table->string('authority_type', 40);
            $table->string('status', 24)->default('active');
            $table->string('registered_by_actor_id', 120);
            $table->timestamps();
            $table->index(['authority_type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authority_profiles');
    }
};
