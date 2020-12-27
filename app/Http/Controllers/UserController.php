<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserFormRequest;
use App\Http\Requests\UserFormRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepo = $userRepositoryInterface;
    }
    public function index()
    {
        $users = $this->userRepo->paginateUserAsList();;

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserFormRequest $request)
    {
        $this->userRepo->createUser(
            $request->name,
            $request->email,
            $request->username,
            $request->password,
        );

        return redirect()->route('users.index')->with('status', trans('msg.create_success'));
    }

    public function edit($id)
    {
        try {
            $user = $this->userRepo->find($id);;
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')->with('fail_status', trans('msg.find_fail'));
        }

        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserFormRequest $request, $id)
    {
        try {
            $this->userRepo->updateUser(
                $request->name,
                $request->email,
                $request->password,
                $id,
            );
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->route('users.edit', $id)->with('status', trans('msg.update_successful'));
    }

    public function destroy($id)
    {
        try {
            $this->userRepo->deleteUser($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->route('users.index')->with('status', trans('msg.delete_successful'));
    }
}
