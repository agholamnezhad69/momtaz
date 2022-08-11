<?php

namespace ali\Comment\Listeners;

use ali\Comment\Notifications\CommentSubmittedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentSubmittedListener
{

    public function __construct()
    {

    }

    public function handle($event): void
    {
        $event->comment->commentable->teacher->notify(new CommentSubmittedNotification($event->comment));
    }
}
