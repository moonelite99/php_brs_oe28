<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Tests\TestCase;

class BookTest extends TestCase
{
    protected $book;

    protected function setUp(): void
    {
        parent::setUp();
        $this->book = new Book();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->book);
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'title',
            'description',
            'publish_date',
            'author',
            'pages_number',
            'rating',
            'img_path',
        ], $this->book->getFillable());
    }

    public function test_table_name()
    {
        $this->assertEquals('books', $this->book->getTable());
    }

    public function test_key_name()
    {
        $this->assertEquals('id', $this->book->getKeyName());
    }

    public function test_categories_relation()
    {
        $this->belongsToMany_relation_test(
            Category::class,
            'category_id',
            'book_id',
            $this->book->categories()
        );
    }

    public function test_users_relation()
    {
        $this->belongsToMany_relation_test(
            User::class,
            'user_id',
            'book_id',
            $this->book->users()
        );
    }

    public function test_reviews_relation()
    {
        $this->hasMany_relation_test(
            Review::class,
            'book_id',
            $this->book->reviews()
        );
    }
}
