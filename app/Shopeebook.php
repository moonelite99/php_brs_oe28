<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shopeebook extends Model
{
    protected $fillable = [
        'link',
        'book_id',
        'shop_id',
        'tiki_book_id',
    ];
}
