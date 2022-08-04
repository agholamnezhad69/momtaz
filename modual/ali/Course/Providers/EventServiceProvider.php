<?php

namespace ali\Course\Providers;

use ali\Course\Listeners\RegisterUserInCourse;
use ali\Payment\Events\PaymentWasSuccessfull;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{


    protected $listen = [

        PaymentWasSuccessfull::class => [
            RegisterUserInCourse::class,
        ],
    ];


    public function boot()
    {
        parent::boot();


    }


}
