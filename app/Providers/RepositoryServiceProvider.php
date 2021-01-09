<?php

namespace App\Providers;

use CountDownChat\Domain\Deadline\Repositories\DeadlineRepository;
use CountDownChat\Domain\Liner\Repositories\LinerRepository;
use CountDownChat\Infrastructure\Deadline\Repositories\DeadlineRepositoryImpl;
use CountDownChat\Infrastructure\Liner\Repositories\LinerRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            LinerRepository::class,
            LinerRepositoryImpl::class
        );
        $this->app->bind(
            DeadlineRepository::class,
            DeadlineRepositoryImpl::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
