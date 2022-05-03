<?php


namespace ali\Payment\Http\Controllers;

use ali\Payment\Gateways\Gateway;
use ali\Payment\Models\Payment;
use ali\Payment\Repositories\PaymentRepo;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class PaymentController extends Controller
{

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

            newFeedbacks("عملیات موفق", 'پرداخت با موفقیت انجام شد', "success");

            $paymentRepo->changeStatus($payment->id, Payment::STATUS_SUCCESS);

        }

        return redirect()->to($payment->paymentable->path());


    }


}
