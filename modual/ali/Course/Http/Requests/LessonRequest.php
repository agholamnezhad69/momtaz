<?php

namespace ali\Course\Http\Requests;

use ali\Course\Rules\ValidSeason;
use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{

    public function authorize()
    {


        return auth()->check() == true;

    }

    public function rules()
    {
        $rules = [
            "title" => "required|min:3|max:190",
            "slug" => "nullable|min:0|max:190",
            "number" => "nullable|numeric",
            "time" => "required|numeric|min:0|max:255",
            "season_id" => [new ValidSeason()],
            "is_free" => "required|boolean",
            "filePath" => "required",
        ];
//        if (request()->method == "PATCH") {
//            $rules['lesson_file'] = "nullable|file|mimes:".MediaFileService::getExtensions();
//        }
        return $rules;

    }

    public function attributes()
    {
        return [
            "title" => 'عنوان درس',
            "slug" => 'عنوان انگلیسی درس',
            "number" => 'شماره درس',
            "time" => 'مدت زمان درس',
            "season_id" => "سرفصل",
            "is_free" => "رایگان",
            "filePath" => "فایل درس",
            "body" => "توضیحات درس"
        ];
    }


}
