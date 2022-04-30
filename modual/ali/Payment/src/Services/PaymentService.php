<?php

namespace ali\Payment\Services;

use ali\Payment\Gateways\Gateway;
use ali\Payment\Models\Payment;
use ali\Payment\Repositories\PaymentRepo;
use ali\User\Models\User;

class PaymentService
{
    public static function generate($amount, $paymentable, User $buyer)
    {
        if ($amount <= 0 || is_null($paymentable->id) || is_null($buyer->id)) return false;


        $gateway = resolve(Gateway::class);


        $invoice_id = $gateway->request($amount, $paymentable->title);


        if (is_array($invoice_id)) {
            dd($invoice_id);
        }

        if (!is_null($paymentable->percent)) {
            $seller_percent = $paymentable->percent;
            $seller_share = ($amount / 100) * $seller_percent;
            $site_share = $amount - $seller_share;
        } else {
            $seller_percent = $seller_share = 0;
            $site_share = $amount;
        }


        return resolve(PaymentRepo::class)->store([
            "buyer_id" => $buyer->id,
            "paymentable_id" => $paymentable->id,
            "paymentable_type" => get_class($paymentable),
            "amount" => $amount,
            "invoice_id" => $invoice_id,
            "gateway" => $gateway->getName(),
            "status" => Payment::STATUS_PENDING,
            "seller_percent" => $seller_percent,
            "seller_share" => $seller_share,
            "site_share" => $site_share,
        ]);

    }

}
