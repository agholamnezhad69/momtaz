<?php

namespace ali\Payment\Gateways\Zarinpal;


use ali\Payment\Contracts\GatewayContract;
use ali\Payment\Models\Payment;

class ZarinpalAdaptor implements GatewayContract
{
    public function request(Payment $payment)
    {
        $zp = new Zarinpal();
        $zp->request("**");
    }

    public function verify(Payment $payment)
    {
        // TODO: Implement verify() method.
    }
}
