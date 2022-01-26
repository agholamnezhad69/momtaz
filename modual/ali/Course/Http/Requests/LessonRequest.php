<?php

namespace ali\Course\Http\Requests;

use ali\Course\Models\Course;
use ali\Course\Rules\ValidSeason;
use ali\Course\Rules\ValidTeacher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() == true;

    }

    public function rules()
    {

        return [
            "title" => "required|min:3|max:190",
            "slug" => "nullable|min:0|max:190",
            "number" => "nullable|numeric",
            "time" => "required|numeric|min:0|max:255",
            "season_id" => [new ValidSeason()],
            "free" => "required|boolean",
            "lesson_file" => "required|file|mimes:avi,mkv,mp4,zip,rar",
        ];


    }

    public function attributes()
    {
        return [
            "title" => 'عنوان درس',
            "slug" => 'عنوان انگلیسی درس',
            "number" => 'شماره درس',
            "time" => 'مدت زمان درس',
            "season_id" => "سرفصل",
            "free" => "رایگان",
            "lesson_file" => "فایل درس",
            "body" => "توضیحات درس"
        ];
    }


}
