<?php

namespace ali\Comment\Notifications;

use ali\Comment\Mail\CommentSubmittedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentSubmittedNotification extends Notification
{
    use Queueable;

    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {

        return (new CommentSubmittedMail($this->comment))->to($notifiable->email);
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
