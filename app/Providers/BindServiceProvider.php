<?php

namespace App\Providers;

use App\Contrcts\RepoInterface;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(RepoInterface::class, ProductRepository::class);

    }
}
