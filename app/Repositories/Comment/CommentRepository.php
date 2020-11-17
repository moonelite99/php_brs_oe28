<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function getModel()
    {
        return Comment::class;
    }

    public function getLastestComment()
    {
        return Comment::orderByDesc('created_at')->first();
    }

    public function createComment($userId, $reviewId, $content)
    {
        Comment::create([
            'user_id' => $userId,
            'review_id' => $reviewId,
            'content' => $content,
            'like_num' => config('default.like_num'),
        ]);
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->likes()->delete();
        $comment->delete();
    }

    public function getCommentOfReview($id)
    {
        return Comment::with('user')->where('review_id', $id)->orderBy('created_at')->get();
    }

    public function updateLikeNum($id)
    {
        $comment = Comment::withCount('likes')->findOrFail($id);
        $comment->update([
            'like_num' => $comment->likes_count,
        ]);

        return $comment->likes_count;
    }
}
