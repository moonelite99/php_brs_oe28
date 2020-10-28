<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Review;
use App\Models\User;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    protected $review;

    protected function setUp(): void
    {
        parent::setUp();
        $this->review = new Review();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->review);
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'title',
            'content',
            'book_id',
            'user_id',
            'like_num',
        ], $this->review->getFillable());
    }

    public function test_table_name()
    {
        $this->assertEquals('reviews', $this->review->getTable());
    }

    public function test_key_name()
    {
        $this->assertEquals('id', $this->review->getKeyName());
    }

    public function test_user_relation()
    {
        $this->belongsTo_relation_test(
            User::class,
            'user_id',
            'id',
            $this->review->user()
        );
    }

    public function test_book_relation()
    {
        $this->belongsTo_relation_test(
            Book::class,
            'book_id',
            'id',
            $this->review->book()
        );
    }

    public function test_likes_relation()
    {
        $this->morphMany_relation_test(
            Like::class,
            'likeable_type',
            'likeable_id',
            $this->review->likes()
        );
    }

    public function test_comments_relation()
    {
        $this->hasMany_relation_test(
            Comment::class,
            'review_id',
            $this->review->comments()
        );
    }
}
