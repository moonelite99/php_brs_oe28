<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewFormRequest;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReviewController extends Controller
{
    protected $reviewRepo;
    protected $bookRepo;
    protected $commentRepo;

    public function __construct(
        ReviewRepositoryInterface $reviewRepositoryInterface,
        BookRepositoryInterface $bookRepositoryInterface,
        CommentRepositoryInterface $commentRepositoryInterface
    ) {
        $this->reviewRepo = $reviewRepositoryInterface;
        $this->bookRepo = $bookRepositoryInterface;
        $this->commentRepo = $commentRepositoryInterface;
    }

    public function store(ReviewFormRequest $request)
    {
        try {
            $this->reviewRepo->createReview(
                $request->user_id,
                $request->book_id,
                $request->rating,
            );
            $this->reviewRepo->create($request->all());
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->back()->with('status', trans('msg.success'));
    }

    public function show($id)
    {
        try {
            $review = $this->reviewRepo->find($id);;
            $book = $review->book;
            $lastestBook = $this->bookRepo->getLastestBook();
            $randomBook = $this->bookRepo->getRandomBook();
            $categories = $this->bookRepo->getAllCategory();
            $comments = $this->commentRepo->getCommentOfReview($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return view('reviews.show', compact([
            'review',
            'book',
            'lastestBook',
            'randomBook',
            'categories',
            'comments',
        ]));
    }

    public function update(ReviewFormRequest $request, $id)
    {
        try {
            $this->reviewRepo->updateReview(
                $request->user_id,
                $request->book_id,
                $request->rating,
            );
            $this->reviewRepo->update($request->all(), $id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->back()->with('status', trans('msg.success'));
    }

    public function destroy($id)
    {
        try {
            $this->reviewRepo->deleteReview($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->back()->with('status', trans('msg.delete_successful'));
    }

    public function history()
    {
        $reviews = $this->reviewRepo->getHistory();;

        return view('history.reviews', compact('reviews'));
    }
}
