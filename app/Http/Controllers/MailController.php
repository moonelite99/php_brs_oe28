<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Review\ReviewRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MailController extends Controller
{
    protected $bookRepo;
    protected $reviewRepo;
    protected $userRepo;

    public function __construct(
        BookRepositoryInterface $bookRepositoryInterface,
        ReviewRepositoryInterface $reviewRepositoryInterface,
        UserRepositoryInterface $userRepositoryInterface
    ) {
        $this->bookRepo = $bookRepositoryInterface;
        $this->reviewRepo = $reviewRepositoryInterface;
        $this->userRepo = $userRepositoryInterface;
    }

    public function report()
    {
        $reviews = $this->reviewRepo->getLastWeekReview();
        $books = $this->bookRepo->getLastWeekBook();
        $admins = $this->userRepo->getAdmin();
        $data = [
            'reviews' => $reviews,
            'books' => $books,
        ];
        foreach ($admins as $admin) {
            $email = $admin->email;
            Mail::send('emails.weekly_report', $data, function ($message) use ($email) {
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $message->to($email);
                $message->subject(trans('msg.weekly_report'));
            });
        }
    }
}
