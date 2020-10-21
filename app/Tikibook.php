<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tikibook extends Model
{
    protected $fillable = [
        'title',
        'link',
        'book_id',
    ];
}
