<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentFormRequest;
use App\Models\Comment;
use App\Repositories\Comment\CommentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentController extends Controller
{
    protected $commentRepo;

    public function __construct(CommentRepositoryInterface $commentRepositoryInterface)
    {
        $this->commentRepo = $commentRepositoryInterface;
    }

    public function index()
    {
        $comment = $this->commentRepo->getLastestComment();;
        $username = $comment->user()->first()->name;

        return response()->json([
            'comment' => $comment,
            'username' => $username,
        ], 200);
    }

    public function store(CommentFormRequest $request)
    {
        $this->commentRepo->createComment(
            $request->user_id,
            $request->review_id,
            $request->content,
        );

        return response()->json(200);
    }

    public function update(CommentFormRequest $request, $id)
    {
        try {
            $this->commentRepo->update($request->all(), $id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return response()->json(200);
    }

    public function destroy($id)
    {
        try {
            $this->commentRepo->deleteComment($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return response()->json(200);
    }
}
