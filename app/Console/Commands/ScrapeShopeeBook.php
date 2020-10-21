<?php

namespace App\Console\Commands;

use App\Scraper\BookScrapper;
use Illuminate\Console\Command;

class ScrapeShopeeBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:shopeebook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl';

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
        $bot = new BookScrapper();
        $bot->scrapeShopeeBook();
    }
}
