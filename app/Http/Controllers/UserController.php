<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserFormRequest;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(config('default.pagination'));

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.create')->with('status', trans('msg.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')->with('fail_status', trans('msg.find_fail'));
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserFormRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            if ($request->password == '') {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->route('users.edit', $user->id)->with('status', trans('msg.update_successful'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->route('users.index')->with('status', trans('msg.delete_successful'));
    }
}
