<?php

namespace ali\Payment\Http\Requests;

use ali\Payment\Models\Settlement;
use Illuminate\Foundation\Http\FormRequest;

class SettlementRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {

        $min = 10000;

        if (request()->getMethod() == "PATCH") {

            return [
                "from.name" => "required_if:status," . Settlement::STATUS_SETTLED,
                "from.cart" => "required_if:status," . Settlement::STATUS_SETTLED,
                "to.name" => "required_if:status," . Settlement::STATUS_SETTLED,
                "to.cart" => "required_if:status," . Settlement::STATUS_SETTLED,
                "amount" => "nullable|numeric|min:{$min}",

            ];

        }

        return [
            "name" => "required",
            "cart" => "required|numeric",
            "amount" => "nullable|numeric|min:{$min}|max:" . auth()->user()->balance,
        ];


    }

    public function attributes()
    {
        return [
            "name" => "نام صاحب حساب",
            "cart" => "شماره کارت",
            "amount" => "مبلغ تسویه حساب ",

        ];
    }
}
