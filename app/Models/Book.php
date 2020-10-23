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
}
