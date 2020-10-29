<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Review;
use App\Models\User;
use Tests\TestCase;

class CommentTest extends TestCase
{
    protected $comment;

    protected function setUp(): void
    {
        parent::setUp();
        $this->comment = new Comment();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->comment);
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'review_id',
            'user_id',
            'content',
            'like_num',
        ], $this->comment->getFillable());
    }

    public function test_table_name()
    {
        $this->assertEquals('comments', $this->comment->getTable());
    }

    public function test_key_name()
    {
        $this->assertEquals('id', $this->comment->getKeyName());
    }

    public function test_likes_relation()
    {
        $this->morphMany_relation_test(
            Like::class,
            'likeable_type',
            'likeable_id',
            $this->comment->likes()
        );
    }

    public function test_user_relation()
    {
        $this->belongsTo_relation_test(
            User::class,
            'user_id',
            'id',
            $this->comment->user()
        );
    }

    public function test_review_relation()
    {
        $this->belongsTo_relation_test(
            Review::class,
            'review_id',
            'id',
            $this->comment->review()
        );
    }
}
