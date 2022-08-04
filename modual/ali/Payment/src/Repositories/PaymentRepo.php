<?php

namespace ali\Payment\Repositories;

use ali\Payment\Models\Payment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class PaymentRepo
{
    private $query;

    public function __construct()
    {
        $this->query = Payment::query();
    }

    public function paginate()
    {
        return $this->query->latest()->paginate();

    }

    public function searchMobile($mobile)
    {


        if (!is_null($mobile)) {

            $this->query
                ->join("users", "payments.buyer_id", 'users.id')
                ->select("payments.*", "users.mobile")
                ->where("mobile", "like", "%" . $mobile . "%");
        }


        return $this;


    }

    public function searchAmount($amount)
    {
        if (!is_null($amount)) {

            $this->query->where('amount', $amount);

        }

        return $this;

    }

    public function searchInvoiceId($invoice_id)
    {
        if (!is_null($invoice_id)) {

            $this->query->whereDate('invoice_id', "like", "%" . $invoice_id . "%");

        }

        return $this;

    }

    public function searchAfterDate($date)
    {
        if (!is_null($date)) {

            $this->query->whereDate('created_at', ">=", $date);

        }

        return $this;

    }

    public function searchBeforDate($date)
    {
        if (!is_null($date)) {

            $this->query->whereDate('created_at', "<=", $date);

        }

        return $this;

    }

    public function store($data, $discounts = [])
    {

        $payment = Payment::create([
            "buyer_id" => $data["buyer_id"],
            "paymentable_id" => $data["paymentable_id"],
            "paymentable_type" => $data["paymentable_type"],
            "seller_id" => $data["seller_id"],
            "amount" => $data["amount"],
            "invoice_id" => $data["invoice_id"],
            "gateway" => $data["gateway"],
            "status" => $data["status"],
            "seller_percent" => $data["seller_percent"],
            "seller_share" => $data["seller_share"],
            "site_share" => $data["site_share"],
        ]);

        foreach ($discounts as $discount) $discountIds[] = $discount->id;

        if (isset($discountIds))
            $payment->discounts()->sync($discountIds);

        return $payment;

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

    public function getDailySummery(Collection $dates, $seller_id = null)
    {


        $query = Payment::query()
            ->where("created_at", ">=", $dates->keys()->first())
            ->groupBy("date")
            ->orderBy('date');

        if (!is_null($seller_id))
            $query->where('seller_id', $seller_id);


        return $query->get(
            [
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as totalAmount'),
                DB::raw('SUM(seller_share) as totalSellerShare'),
                DB::raw('SUM(site_share) as totalSiteShare'),

            ]
        );


    }

    public function getUserSuccessPayments($user_id)
    {

        return Payment::query()
            ->where('seller_id', $user_id)
            ->where('status', Payment::STATUS_SUCCESS);
    }


    public function getUserTotalSuccessAmount($user_id)
    {
        return $this->getUserSuccessPayments($user_id)->sum("amount");
    }

    public function getUserTotalSellByDay($userId, $day)
    {

        return $this->getUserSuccessPayments($userId)
            ->whereDate("created_at", $day)
            ->sum("seller_share");


    }

    public function getUserSellCountByDay($user_id, $day)
    {

        return $this->getUserSuccessPayments($user_id)
            ->whereDate("created_at", $day)
            ->count("seller_share");
    }

    public function getUserTotalBenefit($user_id)
    {
        return $this->getUserSuccessPayments($user_id)->sum("seller_share");

    }

    public function getUserTotalSiteShare($user_id)
    {
        return $this->getUserSuccessPayments($user_id)->sum("site_share");

    }

    public function getUserTotalBenefitByPeriod($user_id, $start_date, $end_date)
    {
        return Payment::query()
            ->where("seller_id", $user_id)
            ->where('status', Payment::STATUS_SUCCESS)
            ->whereDate("created_at", "<=", $start_date)
            ->whereDate("created_at", ">=", $end_date)
            ->sum("seller_share");

    }


    public function dayTotalAmount($user_id, $date)
    {

        return Payment::query()
            ->where('seller_id', $user_id)
            ->whereDate('created_at', $date)
            ->sum("seller_share");

    }

    public function paymentsBySellerId($seller_id)
    {
        return Payment::query()
            ->where('seller_id', $seller_id)
            ->paginate();

    }


}
