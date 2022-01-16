<?php

namespace ali\Course\Http\Requests;

use ali\Course\Models\Course;
use ali\Course\Rules\ValidTeacher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeasonRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() == true;

    }

    public function rules()
    {

        return [
            "title" => "required|min:3|max:190",
            "number" => "nullable|numeric|min:0|max:250",
        ];


    }

    public function attributes()
    {
        return [
            "title" => "عنوان",
            "number" => "شماره",

        ];
    }




}
