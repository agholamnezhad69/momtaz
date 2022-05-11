<?php

namespace ali\Payment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettlementRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => 'required',
            'cart' => 'required|numeric',
            'amount' => 'nullable|numeric|max:' . auth()->user()->balance,
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
