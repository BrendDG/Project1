<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'faq_category_id',
        'question',
        'answer',
        'order',
    ];

    /**
     * Many-to-one relationship: Een FAQ item behoort tot een categorie
     */
    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }
}
