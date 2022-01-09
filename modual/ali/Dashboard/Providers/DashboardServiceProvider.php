<?php

namespace ali\Dashboard\Providers;

use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{

    public function register()
    {

        $this->loadRoutesFrom(__DIR__ . '/../Routes/dashboard_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'Dashboard');
        $this->mergeConfigFrom(__DIR__ . '/../Config/sidebar.php', 'sidebar');


    }

    public function boot()
    {


        $this->app->booted(function () {

            config()->set('sidebar.items.Dashboard', [
                "icon" => "i-Dashboard",
                "title" => "داشبورد",
                "url" => route('home')
            ]);

        });




    }
}
