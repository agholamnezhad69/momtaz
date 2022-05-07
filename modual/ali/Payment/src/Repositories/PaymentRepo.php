<?php

namespace ali\Payment\Repositories;

use ali\Payment\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;


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

    public function getLastNDaysTotal($days = null)
    {
        return $this->getLastNDaysSuccessPayment($days)
            ->sum("amount");

    }

    public function getLastNDaysSiteBenefit($days = null)
    {
        return $this->getLastNDaysSuccessPayment($days)
            ->sum("site_share");

    }

    public function getLastNDaysSellerBenefit($days = null)
    {
        return $this->getLastNDaysSuccessPayment($days)
            ->sum("seller_share");

    }

    public function getLastNDaysSuccessPayment($days = null)
    {
        return $this->getLastNDaysPayment(Payment::STATUS_SUCCESS, $days);
    }


    public function getLastNDaysPayment($status, $days = null)
    {


        $query = Payment::query();
        if (!is_null($days)) $query = $query->where('created_at', '>=', now()->addDay($days));


        return $query->where("status", $status)
            ->latest();

    }

    public function getDaySiteShareTotal($day)
    {
        return $this->getDaySuccessPayments($day)->sum("site_share");

    }

    public function getDaySellerShareTotal($day)
    {
        return $this->getDaySuccessPayments($day)->sum("seller_share");

    }

    public function getDayFailPaymentsTotal($day)
    {
        return $this->getDayFailPayments($day)->sum("amount");
    }

    public function getDaySuccessPaymentsTotal($day)
    {
        return $this->getDaySuccessPayments($day)->sum("amount");
    }

    public function getDaySuccessPayments($day)
    {
        return $this->getDayPayments($day, Payment::STATUS_SUCCESS);

    }

    public function getDayFailPayments($day)
    {
        return $this->getDayPayments($day, Payment::STATUS_FAIL);

    }

    public function getDayPayments($day, $status)
    {
        return Payment::query()
            ->whereDate('created_at', $day)
            ->where("status", $status)
            ->latest();

    }

    public function getDailySummery(Collection $dates)
    {


        $last30Days = Payment::query()
            ->where("created_at", ">=", $dates->keys()->first())
            ->groupBy("date")
            ->orderBy('date')
            ->get(
                [
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(amount) as totalAmount'),
                    DB::raw('SUM(seller_share) as totalSellerShare'),
                    DB::raw('SUM(site_share) as totalSiteShare'),

                ]
            );


        return ($last30Days);

    }


}
