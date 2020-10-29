<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Tests\TestCase;

class LikeTest extends TestCase
{
    protected $like;

    protected function setUp(): void
    {
        parent::setUp();
        $this->like = new Like();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->like);
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'user_id',
            'likeable_id',
            'likeable_type',
        ], $this->like->getFillable());
    }

    public function test_table_name()
    {
        $this->assertEquals('likes', $this->like->getTable());
    }

    public function test_key_name()
    {
        $this->assertEquals('id', $this->like->getKeyName());
    }

    public function test_user_relation()
    {
        $this->belongsTo_relation_test(
            User::class,
            'user_id',
            'id',
            $this->like->user()
        );
    }

    public function test_comment_relation()
    {
        $this->morphTo_relation_test(
            Comment::class,
            'likeable_type',
            'likeable_id',
            $this->like->likeable()
        );
    }
}
