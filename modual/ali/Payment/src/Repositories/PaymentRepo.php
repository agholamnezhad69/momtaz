<?php

namespace ali\Payment\Repositories;

use ali\Payment\Models\Payment;


class PaymentRepo
{

    public function store($data)
    {

        return Payment::create([
            "buyer_id" =>  $data["buyer->id"],
            "paymentable_id" => $data["paymentable->id"],
            "paymentable_type" => $data["paymentable"],
            "amount" => $data["amount"],
            "invoice_id" => $data["invoice_id"],
            "gateway" => $data["gateway"],
            "status" => $data[""],
            "seller_percent" => $data["seller_percent"],
            "seller_share" => $data["seller_share"],
            "site_share" => $data["site_share"],
        ]);

    }


}
