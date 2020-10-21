<?php

namespace App\Console\Commands;

use App\Scraper\ReviewScrapper;
use Illuminate\Console\Command;

class ScrapeTikiReview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:tikireview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape review from tiki';

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
        $bot->scrapeTikiReview();
    }
}
