<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'banner_image',
        'status',
        'voting_type',
        'show_results',
        'price',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the candidates for the event.
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class)->orderBy('candidate_number', 'asc');
    }

    /**
     * Get the tokens for the event.
     */
    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }

    /**
     * Get the votes for the event.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class)->where('payment_status', 'completed');
    }

    /**
     * Check if the event is active and open for voting.
     */
    public function isOpen(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $now = now();

        if ($this->start_time && $now->lt($this->start_time)) {
            return false;
        }

        if ($this->end_time && $now->gt($this->end_time)) {
            return false;
        }

        return true;
    }
}
