<?php

namespace ali\Comment\Providers;

use ali\Comment\Events\CommentApprovedEvent;
use ali\Comment\Events\CommentRejectedEvent;
use ali\Comment\Events\CommentSubmittedEvent;
use ali\Comment\Listeners\CommentApprovedListener;
use ali\Comment\Listeners\CommentRejectedListener;
use ali\Comment\Listeners\CommentSubmittedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{


    protected $listen = [

        CommentSubmittedEvent::class => [
            CommentSubmittedListener::class
        ],
        CommentApprovedEvent::class => [
            CommentApprovedListener::class
        ],
        CommentRejectedEvent::class => [
            CommentRejectedListener::class
        ]
    ];


    public function boot(): void
    {
        parent::boot();

    }


}
