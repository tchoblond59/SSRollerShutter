<?php

namespace Tchoblond59\SSRollerShutter;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class SSRollerShutterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'ssrollershutter');
        $this->publishes([
            __DIR__.'/assets/js' => public_path('/js/tchoblond59/ssrollershutter'),
            __DIR__.'/assets/css' => public_path('/css/tchoblond59/ssrollershutter'),
        ], 'larahome-package');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        Event::listen('App\Events\MSMessageEvent', '\Tchoblond59\SSRollerShutter\Listeners\SSRollerShutterListener');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->make('tchoblond59\ssrollershutter');
    }
}
