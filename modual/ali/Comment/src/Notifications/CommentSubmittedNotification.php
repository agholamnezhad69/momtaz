<?php

namespace ali\Comment\Notifications;

use ali\Comment\Mail\CommentSubmittedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

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
        return ['mail', "telegram"];
    }

    public function toMail($notifiable)
    {

        return (new CommentSubmittedMail($this->comment))->to($notifiable->email);
    }

    public function toTelegram($notifiable)
    {


        return TelegramMessage::create()
//            ->to(450543066)
            ->to(5414676121)
            ->content("یک دیدگاه جدید برای شما در سایت ممتاز  ارسال شد ")
            ->button('مشاهده دوره', $this->comment->commentable->path())
            ->button('مدیریت دیدگاهها', route("comments.index"));

    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
