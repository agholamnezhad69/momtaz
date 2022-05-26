<?php

namespace ali\Discount\Listeners;


class UpdateUsedDiscountsForPayment
{

    public function __construct()
    {

    }

    public function handle($event)
    {
        foreach ($event->payment->discounts as $discount) {
            $discount->uses++;
            if (!is_null($discount->usage_limitation)) {
                $discount->usage_limitation--;
            }
            $discount->save();
        }

    }
}
