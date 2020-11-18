<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function paginateUserAsList();

    public function createUser($name, $email, $username, $password);

    public function updateUser($name, $email, $password, $id);

    public function deleteUser($id);

    public function getAdmin();
}
