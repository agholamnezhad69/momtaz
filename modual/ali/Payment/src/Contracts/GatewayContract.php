<?php

namespace ali\Payment\Contracts;

use ali\Payment\Models\Payment;

interface GatewayContract
{
    public function request($amount, $description);

    public function verify(Payment $payment);

    public function redirect();

}
