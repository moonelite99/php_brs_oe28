<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'description',
        'publish_date',
        'author',
        'pages_number',
        'rating',
        'img_path',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('rating', 'status', 'favorite');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function tikiBook()
    {
        return $this->hasOne(Tikibook::class, 'book_id', 'tiki_book_id');
    }

    public function shopeeBook()
    {
        return $this->hasOne(Shopeebook::class, 'tiki_book_id', 'tiki_book_id');
    }
}
