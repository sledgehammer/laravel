<?php

namespace Sledgehammer\Laravel;

use Config;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\ServiceProvider;
use Sledgehammer\Core\Database\Connection;
use Sledgehammer\Core\Debug\Logger;

class SledgehammerServiceProvider extends ServiceProvider {

    /**
     * @inherit
     */
    public function register() {

        // Enable "@include("sledgehammer:statusbar") in blade
        $this->loadViewsFrom(dirname(__DIR__).'/views', 'sledgehammer');

        // Register the public assets for `php artisan vendor:publish`
        $this->publishes([
            dirname(__DIR__).'/public' => public_path('sledgehammer'),
            dirname(dirname(__DIR__)).'/core/public' => public_path('sledgehammer/core'),
        ], 'public');
    }

}
