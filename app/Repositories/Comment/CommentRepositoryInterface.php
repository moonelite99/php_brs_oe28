<?php

namespace App\Repositories\Comment;

use App\Repositories\RepositoryInterface;

interface CommentRepositoryInterface extends RepositoryInterface
{
    public function getLastestComment();

    public function createComment($userId, $reviewId, $content);

    public function deleteComment($id);

    public function getCommentOfReview($id);

    public function updateLikeNum($id);
}
