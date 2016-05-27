<?php

namespace PurpleObject\Factuursturen;

class FactuurSturenServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(array(
            __DIR__.'/../config/factuursturen.php' => config_path('factuursturen.php')
        ));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $app = $this->app;

        $this->mergeConfigFrom(
            __DIR__.'/../config/factuursturen.php',
            'factuursturen'
        );

        $app['factuursturen'] = $app->share(function ($app) {
            return new FactuurSturen();
        });

        $app->alias('factuursturen', 'PurpleObject\Factuursturen\FactuurSturen');
    }
}