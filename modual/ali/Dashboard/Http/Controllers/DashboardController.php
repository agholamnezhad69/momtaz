<?php

namespace ali\Dashboard\Http\Controllers;

use ali\Payment\Repositories\PaymentRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home(PaymentRepo $paymentRepo)
    {


        $payments = $paymentRepo->paymentsBySellerId(auth()->id());
        $totalSell = $paymentRepo->getUserTotalSuccessAmount(auth()->id());
        $last30DayBenefitSellerShare = $paymentRepo->getUserTotalBenefit(auth()->id());
        $last30DayBenefitSiteShare = $paymentRepo->getUserTotalSiteShare(auth()->id());
        $todaySuccessPaymentsTotal = $paymentRepo->getUserTotalSellByDay(auth()->id(), now());
        $todaySuccessPaymentsCount = $paymentRepo->getUserSellCountByDay(auth()->id(), now());

        $last30DaysBenefit = $paymentRepo->getUserTotalBenefitByPeriod(auth()->id(), now(), -30);

        $dates = collect();

        foreach (range(-30, 0) as $i) {

            $d = now()->addDay($i)->format("Y-m-d");
            $dates->put($d, 0);
        }
        $summery = $paymentRepo->getDailySummery($dates, auth()->id());

        return view("Dashboard::index",
            compact(
                "payments",
                "todaySuccessPaymentsTotal",
                "todaySuccessPaymentsCount",
                'last30DaysBenefit',
                'last30DayBenefitSiteShare',
                'last30DayBenefitSellerShare',
                'totalSell',
                'dates',
                'summery'

            ));

    }
}
