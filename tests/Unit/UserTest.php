<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Request;
use App\Models\Review;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->user);
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'name',
            'email',
            'username',
            'password',
        ], $this->user->getFillable());
    }

    public function test_table_name()
    {
        $this->assertEquals('users', $this->user->getTable());
    }

    public function test_key_name()
    {
        $this->assertEquals('id', $this->user->getKeyName());
    }

    public function test_comments_relation()
    {
        $this->hasMany_relation_test(
            Comment::class,
            'user_id',
            $this->user->comments()
        );
    }

    public function test_likes_relation()
    {
        $this->hasMany_relation_test(
            Like::class,
            'user_id',
            $this->user->likes()
        );
    }

    public function test_requests_relation()
    {
        $this->hasMany_relation_test(
            Request::class,
            'user_id',
            $this->user->requests()
        );
    }

    public function test_reviews_relation()
    {
        $this->hasMany_relation_test(
            Review::class,
            'user_id',
            $this->user->reviews()
        );
    }

    public function test_books_relation()
    {
        $this->belongsToMany_relation_test(
            Book::class,
            'book_id',
            'user_id',
            $this->user->books()
        );
    }
}
