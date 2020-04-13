<?php

namespace DanialPanah\PerfectMoneyGateway;

use Carbon\Laravel\ServiceProvider;

class PMGatewayServiceProvider extends ServiceProvider
{
    public function register()
    {
        app()->bind('pmgateway', PMGateway::class);

        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'pmgateway');
    }

    public function boot()
    {
        if (app()->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('pmgateway.php'),
            ], 'config');
        }
    }
}