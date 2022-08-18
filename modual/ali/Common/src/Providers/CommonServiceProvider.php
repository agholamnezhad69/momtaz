<?php

namespace ali\Common\Providers;

use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . "/../Resources", "Common");
        $this->loadRoutesFrom(__DIR__ . '/../Routes/common_routes.php');
    }

    public function boot()
    {

        view()->composer("Dashboard::layout.header", function ($view) {
            $notifications = auth()->user()->unreadNotifications;
            return $view->with(compact("notifications"));
        });

    }


}
