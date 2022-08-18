<?php

namespace ali\Comment\Listeners;

use ali\Comment\Notifications\CommentApprovedNotification;
use ali\Comment\Notifications\CommentSubmittedNotification;
use ali\RolePermissions\Models\Permission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentApprovedListener
{

    public function __construct()
    {

    }

    public function handle($event): void
    {


        /***********is replied and super admin or teacher replied*/
        if (($event->comment->user_id != $event->comment->commentable->teacher->id)) {

            $event->comment->commentable->teacher->notify(new CommentApprovedNotification($event->comment));
        }

    }
}
