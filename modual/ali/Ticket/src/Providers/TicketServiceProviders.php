<?php

namespace ali\Ticket\Providers;

use ali\Ticket\Models\Reply;
use ali\Ticket\Models\Ticket;
use ali\Ticket\Policies\ReplyPolicy;
use ali\Ticket\Policies\TicketPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class  TicketServiceProviders extends ServiceProvider
{
    public $namespace = "ali\Ticket\Http\Controllers";

    public function register()
    {

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', "Tickets");
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/web.php');


        Gate::policy(Ticket::class, TicketPolicy::class);
        Gate::policy(Reply::class, ReplyPolicy::class);

    }

    public function boot()
    {

        config()->set('sidebar.items.tickets', [
            "icon" => "i-tickets",
            "title" => "تیکت ها",
            "url" => route("tickets.index"),
        ]);

    }


}
