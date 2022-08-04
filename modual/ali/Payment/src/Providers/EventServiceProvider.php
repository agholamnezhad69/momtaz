<?php

namespace ali\Payment\Providers;

use ali\Payment\Events\PaymentWasSuccessfull;
use ali\Payment\Listeners\AddSellersShareToHisAccount;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{


    protected $listen = [

        PaymentWasSuccessfull::class => [
            AddSellersShareToHisAccount::class,
        ],
    ];


    public function boot()
    {
        parent::boot();


    }


}
