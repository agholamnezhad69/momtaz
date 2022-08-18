<?php

namespace ali\Comment\Notifications;

use ali\Comment\Mail\CommentRejectedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class CommentRejectedNotification extends Notification
{
    use Queueable;

    public $comment;

    public function __construct($comment)
    {

        $this->comment = $comment;
    }

    public function via($notifiable): array
    {


        $channels = [];
        $channels[] = "database";

//        if (!is_null($notifiable->telegram) && !empty($notifiable->telegram)) $channels[] = "telegram";
        if (!is_null($notifiable->email) && !empty($notifiable->email)) $channels[] = "mail";
      //  if (!is_null($notifiable->mobile)   && !empty($notifiable->mobile)) $channels[] = KavenegharChannel::class;

        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new CommentRejectedMail($this->comment))->to($notifiable->email);
    }

    public function toTelegram($notifiable)
    {


        return TelegramMessage::create()
            ->to($notifiable->telegram)
            ->content("دیدگاه شما رد شد.")
            ->button('مشاهده دوره', $this->comment->commentable->path());




    }

    public function toKavenegharSms($notifiable)
    {


        $text = "1111";
        $template = "verify";


        return [
            "mobile" => $notifiable->mobile,
            "text" => $text,
            "template" => $template,
        ];


    }

    public function toArray($notifiable): array
    {
        return [
            "message" =>"دیدگاه شما رد شد.",
            "url" => $this->comment->commentable->path(),
        ];
    }
}
