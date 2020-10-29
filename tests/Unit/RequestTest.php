<?php

namespace Tests\Unit;

use App\Models\Request;
use App\Models\User;
use Tests\TestCase;

class RequestTest extends TestCase
{
    protected $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new Request();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->request);
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'user_id',
            'content',
            'status',
            'manager_id',
        ], $this->request->getFillable());
    }

    public function test_table_name()
    {
        $this->assertEquals('requests', $this->request->getTable());
    }

    public function test_key_name()
    {
        $this->assertEquals('id', $this->request->getKeyName());
    }

    public function test_user_relation()
    {
        $this->belongsTo_relation_test(
            User::class,
            'user_id',
            'id',
            $this->request->user()
        );
    }

    public function test_manager_relation()
    {
        $this->belongsTo_relation_test(
            User::class,
            'manager_id',
            'id',
            $this->request->manager()
        );
    }
}
