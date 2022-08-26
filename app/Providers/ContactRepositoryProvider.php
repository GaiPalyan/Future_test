<?php

namespace App\Providers;

use App\Domain\Person\ContactRepositoryInterface;
use App\Repositories\Contact\ContactRepository;
use Illuminate\Support\ServiceProvider;

class ContactRepositoryProvider extends ServiceProvider
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
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
    }
}
