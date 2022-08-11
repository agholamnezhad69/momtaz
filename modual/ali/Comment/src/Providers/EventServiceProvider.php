<?php

namespace ali\Comment\Providers;

use ali\Comment\Events\CommentSubmittedEvent;
use ali\Comment\Listeners\CommentSubmittedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{


    protected $listen = [

        CommentSubmittedEvent::class => [
            CommentSubmittedListener::class
        ]
    ];


    public function boot(): void
    {
        parent::boot();

    }


}
