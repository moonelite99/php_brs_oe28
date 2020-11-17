<?php

namespace App\Providers;

use App\Repositories\Book\BookRepository;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Repositories\Contact\ContactRepository;
use App\Repositories\Like\LikeRepository;
use App\Repositories\Like\LikeRepositoryInterface;
use App\Repositories\Review\ReviewRepository;
use App\Repositories\Review\ReviewRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            ContactRepositoryInterface::class,
            ContactRepository::class,
        );
        $this->app->singleton(
            BookRepositoryInterface::class,
            BookRepository::class,
        );
        $this->app->singleton(
            CommentRepositoryInterface::class,
            CommentRepository::class,
        );
        $this->app->singleton(
            ReviewRepositoryInterface::class,
            ReviewRepository::class,
        );
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class,
        );
        $this->app->singleton(
            LikeRepositoryInterface::class,
            LikeRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
