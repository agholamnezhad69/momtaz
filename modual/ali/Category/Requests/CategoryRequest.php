<?php

namespace ali\Category\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:190',
            'slug' => 'required|max:190',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }
}
