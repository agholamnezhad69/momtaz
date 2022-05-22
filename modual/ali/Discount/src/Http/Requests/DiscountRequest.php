<?php

namespace ali\Discount\Http\Requests;

use ali\Common\Rules\ValidIsSetVariable;
use ali\Common\Rules\ValidJalaliDate;
use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            "code" => "nullable|max:50|unique:discounts,code",
            "percent" => "required|numeric|min:1|max:100",
            "usage_limitation" => "nullable|numeric|min:0|max:10000000000",
            "expire_at" => ["nullable", new ValidJalaliDate()],
            "courses" => ["required_if:type,special", "array"],
            "type" => "required",
        ];

        if (request()->getMethod() == "PATCH") {
            $rules["code"] = "nullable|max:50|unique:discounts,code," . request()->route('discount')->id;
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            "type" => "نوع تخفیف",
            "courses" => "دوره ها",
            "special" => "دوره خاص"

        ];
    }
}
