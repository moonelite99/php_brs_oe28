<?php

namespace App\Repositories\Like;

use App\Repositories\RepositoryInterface;

interface LikeRepositoryInterface extends RepositoryInterface
{
    public function createLike($userId, $likeableId, $likeableType);

    public function deleteLike($userId, $likeableId, $likeableType);
}
