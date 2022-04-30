<?php

namespace ali\Payment\Providers;

use ali\Payment\Gateways\Gateway;
use ali\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{


    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    public function boot()
    {

        $this->app->singleton(Gateway::class, function ($app) {

            return new ZarinpalAdaptor();

        });


    }


}

