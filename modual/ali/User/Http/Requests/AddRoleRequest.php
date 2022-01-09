<?php

namespace ali\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRoleRequest extends FormRequest
{
    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() == true;


    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role' => ['required', 'exists:roles,name']
        ];

    }

}
