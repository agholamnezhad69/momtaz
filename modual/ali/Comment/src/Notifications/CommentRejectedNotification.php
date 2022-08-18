<?php

namespace ali\Comment\Notifications;

use ali\Comment\Mail\CommentApprovedMail;
use ali\Comment\Mail\CommentRejectedMail;
use ali\Comment\Mail\CommentSubmittedMail;
use ali\Comment\Notifications\Channels\KavenegharChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;
use function PHPUnit\Framework\isEmpty;

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

//        if (!is_null($this->comment->user->telegram) && !empty($this->comment->user->telegram)) $channels[] = "telegram";
        if (!is_null($this->comment->user->email) && !empty($this->comment->user->email)) $channels[] = "mail";
        if (!is_null($this->comment->user->mobile)   && !empty($this->comment->user->mobile)) $channels[] = KavenegharChannel::class;

        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new CommentRejectedMail($this->comment))->to($this->comment->user->email);
    }

    public function toTelegram($notifiable)
    {


        return TelegramMessage::create()
            ->to($this->comment->user->telegram)
            ->content("دیدگاه شما رد شد.")
            ->button('مشاهده دوره', $this->comment->commentable->path());




    }

    public function toKavenegharSms($notifiable)
    {


        $text = "1111";
        $template = "verify";


        return [
            "mobile" => $this->comment->user->mobile,
            "text" => $text,
            "template" => $template,
        ];


    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
