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
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ibrahim');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'ibrahim');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->app['router']->namespace('Ibrahim\\Movie\\Controllers')
            ->middleware(['api'])
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
            });

        // Publishing is only necessary when using the CLI.
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
        $this->mergeConfigFrom(__DIR__.'/../config/movie.php', 'movie');

        // Register the service the package provides.
        $this->app->singleton('movie', function ($app) {
            return new Movie;
        });

        $this->app->singleton('movie.console.kernel', function($app) {
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
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/movie.php' => config_path('movie.php'),
        ], 'movie.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/ibrahim'),
        ], 'movie.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/ibrahim'),
        ], 'movie.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ibrahim'),
        ], 'movie.views');*/

        // Registering package commands.
         $this->commands([
             SyncCategoriesCommand::class,
             SyncMoviesCommand::class
         ]);
    }
}
