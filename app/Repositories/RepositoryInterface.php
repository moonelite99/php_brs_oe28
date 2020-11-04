<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll();

    public function find($id);

    public function create($attribute = []);

    public function update($attribute = [], $id);

    public function delete($id);
}
