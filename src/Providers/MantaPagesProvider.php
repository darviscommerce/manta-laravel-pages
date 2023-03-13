<?php

namespace Manta\LaravelPages\Providers;

use Manta\LaravelPages\Console\InstallMantaLaravelPages;
use Manta\LaravelPages\Http\Livewire\Pages\PagesCreate;
use Manta\LaravelPages\Http\Livewire\Pages\PagesList;
use Manta\LaravelPages\Http\Livewire\Pages\PagesUpdate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Manta\LaravelPages\Http\Livewire\Pages\PagesUploads;
use Illuminate\Support\Facades\Blade;
use Manta\LaravelPages\View\Components\Website\PageText;
use Manta\LaravelPages\View\Components\Website\PageLink;

class MantaPagesProvider extends ServiceProvider
{


    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {

        // * Routes
        $this->registerRoutes();

        // * Laravel components
        Livewire::component('pages-create', PagesCreate::class);
        Livewire::component('pages-update', PagesUpdate::class);
        Livewire::component('pages-list', PagesList::class);
        Livewire::component('pages-uploads', PagesUploads::class);

        Blade::component('page-link', PageLink::class);
        Blade::component('page-text', PageText::class);

        // * Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'manta-laravel-pages');

        // * Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadViewComponentsAs('manta-laravel-pages', [
            // MantaFooter::class,
        ]);

        // * Artisan commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallMantaLaravelPages::class,
            ]);
        }

        // * Publish options
        if ($this->app->runningInConsole()) {
            // Publish view components
            $this->publishes([
                // __DIR__ . '/../public/libs/' => public_path('libs'),
                // __DIR__ . '/../public/images/' => public_path('images'),
                // __DIR__ . '/../View/Components/' => app_path('View/Components'),
                // __DIR__ . '/../Traits/' => app_path('Traits'),
                // __DIR__ . '/../resources/' => resource_path(''),
                // __DIR__ . '/../resources/views/' => resource_path('views'),
                // __DIR__ . '/../resources/views/layouts/' => resource_path('views/layouts'),
                // __DIR__ . '/../resources/views/components/' => resource_path('views/components'),
                // __DIR__ . '/../database/seeders/' => resource_path('/../database/seeders'),
            ], 'view-components');


            $this->publishes([
              __DIR__.'/../config/config.php' => config_path('manta-pages.php'),
            ], 'config');

          }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'manta-pages');
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        // dd(config('manta-pages.prefix'));
        return [
            'prefix' => config('manta-pages.prefix'),
            'middleware' => config('manta-pages.middleware'),
        ];
    }
}
