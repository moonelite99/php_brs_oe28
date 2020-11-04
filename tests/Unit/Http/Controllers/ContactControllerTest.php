<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\ContactController;
use App\Models\Request as Contact;
use App\Models\User;
use Tests\TestCase;
use Mockery;
use App\Repositories\Contact\ContactRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ContactFormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $contact;

    public function setUp(): void
    {
        $this->contactMock = Mockery::mock(ContactRepositoryInterface::class);
        $this->contactController = new ContactController(
            $this->contactMock,
        );
        parent::setUp();
    }

    public function tearDown(): void
    {
        unset($this->contactController);
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_function()
    {
        $user = new User();
        $user->id = 1;
        $this->be($user);

        $this->contactMock
            ->shouldReceive('findByUser')
            ->with($user->id)
            ->once()
            ->andReturn(new Collection());

        $result = $this->contactController->index();
        $data = $result->getData();

        $this->assertEquals('sent_requests', $result->getName());
        $this->assertArrayHasKey('contacts', $data);
    }

    public function test_solve_function()
    {
        $status = config('default.req_unsolved');

        $this->contactMock
            ->shouldReceive('findByStatus')
            ->with($status)
            ->once()
            ->andReturn(new Collection());

        $result = $this->contactController->solve($status);
        $data = $result->getData();

        $this->assertEquals('contacts.index', $result->getName());
        $this->assertArrayHasKey('contacts', $data);
        $this->assertArrayHasKey('status', $data);
    }

    public function test_create_function()
    {
        $result = $this->contactController->create();

        $this->assertEquals('contact', $result->getName());
    }

    public function test_store_function()
    {
        $userId = 1;
        $content = 'test';

        $this->contactMock
            ->shouldReceive('createContact')
            ->with($content, $userId)
            ->once()
            ->andReturn(new Contact());

        $request = new ContactFormRequest([
            'contact' => $content,
            'user_id' => $userId,
        ]);
        $result = $this->contactController->store($request);
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(
            route('contacts.create'),
            $result->headers->get('Location'),
        );
        $this->assertArrayHasKey('status', $result->getSession()->all());
    }

    public function test_update_function()
    {
        $id = 1;
        $data = [
            'status' => config('default.req_solved'),
            'manager_id' => 1,
        ];
        session()->setPreviousUrl(route('requests', config('default.req_unsolved')));

        $this->contactMock
            ->shouldReceive('update')
            ->with($data, $id)
            ->once()
            ->andReturn(new Contact());

        $request = new ContactFormRequest($data);
        $result = $this->contactController->update($request, $id);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(
            route('requests', config('default.req_unsolved')),
            $result->headers->get('Location')
        );
        $this->assertArrayHasKey('status', $result->getSession()->all());
    }

    public function test_update_function_fail()
    {
        $id = 1;
        $data = [
            'status' => config('default.req_solved'),
            'manager_id' => 1,
        ];
        session()->setPreviousUrl(route('requests', config('default.req_unsolved')));

        $this->contactMock
            ->shouldReceive('update')
            ->once()
            ->andThrow(new ModelNotFoundException());

        $request = new ContactFormRequest($data);
        $result = $this->contactController->update($request, $id);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(
            route('requests', config('default.req_unsolved')),
            $result->headers->get('Location')
        );
        $this->assertArrayHasKey('fail_status', $result->getSession()->all());
    }

    public function test_destroy_function()
    {
        $id = 1;
        session()->setPreviousUrl(route('requests', config('default.req_unsolved')));

        $this->contactMock
            ->shouldReceive('delete')
            ->with($id)
            ->once()
            ->andReturn(true);

        $result = $this->contactController->destroy($id);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(
            route('requests', config('default.req_unsolved')),
            $result->headers->get('Location')
        );
        $this->assertArrayHasKey('status', $result->getSession()->all());
    }

    public function test_destroy_function_fail()
    {
        $id = 1;
        session()->setPreviousUrl(route('requests', config('default.req_unsolved')));

        $this->contactMock
            ->shouldReceive('delete')
            ->with($id)
            ->andThrow(new ModelNotFoundException());

        $result = $this->contactController->destroy($id);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(
            route('requests', config('default.req_unsolved')),
            $result->headers->get('Location')
        );
        $this->assertArrayHasKey('fail_status', $result->getSession()->all());
    }
}
