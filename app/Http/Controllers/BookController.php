<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookFormRequest;
use App\Http\Requests\UpdateBookFormRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderByDesc('created_at')->paginate(config('default.pagination'));

        return view('books.index', compact('books'));
    }

    public function show_all()
    {
        $books = Book::orderByDesc('created_at')->paginate(config('default.grid_book'));

        return view('books', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookFormRequest $request)
    {
        $image = $request->image;
        $fileName = uniqid() . $image->getClientOriginalName();
        $image->move(config('img.path'), $fileName);
        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'pages_number' => $request->pages_number,
            'publish_date' => $request->publish_date,
            'img_path' => config('img.path') . $fileName,
            'rating' => config('default.rating'),
        ]);
        $book->categories()->sync($request->categories);

        return redirect()->route('books.create')->with('status', trans('msg.create_success'));
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
            $book = Book::findOrFail($id);
            $selectedCategories = $book->categories;
            $lastestBook = Book::orderByDesc('publish_date')->limit(config('default.limit_book'))->get();
            $randomBook = Book::all()->random(config('book.suggest_num'));
            $categories = Category::all();
            $rated = config('default.rating');
            $reviews = Review::where('book_id', $id)->get();
            if ($book->users()->where('user_id', Auth::user()->id)->exists()) {
                $rated = $book->users()->firstWhere('user_id', Auth::user()->id)->pivot->rating;
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books')->with('fail_status', trans('msg.find_fail'));
        }

        return view('show_book', compact([
            'book',
            'selectedCategories',
            'lastestBook',
            'randomBook',
            'categories',
            'rated',
            'reviews']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $book = Book::findOrFail($id);
            $categories = Category::all();
            $selectedCategories = $book->categories->pluck('id')->toArray();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books.index')->with('fail_status', trans('msg.find_fail'));
        }

        return view('books.edit', compact(['book', 'categories', 'selectedCategories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookFormRequest $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            if ($request->has('image')) {
                $image = $request->image;
                $fileName = uniqid() . $image->getClientOriginalName();
                $image->move(config('img.path'), $fileName);
                $img_path = config('img.path') . $fileName;
            } else {
                $img_path = $book->img_path;
            }
            $book->update([
                'title' => $request->title,
                'author' => $request->author,
                'description' => $request->description,
                'pages_number' => $request->pages_number,
                'publish_date' => $request->publish_date,
                'img_path' => $img_path,
                'rating' => $book->rating,
            ]);
            $book->categories()->sync($request->categories);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books.index')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->route('books.edit', $book->id)->with('status', trans('msg.update_successful'));
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
            $book = Book::findOrFail($id);
            $book->delete();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books.index')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->route('books.index')->with('status', trans('msg.delete_successful'));
    }
}
