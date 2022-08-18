<?php

namespace ali\Comment\Notifications;

use ali\Comment\Mail\CommentSubmittedMail;
use ali\Comment\Notifications\Channels\KavenegharChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;
use function PHPUnit\Framework\isEmpty;

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


        $channels = [];
        $channels[] = "database";

//        if (!is_null($this->comment->user->telegram) && !empty($this->comment->user->telegram)) $channels[] = "telegram";
        if (!is_null($notifiable->email)    && !empty($notifiable->email)) $channels[] = "mail";
//        if (!is_null($notifiable->mobile)   && !empty($notifiable->mobile)) $channels[] = KavenegharChannel::class;

        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new CommentSubmittedMail($this->comment))->to($notifiable->email);
    }

    public function toTelegram($notifiable)
    {


        $telegram = TelegramMessage::create()
            ->to($notifiable->telegram)
            ->content("یک دیدگاه جدید برای شما در سایت ممتاز  ارسال شد ")
            ->button('مشاهده دوره', $this->comment->commentable->path());

        if ($notifiable->can('replies', $this->comment)) {
            $telegram = $telegram->button('مدیریت دیدگاهها', route("comments.index"));
        }


        return $telegram;


    }

    public function toKavenegharSms($notifiable)
    {

        /***************for student*/
        $text = "1111";
        $template = "verify";

        /***************for teacher and admin*/
        if ($notifiable->can('replies', $this->comment)) {
            $text = "2222";
            $template = "verify";
        }

        return [
            "mobile" => $notifiable->mobile,
            "text" => $text,
            "template" => $template,
        ];


    }

    public function toArray($notifiable): array
    {
        return [
            "message" =>"یک دیدگاه جدید برای شما در سایت ممتاز  ارسال شد ",
            "url" => $this->comment->commentable->path(),
        ];
    }
}
