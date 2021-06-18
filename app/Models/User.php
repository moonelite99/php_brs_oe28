<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot('rating', 'status', 'favorite');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
