<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class MarkingController extends Controller
{
    public function updateReview($id)
    {
        try {
            $review = Review::withCount('likes')->findOrFail($id);
            $review->update([
                'like_num' => $review->likes_count,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return $review->likes_count;
    }

    public function updateComment($id)
    {
        try {
            $comment = Comment::withCount('likes')->findOrFail($id);
            $comment->update([
                'like_num' => $comment->likes_count,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return $comment->likes_count;
    }

    public function like(Request $request)
    {
        if ($request->like) {
            Like::updateOrCreate([
                'user_id' => $request->user_id,
                'likeable_id' => $request->likeable_id,
                'likeable_type' => $request->likeable_type,
            ]);
        } else {
            $like = Like::where('user_id', $request->user_id)->where('likeable_id', $request->likeable_id)->where('likeable_type', $request->likeable_type);
            $like->delete();
        }
        if ($request->likeable_type == Review::class) {
            return $this->updateReview($request->likeable_id);
        }

        return $this->updateComment($request->likeable_id);
    }

    public function mark(Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            if ($request->has('status')) {
                $user->books()->syncWithoutDetaching([$request->book_id => ['status' => $request->status]]);
            } else {
                $user->books()->syncWithoutDetaching([$request->book_id => ['favorite' => $request->favorite]]);
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return response()->json(200);
    }
}
