<?php

namespace ali\Ticket\Providers;

use Illuminate\Support\ServiceProvider;

class  TicketServiceProviders extends ServiceProvider
{

    public function register()
    {

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

    }

    public function boot()
    {

    }


}
