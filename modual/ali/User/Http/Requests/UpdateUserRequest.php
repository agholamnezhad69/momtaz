<?php

namespace ali\User\Http\Requests;


use ali\User\Models\User;
use ali\User\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() == true;

    }

    public function rules()
    {
        return [
            "name" => "required|min:3|max:190",
            "email" => "required|email|min:3|max:190|unique:users,email," . request()->route('user'),
            "username" => "nullable|min:3|max:190|unique:users,username," . request()->route('user'),
            "mobile" => ['required', 'string', 'min:10', 'max:15',
                'unique:users,mobile,' . request()->route('user'), new ValidMobile()],
            "status" => ["required", Rule::in(User::$statuses)],
            "image" => "nullable|mimes:jpg,png,jpeg",
        ];

    }
    public function attributes()
    {
        return [
            "name" => "نام",
            "email" => "ایمیل",
            "username" => "نام کاربری",
            "mobile" => "موبایل",
            "status" => "وضعیت",
            "image" => "عکس پروفایل",
        ];
    }


}
