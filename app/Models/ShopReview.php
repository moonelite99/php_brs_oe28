<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopReview extends Model
{
    protected $fillable = [
        'tiki_book_id',
        'username',
        'title',
        'content',
        'rating',
        'reviewed_at',
        'type',
        'updated_at',
    ];
}
