<?php

namespace ali\Discount\Providers;


use ali\Discount\Listeners\UpdateUsedDiscountsForPayment;
use ali\Payment\Events\PaymentWasSuccessfull;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{


    protected $listen = [

        PaymentWasSuccessfull::class => [
            UpdateUsedDiscountsForPayment::class,
        ],
    ];


    public function boot()
    {
        parent::boot();


    }


}
