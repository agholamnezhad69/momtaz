<?php

namespace ali\Ticket\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class TicketRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() == true;

    }

    public function rules()
    {


        return [
            "title" => 'required|min:3|max:190',
            "body" => "required",
            // "attachment" => "nullable|file|mimes:jpg,png,jpeg|max:10240",
//            "attachment" => "nullable|file|mimes:avi,mkv,mp4,zip,rar,jpg,png,jpeg|max:10240",
            "attachment" => "nullable|file|mimes:zip,rar,jpg,png,jpeg|max:10240",
        ];

    }

    public function attributes()
    {
        return [
            "title" => 'عنوان تیکت',
            "attachment" => "فایل پیوست",
            "body" => "متن تیکت"
        ];
    }


}
