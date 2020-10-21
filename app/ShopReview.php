<?php

namespace App;

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
    ];
}
