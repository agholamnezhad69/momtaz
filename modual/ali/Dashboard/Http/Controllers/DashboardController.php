<?php

namespace ali\Dashboard\Http\Controllers;

use ali\Payment\Repositories\PaymentRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home(PaymentRepo $paymentRepo)
    {
        $totalSales = $paymentRepo->getUserTotalSuccessAmount(auth()->id());
        $totalBenefit = $paymentRepo->getUserTotalBenefit(auth()->id());
        $totalSiteShare = $paymentRepo->getUserTotalSiteShare(auth()->id());

        $todaySuccessPaymentsTotal = $paymentRepo->getUserTotalSellByDay(auth()->id(), now());
        $todaySuccessPaymentsCount = $paymentRepo->getUserSellCountByDay(auth()->id(), now());

        $last30DaysBenefit = $paymentRepo->getUserTotalBenefitByPeriod(auth()->id(), now(), -30);

        return view("Dashboard::index", compact(
            "totalSales",
            "totalBenefit",
            "totalSiteShare",
            "todaySuccessPaymentsTotal",
            "todaySuccessPaymentsCount",
            "last30DaysBenefit",
        ));

    }
}
