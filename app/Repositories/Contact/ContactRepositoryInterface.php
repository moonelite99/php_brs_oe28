<?php

namespace App\Repositories\Contact;

use App\Repositories\RepositoryInterface;

interface ContactRepositoryInterface extends RepositoryInterface
{
    public function findByStatus($status);

    public function findByUser($userId);

    public function createContact($content, $userId);
}
