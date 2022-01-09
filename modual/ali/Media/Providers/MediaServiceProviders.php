<?php

namespace ali\Media\Providers;

use Illuminate\Support\ServiceProvider;

class MediaServiceProviders extends ServiceProvider
{


    public function register()
    {

    //        $this->loadRoutesFrom(__DIR__ . "/../Routes/courses_routes.php");
    //        $this->loadViewsFrom(__DIR__ . '/../Resources/views/', 'Courses');
              $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
    //        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang/");
    //        $this->loadTranslationsFrom(__DIR__ . "/../Resources/Lang/","Courses");


    }

    public function boot()
    {

    }

}
