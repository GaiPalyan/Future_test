<?php

namespace App\Providers;

use App\Domain\Company\CompanyRepositoryInterface;
use App\Repositories\Company\CompanyRepository;
use Illuminate\Support\ServiceProvider;

class CompanyRepositoryProvider extends ServiceProvider
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
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
    }
}
