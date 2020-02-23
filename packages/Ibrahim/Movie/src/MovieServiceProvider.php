<?php

namespace Ibrahim\Movie;

use Ibrahim\Movie\Console\Commands\SyncCategoriesCommand;
use Ibrahim\Movie\Console\Commands\SyncMoviesCommand;
use Ibrahim\Movie\Console\Kernel;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['router']->namespace('Ibrahim\\Movie\\Controllers')
            ->middleware(['api'])
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
            });

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/movie.php', 'movie');

        // Register the service the package provides.
        $this->app->singleton('movie', function ($app) {
            return new Movie;
        });

        $this->app->singleton('movie.console.kernel', function ($app) {
            $dispatcher = $app->make(\Illuminate\Contracts\Events\Dispatcher::class);
            return new Kernel($app, $dispatcher);
        });
        $this->app->make('movie.console.kernel');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['movie'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/movie.php' => config_path('movie.php'),
        ], 'movie.config');


        $this->commands([
            SyncCategoriesCommand::class,
            SyncMoviesCommand::class
        ]);
    }
}
