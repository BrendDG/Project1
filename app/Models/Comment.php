<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'nieuws_id',
        'user_id',
        'content',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the nieuws that this comment belongs to
     * Many-to-One relationship
     */
    public function nieuws()
    {
        return $this->belongsTo(Nieuws::class);
    }

    /**
     * Get the user who wrote this comment
     * Many-to-One relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
