<?php

namespace ali\Comment\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

class KavenegharChannel
{


    public function send($notifiable, Notification $notification)
    {


        if (!method_exists($notification, 'toKavenegharSms')) {

            throw new \Exception("کاوه نگار پیدا نشد");

        }

        $data = $notification->toKavenegharSms($notifiable);
        $message = $data['text'];
        $template = $data['template'];
        $receptor = $data['mobile'];


        $apiKey = config('services.kavenegar.key');

        try {
            $api = new \Kavenegar\KavenegarApi($apiKey);

            $api->VerifyLookup($receptor, $message, '', '', $template);

        } catch (ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            throw $e->errorMessage();
            //throw $e;

        } catch (HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            throw $e->errorMessage();
            // throw $e;
        }

    }

}
