<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class ModerationCase extends Model
{
    protected $fillable = [
        'scope_type',
        'scope_id',
        'category',
        'status',
        'reporter_user_id',
        'reviewer_user_id',
        'outcome_code',
        'reason_code',
        'synthetic_reference',
    ];

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_user_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_user_id');
    }

    public function appeal(): HasOne
    {
        return $this->hasOne(ModerationAppeal::class);
    }
}
