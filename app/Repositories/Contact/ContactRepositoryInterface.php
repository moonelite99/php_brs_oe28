<?php

namespace App\Repositories\Contact;

use App\Repositories\BaseRepository;

interface ContactRepositoryInterface
{
    public function findByStatus($status);

    public function findByUser($userId);

    public function createContact($content, $userId);
}
