<?php

namespace ali\Payment\Repositories;

use ali\Payment\Models\Payment;


class PaymentRepo
{


    public function paginate()
    {
        return Payment::query()->latest()->paginate();

    }

    public function store($data)
    {

        return Payment::create([
            "buyer_id" => $data["buyer_id"],
            "paymentable_id" => $data["paymentable_id"],
            "paymentable_type" => $data["paymentable_type"],
            "amount" => $data["amount"],
            "invoice_id" => $data["invoice_id"],
            "gateway" => $data["gateway"],
            "status" => $data["status"],
            "seller_percent" => $data["seller_percent"],
            "seller_share" => $data["seller_share"],
            "site_share" => $data["site_share"],
        ]);

    }

    public function findByInvoiceId($invoiceId)
    {

        return Payment::where('invoice_id', $invoiceId)->first();

    }

    public function changeStatus($paymentId, $status)
    {

        return Payment::query()->where('id', $paymentId)->update([
            "status" => $status
        ]);

    }


}
