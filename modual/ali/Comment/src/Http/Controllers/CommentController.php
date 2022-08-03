<?php

namespace ali\Comment\Http\Controllers;

use App\Http\Controllers\Controller;
use ali\Comment\Http\Requests\CommentRequest;

class CommentController extends Controller
{


    public function store(CommentRequest $commentRequest)
    {

        $commentable = $commentRequest->commentable_type::findOrFail($commentRequest->commentable_id);

        return $commentable;

    }


}
