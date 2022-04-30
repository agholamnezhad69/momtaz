<?php

namespace ali\Payment\Contracts;

use ali\Payment\Models\Payment;

interface GatewayContract
{
    public function request(Payment $payment);

    public function verify(Payment $payment);

}
