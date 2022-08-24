<?php

namespace App\Providers;

use App\Domain\User\UserRepositoryInterface;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
