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
        'mmr_tournament',
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

    /**
     * Get the rank slug based on MMR for image filename (matches uploaded files)
     */
    public function getRankSlugFromMMR(?int $mmr): ?string
    {
        if ($mmr === null) {
            return null;
        }

        return match(true) {
            $mmr >= 1860 => 'SSL',
            $mmr >= 1660 => 'GC3',
            $mmr >= 1515 => 'GC2',
            $mmr >= 1435 => 'GC1',
            $mmr >= 1355 => 'C3',
            $mmr >= 1275 => 'C2',
            $mmr >= 1195 => 'C1',
            $mmr >= 1115 => 'D3',
            $mmr >= 1035 => 'D2',
            $mmr >= 955 => 'D1',
            $mmr >= 875 => 'P3',
            $mmr >= 795 => 'P2',
            $mmr >= 715 => 'P1',
            $mmr >= 635 => 'G3',
            $mmr >= 555 => 'G2',
            $mmr >= 475 => 'G1',
            $mmr >= 395 => 'Z3',
            $mmr >= 315 => 'Z2',
            $mmr >= 235 => 'Z1',
            $mmr >= 155 => 'Brons3',
            $mmr >= 75 => 'Brons2',
            default => 'Brons1',
        };
    }

    /**
     * Calculate division (1-4) based on MMR within a rank
     */
    public function getDivisionFromMMR(?int $mmr): ?int
    {
        if ($mmr === null) {
            return null;
        }

        // Supersonic Legend heeft geen divisies
        if ($mmr >= 1860) {
            return null;
        }

        // Bepaal de rank boundaries
        $rankBoundaries = [
            ['min' => 1660, 'max' => 1859], // GC3
            ['min' => 1515, 'max' => 1659], // GC2
            ['min' => 1435, 'max' => 1514], // GC1
            ['min' => 1355, 'max' => 1434], // C3
            ['min' => 1275, 'max' => 1354], // C2
            ['min' => 1195, 'max' => 1274], // C1
            ['min' => 1115, 'max' => 1194], // D3
            ['min' => 1035, 'max' => 1114], // D2
            ['min' => 955, 'max' => 1034],  // D1
            ['min' => 875, 'max' => 954],   // P3
            ['min' => 795, 'max' => 874],   // P2
            ['min' => 715, 'max' => 794],   // P1
            ['min' => 635, 'max' => 714],   // G3
            ['min' => 555, 'max' => 634],   // G2
            ['min' => 475, 'max' => 554],   // G1
            ['min' => 395, 'max' => 474],   // S3
            ['min' => 315, 'max' => 394],   // S2
            ['min' => 235, 'max' => 314],   // S1
            ['min' => 155, 'max' => 234],   // B3
            ['min' => 75, 'max' => 154],    // B2
            ['min' => 0, 'max' => 74],      // B1
        ];

        // Zoek de rank waarin de MMR valt
        foreach ($rankBoundaries as $boundary) {
            if ($mmr >= $boundary['min'] && $mmr <= $boundary['max']) {
                $range = $boundary['max'] - $boundary['min'] + 1;
                $position = $mmr - $boundary['min'];
                $divisionSize = $range / 4;

                // Bereken divisie (1-4)
                $division = (int) ceil(($position + 1) / $divisionSize);
                return min(4, max(1, $division));
            }
        }

        return 1; // Default naar Division I
    }

    /**
     * Get the rank image path based on MMR (with automatic division)
     */
    public function getRankImage(?int $mmr): string
    {
        if ($mmr === null) {
            return asset('unranked.png');
        }

        $rankSlug = $this->getRankSlugFromMMR($mmr);

        return asset("{$rankSlug}.png");
    }

    /**
     * Get division roman numeral (automatic calculation)
     */
    public function getDivisionText(?int $mmr): string
    {
        $division = $this->getDivisionFromMMR($mmr);

        if ($division === null) {
            return '';
        }

        return match($division) {
            1 => 'Division I',
            2 => 'Division II',
            3 => 'Division III',
            4 => 'Division IV',
            default => '',
        };
    }
}
