<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ModerationEvent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'moderation_case_id',
        'moderation_appeal_id',
        'actor_user_id',
        'event_type',
        'from_state',
        'to_state',
        'reason_code',
        'created_at',
    ];

    protected function casts(): array
    {
        return ['created_at' => 'immutable_datetime'];
    }

    public function moderationCase(): BelongsTo
    {
        return $this->belongsTo(ModerationCase::class);
    }

    public function moderationAppeal(): BelongsTo
    {
        return $this->belongsTo(ModerationAppeal::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }
}
