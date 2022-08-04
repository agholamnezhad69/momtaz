<?php

namespace ali\User\Notifications;


use ali\User\Notifications\Channels\KavenegharChannel;
use ali\User\Services\verifyCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;


class ResetPasswordRequestNotification extends Notification
{
    use Queueable;


    public function __construct()
    {
        //
    }

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



    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
