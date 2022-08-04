<?php

namespace ali\Comment\Http\Requests;

use ali\Comment\Rules\ApprovedComment;
use ali\Comment\Rules\CommentableRule;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
        return [
            "body" => "required",
            "comment_id" => ["nullable", new ApprovedComment()],
            "commentable_type" => ["required", new CommentableRule()],
            "commentable_id" => "required",
        ];
    }
}
