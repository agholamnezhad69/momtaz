<?php

namespace ali\Comment\Rules;

use Illuminate\Contracts\Validation\Rule;

class CommentableRule implements Rule
{

    public function __construct()
    {

    }

    public function passes($attribute, $value)
    {
        return method_exists($value, "comments");
    }

    public function message()
    {
        return 'The validation error message.';
    }
}
