<?php

namespace App\Scraper;

use App\Models\Shopeebook;
use App\Models\Tikibook;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

class BookScrapper
{
    public function scrapeTikiBook()
    {
        $base = 'https://tiki.vn/sach-truyen-tieng-viet/c316?page=';

        for ($i = 1; $i <= 21; $i++) {
            $url = $base . $i;

            $data = file_get_contents($url);
            $crawler = new Crawler($data);

            $crawler->filter('div.product-box-list div.product-item')->each(
                function (Crawler $node) {
                    $link = $node->filter('a')->attr('href');
                    if (strpos($link, '//') === false) {

                        $title = $node->filter('a')->attr('title');
                        if (strpos($title, "Combo") !== false) {
                        } else {
                            if (strpos($title, "(") !== false) {
                                $title = substr($title, 0, strpos($title, "("));
                            }
                            if (strpos($title, "Tặng") !== false) {
                                $title = substr($title, 0, strpos($title, "Tặng"));
                            }
                            $link = 'https://tiki.vn' . $link;
                            $book_id = $node->filter('a')->attr('data-id');

                            Tikibook::updateOrCreate([
                                'title' => $title,
                                'link' => $link,
                                'book_id' => $book_id,
                            ]);
                        }
                    }
                }
            );
        }
    }

    public function scrapeShopeeBook()
    {
        $books = Tikibook::where('id', '>', '0')->get();
        foreach ($books as $book) {
            $title = $book->title;

            $title = urlencode($title);
            $url = 'https://www.google.com/search?q=' . $title . '+site%3Ashopee.vn';

            $data = file_get_contents($url);
            $crawler = new Crawler($data);

            try {
                $link = $crawler->filter('div.kCrYT a[href*="-i."]')->first()->attr('href');
            } catch (InvalidArgumentException $e) {
                continue;
            }

            $link = substr($link, 7, strpos($link, '&') - 7);
            preg_match('/-i.([0-9]+).([0-9]+)/', $link, $matches);

            $shopId = $matches[1];
            $bookId = $matches[2];

            Shopeebook::updateOrCreate([
                'link' => urldecode(urldecode($link)),
                'book_id' => $bookId,
                'shop_id' => $shopId,
                'tiki_book_id' => $book->book_id,
            ]);
        }
    }
}
