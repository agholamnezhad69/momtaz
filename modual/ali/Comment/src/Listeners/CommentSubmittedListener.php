<?php

namespace ali\Comment\Listeners;

use ali\Comment\Notifications\CommentSubmittedNotification;
use ali\RolePermissions\Models\Permission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentSubmittedListener
{

    public function __construct()
    {

    }

    public function handle($event): void
    {

        /***********is replied and super admin or teacher replied*/
        if (!is_null($event->comment->comment_id) && ($event->comment->user->can('replies', $event->comment))) {
            $event->comment->commentable->teacher->notify(new CommentSubmittedNotification($event->comment->comment));
        }

    }
}
