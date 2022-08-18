<?php

namespace ali\Comment\Listeners;

use ali\Comment\Notifications\CommentApprovedNotification;
use ali\Comment\Notifications\CommentRejectedNotification;
use ali\Comment\Notifications\CommentSubmittedNotification;
use ali\RolePermissions\Models\Permission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentRejectedListener
{

    public function __construct()
    {

    }

    public function handle($event): void
    {



     $event->comment->user->notify(new CommentRejectedNotification($event->comment));


    }
}
