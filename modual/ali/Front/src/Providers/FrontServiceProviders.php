<?php

namespace ali\Front\Providers;


use Carbon\Laravel\ServiceProvider;

class FrontServiceProviders extends ServiceProvider
{

    public function register()
    {

        $this->loadRoutesFrom(__DIR__ . '/../Routes/front_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views/', 'Front');


    }

    public function boot()
    {

    }

}
