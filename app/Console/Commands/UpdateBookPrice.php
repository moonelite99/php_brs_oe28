<?php

namespace App\Console\Commands;

use App\Scraper\BookScraper;
use Illuminate\Console\Command;

class UpdateBookPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateprice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Book Price';

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
        $bot = new BookScraper();
        $bot->updateBookPrice();
    }
}
