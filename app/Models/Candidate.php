<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'candidate_number',
        'photo',
        'description',
    ];

    /**
     * Get the event that owns the candidate.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the votes for the candidate.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class)->where('payment_status', 'completed');
    }
}
