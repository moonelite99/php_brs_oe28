<?php

namespace App\Repositories\Like;

use App\Models\Like;
use App\Repositories\BaseRepository;

class LikeRepository extends BaseRepository implements LikeRepositoryInterface
{
    public function getModel()
    {
        return Like::class;
    }

    public function createLike($userId, $likeableId, $likeableType)
    {
        Like::updateOrCreate([
            'user_id' => $userId,
            'likeable_id' => $likeableId,
            'likeable_type' => $likeableType,
        ]);
    }

    public function deleteLike($userId, $likeableId, $likeableType)
    {
        $like = Like::where('user_id', $userId)->where('likeable_id', $likeableId)->where('likeable_type', $likeableType);
        if ($like) {
            $like->delete();
        }
    }
}
