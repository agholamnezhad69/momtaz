<?php

namespace ali\Ticket\Providers;

use ali\Ticket\Models\Reply;
use ali\Ticket\Models\Ticket;
use ali\Ticket\Policies\ReplyPolicy;
use ali\Ticket\Policies\TicketPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class  TicketServiceProviders extends ServiceProvider
{
    public $namespace = "ali\Ticket\Http\Controllers";

    public function register()
    {

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/web.php');
       Gate::policy(Ticket::class, TicketPolicy::class);
       Gate::policy(Reply::class, ReplyPolicy::class);

    }

    public function boot()
    {

    }


}
