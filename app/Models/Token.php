<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Token extends Model
{
    protected $fillable = [
        'event_id',
        'code',
        'is_used',
        'voted_at',
        'voter_email',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'voted_at' => 'datetime',
    ];

    /**
     * Get the event that owns the token.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
