<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nieuws extends Model
{
    use HasFactory;

    protected $table = 'nieuws';

    protected $fillable = [
        'title',
        'image',
        'content',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Scope to only get published news items
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now())
                     ->orderBy('published_at', 'desc');
    }

    /**
     * Get all comments for this nieuws
     * One-to-Many relationship
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
