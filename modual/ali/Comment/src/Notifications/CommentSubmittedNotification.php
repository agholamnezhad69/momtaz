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

//        if (!is_null($this->comment->user->telegram) && !isEmpty($this->comment->user->telegram)) $channels[] = "telegram";
        if (!is_null($this->comment->user->email)    && !isEmpty($this->comment->user->email)) $channels[] = "mail";
//        if (!is_null($this->comment->user->mobile)   && !isEmpty($this->comment->user->mobile)) $channels[] = KavenegharChannel::class;

        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new CommentSubmittedMail($this->comment))->to($this->comment->user->email);
    }

    public function toTelegram($notifiable)
    {


        $telegram = TelegramMessage::create()
            ->to($this->comment->user->telegram)
            ->content("یک دیدگاه جدید برای شما در سایت ممتاز  ارسال شد ")
            ->button('مشاهده دوره', $this->comment->commentable->path());

        if ($this->comment->user->can('replies', $this->comment)) {
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
        if ($this->comment->user->can('replies', $this->comment)) {
            $text = "2222";
            $template = "verify";
        }

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
