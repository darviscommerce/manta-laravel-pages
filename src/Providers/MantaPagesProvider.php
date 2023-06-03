<?php

namespace Manta\LaravelPages\Providers;

use Manta\LaravelPages\Console\InstallMantaLaravelPages;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class MantaPagesProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // * Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // * Artisan commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallMantaLaravelPages::class,
            ]);
        }
    }
}
