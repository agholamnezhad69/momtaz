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

    public function index(PaymentRepo $paymentRepo)
    {

        $this->authorize('manage', Payment::class);

        $payments = $paymentRepo->paginate();
        $last30DayTotals = $paymentRepo->getLastNDaysTotal(-30);
        $last30DayBenefit = $paymentRepo->getLastNDaysSiteBenefit(-30);
        $totalSell = $paymentRepo->getLastNDaysTotal();
        $totalBenefit = $paymentRepo->getLastNDaysSiteBenefit();

        return view("Payment::index",
            compact('payments',
                'last30DayTotals',
                'last30DayBenefit',
                'totalSell',
                'totalBenefit'
            ));


    }

    public function callback(Request $request)
    {

        $gateway = resolve(Gateway::class);
        $paymentRepo = new PaymentRepo();

        $payment = $paymentRepo->findByInvoiceId($gateway->getInvoiceIdFromRequest($request));

        if (!$payment) {

            newFeedbacks('تراکنش ناموفق ', 'تراکنش موردنظر یافت نشد !', 'error');

            return redirect('/');

        }


        $result = $gateway->verify($payment);

        if (is_array($result)) {


            newFeedbacks('تراکنش ناموفق ', $result['message'], 'error');

            $paymentRepo->changeStatus($payment->id, Payment::STATUS_FAIL);


        } else {

            event(new PaymentWasSuccessfull($payment));

            newFeedbacks("عملیات موفق", 'پرداخت با موفقیت انجام شد', "success");

            $paymentRepo->changeStatus($payment->id, Payment::STATUS_SUCCESS);

        }

        return redirect()->to($payment->paymentable->path());


    }


}
