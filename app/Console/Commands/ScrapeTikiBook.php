<?php

namespace App\Console\Commands;

use App\Scraper\BookScrapper;
use Illuminate\Console\Command;

class ScrapeTikiBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:tikibook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape book from tiki';

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
        $bot->scrapeTikiBook();
    }
}
