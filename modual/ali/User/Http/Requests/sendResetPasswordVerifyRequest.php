<?php

namespace ali\User\Http\Requests;;

use Illuminate\Foundation\Http\FormRequest;

class sendResetPasswordVerifyRequest extends FormRequest
{
    /**
     * Determine if the User is authorized to make this request.
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
        return [
            'email'=>'required|email'
        ];
    }
}
