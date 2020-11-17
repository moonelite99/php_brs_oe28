<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Like\LikeRepositoryInterface;
use App\Repositories\Review\ReviewRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class MarkingController extends Controller
{
    protected $userRepo;
    protected $reviewRepo;
    protected $commentRepo;
    protected $likeRepo;

    public function __construct(
        UserRepositoryInterface $userRepositoryInterface,
        ReviewRepositoryInterface $reviewRepositoryInterface,
        CommentRepositoryInterface $commentRepositoryInterface,
        LikeRepositoryInterface $likeRepositoryInterface
    ) {
        $this->userRepo = $userRepositoryInterface;
        $this->reviewRepo = $reviewRepositoryInterface;
        $this->commentRepo = $commentRepositoryInterface;
        $this->likeRepo = $likeRepositoryInterface;
    }

    public function updateReview($id)
    {
        try {
            $likeNumber = $this->reviewRepo->updateLikeNum($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return $likeNumber;
    }

    public function updateComment($id)
    {
        try {
            $likeNumber = $this->commentRepo->updateLikeNum($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return $likeNumber;
    }

    public function like(Request $request)
    {
        if ($request->like) {
            $this->likeRepo->createLike(
                $request->user_id,
                $request->likeable_id,
                $request->likeable_type,
            );
        } else {
            $this->likeRepo->deleteLike(
                $request->user_id,
                $request->likeable_id,
                $request->likeable_type,
            );
        }
        if ($request->likeable_type == Review::class) {
            return $this->updateReview($request->likeable_id);
        }

        return $this->updateComment($request->likeable_id);
    }

    public function mark(Request $request)
    {
        try {
            $user = $this->userRepo->find($request->user_id);;
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
