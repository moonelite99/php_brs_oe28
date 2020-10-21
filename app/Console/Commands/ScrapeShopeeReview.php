<?php

namespace App\Console\Commands;

use App\Scraper\ReviewScrapper;
use Illuminate\Console\Command;

class ScrapeShopeeReview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:shopeereview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape review from shopee';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bot = new ReviewScrapper();
        $bot->scrapeShopeeReview();
    }
}
