<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Repositories\Book\BookRepositoryInterface;

class HomeController extends Controller
{
    protected $bookRepo;

    public function __construct(BookRepositoryInterface $bookRepositoryInterface)
    {
        $this->middleware('auth');
        $this->bookRepo = $bookRepositoryInterface;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = $this->bookRepo->getHomePageBook();;

        return view('home', compact('books'));
    }

    public function admin_index()
    {
        return view('admin_index');
    }
}
