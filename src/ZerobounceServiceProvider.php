<?php

namespace NomorePackage\ZeroBounce;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class ZerobounceServiceProvider extends ServiceProvider {




    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/zerobounce.php' => config_path('zerobounce.php'),
        ]);

//         use the vendor configuration file as fallback
//         $this->mergeConfigFrom(
//             __DIR__.'/config/config.php', 'skeleton'
//         );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {}

    public function provides() { return ['zerobounce']; }
}
