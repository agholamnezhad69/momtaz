<?php

namespace ali\User\Notifications;


use ali\User\Mail\verifyCodeMail;
use ali\User\Notifications\Channels\KavenegharChannel;
use ali\User\Services\verifyCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class verifyEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        return [KavenegharChannel::class];
    }


    public function toKavenegharSms($notifiable)
    {

        $code = verifyCodeService::generate();
        verifyCodeService::store($notifiable->id, $code, 60);

        return [
            "text" => $code,
            "template" => 'verify',
        ];


    }




    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
