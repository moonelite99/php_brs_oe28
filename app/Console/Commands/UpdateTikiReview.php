<?php

namespace App\Console\Commands;

use App\Scraper\ReviewScraper;
use Illuminate\Console\Command;

class UpdateTikiReview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:tikireview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update review from tiki';

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
        $bot = new ReviewScraper();
        $bot->updateTikiReview();
    }
}
