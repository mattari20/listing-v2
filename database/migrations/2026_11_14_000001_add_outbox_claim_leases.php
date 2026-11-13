<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('governance_outbox', function (Blueprint $table): void {
            $table->uuid('claim_token')->nullable();
            $table->timestamp('claimed_at')->nullable();
            $table->index(['status', 'claimed_at', 'available_at'], 'governance_outbox_claim_idx');
        });
    }

    public function down(): void
    {
        Schema::table('governance_outbox', function (Blueprint $table): void {
            $table->dropIndex('governance_outbox_claim_idx');
            $table->dropColumn(['claim_token', 'claimed_at']);
        });
    }
};
