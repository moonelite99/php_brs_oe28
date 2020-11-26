<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function paginateUserAsList()
    {
        return User::orderByDesc('created_at')->paginate(config('default.pagination'));
    }

    public function createUser($name, $email, $username, $password)
    {
        User::create([
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'password' => bcrypt($password),
        ]);
    }

    public function updateUser($name, $email, $password, $id)
    {
        $user = User::findOrFail($id);
        if ($password == '') {
            $user->update([
                'name' => $name,
                'email' => $email,
            ]);
        } else {
            $user->update([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]);
        }
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function getAdmin()
    {
        return User::where('role', config('role.admin'))->get();
    }
}
