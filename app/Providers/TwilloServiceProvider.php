<?php

namespace App\Providers;

use App\Services\Twillo\Connection;
use Illuminate\Support\ServiceProvider;

class TwilloServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(Connection::class, function ($app) {
            return new Connection(config('twillo'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
