<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentFormRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comment = Comment::orderByDesc('created_at')->first();
        $username = $comment->user()->first()->name;

        return response()->json([
            'comment' => $comment,
            'username' => $username,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentFormRequest $request)
    {
        Comment::create([
            'user_id' => $request->user_id,
            'review_id' => $request->review_id,
            'content' => $request->content,
            'like_num' => config('default.like_num'),
        ]);

        return response()->json(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentFormRequest $request, $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->update([
                'user_id' => $request->user_id,
                'review_id' => $request->review_id,
                'content' => $request->content,
                'like_num' => $comment->like_num,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return response()->json(200);
    }
}
