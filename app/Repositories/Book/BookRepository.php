<?php

namespace App\Repositories\Book;

use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function getModel()
    {
        return Book::class;
    }

    public function paginateBookAsList()
    {
        return Book::orderByDesc('created_at')->paginate(config('default.pagination'));
    }

    public function paginateBookAsGrid()
    {
        return Book::orderByDesc('created_at')->paginate(config('default.grid_book'));
    }

    public function searchBook($data)
    {
        $books = Book::where('title', 'like', '%' . $data . '%')->get();
        $output = '<li>';
        foreach ($books as $book) {
            $output .= '
               <a href="' . route('show_book', $book->id)  . '">' . $book->title . '</a>
               ';
        }
        if ($books->count() == 0) {
            $output .= trans('msg.find_fail');
        }
        $output .= '</li>';

        return $output;
    }

    public function getCategory()
    {
        $categories = Category::all();
        $output = '<li>';
        foreach ($categories as $category) {
            $output .= '
               <a href="' . route('categorized_book', $category->id)  . '">' . trans('msg.' . $category->name) . '</a>
               ';
        }
        $output .= '</li>';

        return $output;
    }

    public function findCategory($id)
    {
        return Category::findOrFail($id);
    }

    public function getAllCategory()
    {
        return Category::all();
    }

    public function getCategorizeBook($category)
    {
        return $category->books()->paginate(config('default.grid_book'));
    }

    public function getCategorizeName($category)
    {
        return $category->name;
    }

    public function getReadBook($userId)
    {
        $user = User::with('books')->findOrFail($userId);

        return $user->books()->wherePivot('status', config('read.read'))->paginate(config('default.grid_book'));
    }

    public function getReadingBook($userId)
    {
        $user = User::with('books')->findOrFail($userId);

        return $user->books()->wherePivot('status', config('read.reading'))->paginate(config('default.grid_book'));
    }

    public function getFavoriteBook($userId)
    {
        $user = User::with('books')->findOrFail($userId);

        return $user->books()->wherePivot('favorite', config('default.fav'))->paginate(config('default.grid_book'));
    }

    public function storeBook($title, $author, $description, $pages_number, $publish_date, $image, $categories)
    {
        $fileName = uniqid() . $image->getClientOriginalName();
        $image->move(config('img.path'), $fileName);
        $book = Book::create([
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'pages_number' => $pages_number,
            'publish_date' => $publish_date,
            'img_path' => config('img.path') . $fileName,
            'rating' => config('default.rating'),
        ]);
        $book->categories()->sync($categories);
    }

    public function getLastestBook()
    {
        return Book::orderByDesc('publish_date')->limit(config('default.limit_book'))->get();
    }

    public function getRandomBook()
    {
        return Book::all()->random(config('book.suggest_num'));
    }

    public function getReview($id)
    {
        return Review::where('book_id', $id)->orderByDesc('updated_at')->get();
    }

    public function checkExists($book, $userId)
    {
        return $book->users()->where('user_id', $userId)->exists();
    }

    public function getPivot($book, $userId)
    {
        return $book->users()->firstWhere('user_id', $userId)->pivot;
    }

    public function getReviewed($id, $userId)
    {
        return Review::where('book_id', $id)->where('user_id', $userId)->first();
    }

    public function getSelectedCategories($book)
    {
        return $book->categories->pluck('id')->toArray();
    }

    public function updateBook($book, $title, $author, $description, $pages_number, $publish_date, $img_path, $categories)
    {
        $book->update([
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'pages_number' => $pages_number,
            'publish_date' => $publish_date,
            'img_path' => $img_path,
        ]);
        $book->categories()->sync($categories);
    }

    public function deleteBook($id)
    {
        $book = Book::with(['reviews', 'reviews.comments', 'reviews.comments.likes'])->findOrFail($id);
        $reviews = $book->reviews;
        foreach ($reviews as $review) {
            $comments = $review->comments();
            foreach ($comments->get() as $comment) {
                $comment->likes()->delete();
            }
            $comments->delete();
            $review->likes()->delete();
            $review->delete();
        }
        $book->delete();
    }

    public function getHomePageBook()
    {
        return Book::all()->random(config('book.random_num'));
    }

    public function getLastWeekBook()
    {
        return Book::where('created_at', '>=', Carbon::now()->subDays(7))->get();
    }
}
