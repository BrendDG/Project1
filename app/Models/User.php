<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'birthday',
        'profile_photo',
        'about_me',
        'mmr_1v1',
        'mmr_2v2',
        'mmr_3v3',
        'mmr_hoops',
        'mmr_rumble',
        'mmr_dropshot',
        'mmr_snowday',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthday' => 'date',
        ];
    }

    /**
     * Get the display name for the user (username or name)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->username ?? $this->name;
    }

    /**
     * Get the profile photo URL
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo
            ? asset('storage/' . $this->profile_photo)
            : asset('default-avatar.png');
    }

    /**
     * Get the rank name based on MMR
     */
    public function getRankFromMMR(?int $mmr): ?string
    {
        if ($mmr === null) {
            return null;
        }

        return match(true) {
            $mmr >= 1860 => 'Supersonic Legend',
            $mmr >= 1660 => 'Grand Champion III',
            $mmr >= 1515 => 'Grand Champion II',
            $mmr >= 1435 => 'Grand Champion I',
            $mmr >= 1355 => 'Champion III',
            $mmr >= 1275 => 'Champion II',
            $mmr >= 1195 => 'Champion I',
            $mmr >= 1115 => 'Diamond III',
            $mmr >= 1035 => 'Diamond II',
            $mmr >= 955 => 'Diamond I',
            $mmr >= 875 => 'Platinum III',
            $mmr >= 795 => 'Platinum II',
            $mmr >= 715 => 'Platinum I',
            $mmr >= 635 => 'Gold III',
            $mmr >= 555 => 'Gold II',
            $mmr >= 475 => 'Gold I',
            $mmr >= 395 => 'Silver III',
            $mmr >= 315 => 'Silver II',
            $mmr >= 235 => 'Silver I',
            $mmr >= 155 => 'Bronze III',
            $mmr >= 75 => 'Bronze II',
            default => 'Bronze I',
        };
    }
}
