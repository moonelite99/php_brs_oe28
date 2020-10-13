<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewFormRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\This;

class ReviewController extends Controller
{
    public function rating(Book $book)
    {
        $total = 0;
        $i = 0;
        foreach ($book->users as $user) {
            $total += $user->pivot->rating;
            $i++;
        }
        $book->update([
            'rating' => round($total / $i, config('default.precision')),
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(ReviewFormRequest $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            $book = Book::findOrFail($request->book_id);
            Review::create($request->all());
            $user->books()->syncWithoutDetaching([$request->book_id => ['rating' => $request->rating]]);
            $this->rating($book);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->back()->with('status', trans('msg.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $review = Review::findOrFail($id);
            $book = $review->book;
            $lastestBook = Book::orderByDesc('publish_date')->limit(config('default.limit_book'))->get();
            $randomBook = Book::all()->random(config('book.suggest_num'));
            $categories = Category::all();
            $comments = Comment::with('user')->where('review_id', $id)->orderBy('created_at')->get();
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
    public function update(ReviewFormRequest $request, $id)
    {
        try {
            $review = Review::findOrFail($id);
            $user = User::findOrFail($request->user_id);
            $book = Book::findOrFail($request->book_id);
            $review->update($request->all());
            $user->books()->syncWithoutDetaching([$request->book_id => ['rating' => $request->rating]]);
            $this->rating($book);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->back()->with('status', trans('msg.success'));
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
            $review = Review::findOrFail($id);
            $user = User::findOrFail($review->user_id);
            $book = Book::findOrFail($review->book_id);
            $user->books()->syncWithoutDetaching([$review->book_id => ['rating' => config('default.rating')]]);
            $this->rating($book);
            $comments = $review->comments();
            foreach ($comments as $comment) {
                $comment->likes()->delete();
            }
            $comments->delete();
            $review->likes()->delete();
            $review->delete();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->back()->with('status', trans('msg.delete_successful'));
    }

    public function history()
    {
        $reviews = Auth::user()->reviews()->paginate(config('default.pagination'));

        return view('history.reviews', compact('reviews'));
    }
}
