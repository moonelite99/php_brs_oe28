<?php

namespace App\Repositories\Contact;

use App\Repositories\BaseRepository;
use App\Models\Request as Contact;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function getModel()
    {
        return Contact::class;
    }

    public function findByStatus($status)
    {
        return Contact::with('user', 'manager')->where('status', $status)->paginate(config('default.pagination'));
    }

    public function findByUser($userId)
    {
        return Contact::where('user_id', $userId)->orderByDesc('created_at')->paginate(config('default.pagination'));
    }

    public function createContact($content, $userId)
    {
        return Contact::create([
            'content' => $content,
            'status' => config('default.req_unsolved'),
            'user_id' => $userId,
        ]);
    }
}
