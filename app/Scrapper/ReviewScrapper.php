<?php

namespace App\Scraper;

use App\Models\Book;
use App\Models\Shopeebook;
use App\Models\ShopReview;
use App\Models\Tikibook;

class ReviewScrapper
{
    function scrapeTikiReview()
    {
        $books = Tikibook::all();
        foreach ($books as $book) {
            $product_id = $book->book_id;

            $api_url = 'https://tiki.vn/api/v2/reviews?product_id=' . $product_id . '&sort=score%7Cdesc,id%7Cdesc,stars%7Call&page=1&limit=10&include=comments';

            $data = file_get_contents($api_url);
            $data = json_decode($data, true);
            $comments = $data['data'];

            foreach ($comments as $comment) {
                ShopReview::updateOrCreate([
                    'tiki_book_id' => $product_id,
                    'username' => $comment['created_by']['name'],
                    'title' => $comment['title'],
                    'content' => $comment['content'],
                    'rating' => $comment['rating'],
                    'reviewed_at' => date("Y-m-d H:i:s", $comment['created_at']),
                    'type' => 'tiki',
                ]);
            }
        }
    }

    function scrapeShopeeReview()
    {
        $books = Shopeebook::all();
        foreach ($books as $book) {
            $tikiId = $book->tiki_book_id;

            $api_url = 'https://shopee.vn/api/v2/item/get_ratings?filter=0&flag=1&itemid=' . $book->book_id . '&limit=10&offset=0&shopid=' . $book->shop_id . '&type=0';
            $data = file_get_contents($api_url);
            $data = json_decode($data, true);
            $comments = $data['data']['ratings'];

            foreach ($comments as $comment) {
                ShopReview::updateOrCreate([
                    'tiki_book_id' => $tikiId,
                    'username' => $comment['author_username'] ? $comment['author_username'] : 'Người dùng Shopee',
                    'content' => $comment['comment'],
                    'rating' => $comment['rating_star'],
                    'reviewed_at' => date("Y-m-d H:i:s", $comment['ctime']),
                    'type' => 'shopee',
                ]);
            }
        }
    }

    function updateTikiReview()
    {
        $books = Book::all();
        foreach ($books as $book) {
            $product_id = $book->tiki_book_id;

            $api_url = 'https://tiki.vn/api/v2/reviews?product_id=' . $product_id . '&sort=score%7Cdesc,id%7Cdesc,stars%7Call&page=1&limit=10&include=comments';

            $data = file_get_contents($api_url);
            $data = json_decode($data, true);
            $comments = $data['data'];

            foreach ($comments as $comment) {
                ShopReview::updateOrCreate(
                    [
                        'tiki_book_id' => $product_id,
                        'username' => $comment['created_by']['name'],
                        'title' => $comment['title'],
                        'content' => $comment['content'],
                        'rating' => $comment['rating'],
                        'reviewed_at' => date("Y-m-d H:i:s", $comment['created_at']),
                        'type' => 'tiki',
                    ],
                    ['updated_at' => date("Y-m-d H:i:s")]
                );
            }
        }
    }

    function updateShopeeReview()
    {
        $books = Book::all();
        foreach ($books as $book) {
            $tikiId = $book->tiki_book_id;

            $api_url = 'https://shopee.vn/api/v2/item/get_ratings?filter=0&flag=1&itemid=' . $book->shopeeBook->book_id . '&limit=10&offset=0&shopid=' . $book->shopeeBook->shop_id . '&type=0';
            $data = file_get_contents($api_url);
            $data = json_decode($data, true);
            $comments = $data['data']['ratings'];

            foreach ($comments as $comment) {
                ShopReview::updateOrCreate(
                    [
                        'tiki_book_id' => $tikiId,
                        'username' => $comment['author_username'] ? $comment['author_username'] : 'Người dùng Shopee',
                        'content' => $comment['comment'],
                        'rating' => $comment['rating_star'],
                        'reviewed_at' => date("Y-m-d H:i:s", $comment['ctime']),
                        'type' => 'shopee',
                    ],
                    ['updated_at' => date("Y-m-d H:i:s")]
                );
            }
        }
    }
}
