<?php

namespace ali\Discount\Services;

class DiscountService
{

    public static function calculateDiscountAmount($price, $percent)
    {
        if ($percent < 10) {
            return $price * ((float)('0.0' . $percent));
        }
        return $price * ((float)('0.' . $percent));
    }


}
