<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->category);
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'name',
        ], $this->category->getFillable());
    }

    public function test_table_name()
    {
        $this->assertEquals('categories', $this->category->getTable());
    }

    public function test_key_name()
    {
        $this->assertEquals('id', $this->category->getKeyName());
    }

    public function test_books_relation()
    {
        $this->belongsToMany_relation_test(
            Book::class,
            'book_id',
            'category_id',
            $this->category->books()
        );
    }
}
