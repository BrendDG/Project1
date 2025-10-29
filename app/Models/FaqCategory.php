<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
    ];

    /**
     * One-to-many relationship: Een categorie heeft meerdere FAQ items
     */
    public function faqItems()
    {
        return $this->hasMany(FaqItem::class)->orderBy('order');
    }
}
