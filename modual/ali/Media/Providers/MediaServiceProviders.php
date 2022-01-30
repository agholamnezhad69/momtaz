<?php

namespace ali\Media\Providers;

use Illuminate\Support\ServiceProvider;

class MediaServiceProviders extends ServiceProvider
{


    public function register()
    {


        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../Config/mediaFile.php','mediaFile');


    }

    public function boot()
    {

    }

}
