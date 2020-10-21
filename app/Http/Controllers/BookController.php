<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookFormRequest;
use App\Http\Requests\UpdateBookFormRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Book\BookRepositoryInterface;

class BookController extends Controller
{
    protected $bookRepo;

    public function __construct(BookRepositoryInterface $bookRepositoryInterface)
    {
        $this->bookRepo = $bookRepositoryInterface;
    }

    public function index()
    {
        $books = $this->bookRepo->paginateBookAsList();

        return view('books.index', compact('books'));
    }

    public function show_all()
    {
        $books = $this->bookRepo->paginateBookAsGrid();
        return view('books', compact('books'));
    }

    public function search(Request $request)
    {
        return $this->bookRepo->searchBook($request->data);
    }

    public function getCategory()
    {
        return $this->bookRepo->getCategory();
    }

    public function categorize($id)
    {
        try {
            $category = $this->bookRepo->findCategory($id);
            $books = $this->bookRepo->getCategorizeBook($category);
            $name = $this->bookRepo->getCategorizeName($category);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return view('books.categorize', compact(['books', 'name']));
    }

    public function history()
    {
        try {
            $books = $this->bookRepo->getReadBook(Auth::user()->id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return view('history.books', compact('books'));
    }

    public function reading()
    {
        try {
            $books = $this->bookRepo->getReadingBook(Auth::user()->id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return view('books.reading', compact('books'));
    }

    public function favorite()
    {
        try {
            $books = $this->bookRepo->getFavoriteBook(Auth::user()->id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return view('books.fav', compact('books'));
    }

    public function create()
    {
        $categories = $this->bookRepo->getAllCategory();

        return view('books.create', compact('categories'));
    }

    public function store(BookFormRequest $request)
    {
        $this->bookRepo->storeBook(
            $request->title,
            $request->author,
            $request->description,
            $request->pages_number,
            $request->publish_date,
            $request->image,
            $request->categories,
        );

        return redirect()->route('books.create')->with('status', trans('msg.create_success'));
    }

    public function show($id)
    {
        try {
            $book = $this->bookRepo->find($id);
            $selectedCategories = $book->categories;
            $lastestBook = $this->bookRepo->getLastestBook();
            $randomBook = $this->bookRepo->getRandomBook();
            $categories = $this->bookRepo->getAllCategory();
            $rated = config('default.rating');
            $status = config('read.unread');
            $favorite = config('default.not_fav');
            $reviewed = '';
            $reviews = $this->bookRepo->getReview($id);
            $exists = $this->bookRepo->checkExists($book, Auth::user()->id);
            if ($exists) {
                $pivot = $this->bookRepo->getPivot($book, Auth::user()->id);
                $rated = $pivot->rating;
                $status = $pivot->status;
                $favorite = $pivot->favorite;
                if ($rated != config('default.rating')) {
                    $reviewed = $this->bookRepo->getReviewed($id, Auth::user()->id);
                }
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
            'reviews',
            'reviewed',
            'status',
            'favorite',
            'tikiReviews',
            'shopeeReviews',
        ]));
    }

    public function edit($id)
    {
        try {
            $book = $this->bookRepo->find($id);
            $categories = $this->bookRepo->getAllCategory();
            $selectedCategories = $this->bookRepo->getSelectedCategories($book);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books.index')->with('fail_status', trans('msg.find_fail'));
        }

        return view('books.edit', compact(['book', 'categories', 'selectedCategories']));
    }

    public function update(UpdateBookFormRequest $request, $id)
    {
        try {
            $book = $this->bookRepo->find($id);
            if ($request->has('image')) {
                $image = $request->image;
                $fileName = uniqid() . $image->getClientOriginalName();
                $image->move(config('img.path'), $fileName);
                $img_path = config('img.path') . $fileName;
            } else {
                $img_path = $book->img_path;
            }
            $this->bookRepo->updateBook(
                $book,
                $request->title,
                $request->author,
                $request->description,
                $request->pages_number,
                $request->publish_date,
                $img_path,
                $request->categories,
            );
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books.index')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->route('books.edit', $book->id)->with('status', trans('msg.update_successful'));
    }

    public function destroy($id)
    {
        try {
            $this->bookRepo->deleteBook($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('books.index')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->route('books.index')->with('status', trans('msg.delete_successful'));
    }
}
