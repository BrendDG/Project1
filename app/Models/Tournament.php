<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'tournament_date',
        'start_time',
        'end_time',
        'max_participants',
        'game_mode',
        'prize_pool',
        'status',
        'image',
        'created_by'
    ];

    protected $casts = [
        'tournament_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the user who created this tournament
     * One-to-Many relationship (User has many Tournaments)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all participants for this tournament
     * Many-to-Many relationship (Tournament has many Users, User has many Tournaments)
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'tournament_user')
            ->withPivot('registered_at', 'placement', 'checked_in')
            ->withTimestamps();
    }

    /**
     * Check if user is registered for this tournament
     */
    public function isUserRegistered($userId)
    {
        return $this->participants()->where('user_id', $userId)->exists();
    }

    /**
     * Check if tournament is full
     */
    public function isFull()
    {
        return $this->participants()->count() >= $this->max_participants;
    }

    /**
     * Get available spots
     */
    public function getAvailableSpots()
    {
        return max(0, $this->max_participants - $this->participants()->count());
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'upcoming' => 'status-upcoming',
            'ongoing' => 'status-ongoing',
            'completed' => 'status-completed',
            'cancelled' => 'status-cancelled',
            default => 'status-upcoming'
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabel()
    {
        return match($this->status) {
            'upcoming' => 'Binnenkort',
            'ongoing' => 'Bezig',
            'completed' => 'Afgelopen',
            'cancelled' => 'Geannuleerd',
            default => 'Binnenkort'
        };
    }

    /**
     * Scope for upcoming tournaments
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')
            ->where('tournament_date', '>=', now()->toDateString())
            ->orderBy('tournament_date')
            ->orderBy('start_time');
    }

    /**
     * Scope for ongoing tournaments
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing')
            ->orderBy('tournament_date')
            ->orderBy('start_time');
    }

    /**
     * Scope for completed tournaments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed')
            ->orderBy('tournament_date', 'desc')
            ->orderBy('start_time', 'desc');
    }
}
