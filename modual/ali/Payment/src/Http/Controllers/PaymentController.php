<?php


namespace ali\Payment\Http\Controllers;


use ali\Payment\Events\PaymentWasSuccessfull;
use ali\Payment\Gateways\Gateway;
use ali\Payment\Models\Payment;
use ali\Payment\Repositories\PaymentRepo;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class PaymentController extends Controller
{


    public function index(PaymentRepo $paymentRepo, Request $request)
    {




        $this->authorize('manage', Payment::class);


        $payments = $paymentRepo
            ->searchEmail($request->email)
            ->searchAmount($request->amount)
            ->searchInvoiceId($request->invoice_id)
            ->searchAfterDate(getDateFromJalaliToCarbon(convertPersianNumberToEnglish($request->start_date)))
            ->searchBeforDate(getDateFromJalaliToCarbon(convertPersianNumberToEnglish($request->end_date)))
            ->paginate();


        $last30DayTotals = $paymentRepo->getLastNDaysTotal(-30);
        $last30DayBenefitSiteShare = $paymentRepo->getLastNDaysSiteBenefit(-30);
        $last30DayBenefitSellerShare = $paymentRepo->getLastNDaysSellerBenefit(-30);
        $totalSell = $paymentRepo->getLastNDaysTotal();
        $totalBenefit = $paymentRepo->getLastNDaysSiteBenefit();

        $dates = collect();

        foreach (range(-30, 0) as $i) {

            $d = now()->addDay($i)->format("Y-m-d");
            $dates->put($d, 0);
        }

        $summery = $paymentRepo->getDailySummery($dates);


        return view("Payment::index",
            compact('payments',
                'last30DayTotals',
                'last30DayBenefitSiteShare',
                'last30DayBenefitSellerShare',
                'totalSell',
                'totalBenefit',
                'dates',
                'summery'
            ));


    }

    public function callback(Request $request)
    {

        $gateway = resolve(Gateway::class);
        $paymentRepo = new PaymentRepo();

        $payment = $paymentRepo->findByInvoiceId($gateway->getInvoiceIdFromRequest($request));

        if (!$payment) {

            newFeedbacks('???????????? ???????????? ', '???????????? ?????????????? ???????? ?????? !', 'error');

            return redirect('/');

        }


        $result = $gateway->verify($payment);

        if (is_array($result)) {

            newFeedbacks('???????????? ???????????? ', $result['message'], 'error');

            $paymentRepo->changeStatus($payment->id, Payment::STATUS_FAIL);

        } else {

            event(new PaymentWasSuccessfull($payment));

            newFeedbacks("???????????? ????????", '???????????? ???? ???????????? ?????????? ????', "success");

            $paymentRepo->changeStatus($payment->id, Payment::STATUS_SUCCESS);

        }

        return redirect()->to($payment->paymentable->path());


    }


    public function purchases()
    {


        $purchases = auth()->user()->payments()->with('paymentable')->paginate();

        return view("Payment::purchases", compact("purchases"));


    }


}
