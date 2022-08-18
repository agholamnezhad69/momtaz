<?php

namespace ali\Comment\Notifications;

use ali\Comment\Mail\CommentApprovedMail;
use ali\Comment\Mail\CommentSubmittedMail;
use ali\Comment\Notifications\Channels\KavenegharChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;
use function PHPUnit\Framework\isEmpty;

class CommentApprovedNotification extends Notification
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


//        if (!is_null($notifiable->telegram) && !empty($notifiable->telegram)) $channels[] = "telegram";
        if (!is_null($notifiable->email) && !empty($notifiable->email)) $channels[] = "mail";
        if (!is_null($notifiable->mobile) && !empty($notifiable->mobile)) $channels[] = KavenegharChannel::class;

        return $channels;
    }

    public function toMail($notifiable)
    {

        return (new CommentApprovedMail($this->comment))->to($notifiable->email);
    }

    public function toTelegram($notifiable)
    {


        return TelegramMessage::create()
            ->to($notifiable->telegram)
            ->content("دیدگاه شما تایید شد.")
            ->button('مشاهده دوره', $this->comment->commentable->path())
            ->button('مدیریت دیدگاهها', route("comments.index"));
    }


    public function toKavenegharSms($notifiable)
    {

        /***************for student*/
        $text = "2222";
        $template = "verify";

        return [
            "mobile" => $notifiable->mobile,
            "text" => $text,
            "template" => $template,
        ];


    }

    public
    function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
