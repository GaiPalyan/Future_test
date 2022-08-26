<?php

namespace App\Providers;

use App\Domain\Person\PersonRepositoryInterface;
use App\Repositories\Person\PersonRepository;
use Illuminate\Support\ServiceProvider;

class PersonRepositoryProvider extends ServiceProvider
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
        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
    }
}
