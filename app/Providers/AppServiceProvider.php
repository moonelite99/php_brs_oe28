<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \App\Repositories\Contact\ContactRepositoryInterface;
use \App\Repositories\Contact\ContactRepository;

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
