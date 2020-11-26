<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Review\ReviewRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Console\Command;

class ReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly report';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $bookRepo;
    protected $reviewRepo;
    protected $userRepo;

    public function __construct(
        BookRepositoryInterface $bookRepositoryInterface,
        ReviewRepositoryInterface $reviewRepositoryInterface,
        UserRepositoryInterface $userRepositoryInterface
    ) {
        parent::__construct();
        $this->bookRepo = $bookRepositoryInterface;
        $this->reviewRepo = $reviewRepositoryInterface;
        $this->userRepo = $userRepositoryInterface;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mailController = new MailController($this->bookRepo, $this->reviewRepo, $this->userRepo);
        $mailController->report();
    }
}
