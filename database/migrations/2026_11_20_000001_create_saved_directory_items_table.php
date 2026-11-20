<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_directory_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('entity_id')->constrained('directory_entities')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'entity_id'], 'saved_directory_user_entity_unique');
            $table->index(['user_id', 'created_at'], 'saved_directory_user_created_lookup');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_directory_items');
    }
};
