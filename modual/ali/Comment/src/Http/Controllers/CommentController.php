<?php

namespace ali\Comment\Http\Controllers;

use ali\Comment\Repositories\CommentRepo;
use App\Http\Controllers\Controller;
use ali\Comment\Http\Requests\CommentRequest;

class CommentController extends Controller
{


    public function store(CommentRequest $commentRequest, CommentRepo $commentRepo)
    {


        $commentable = $commentRequest->commentable_type::findOrFail($commentRequest->commentable_id);

        $commentRepo->store($commentRequest->all());

        newFeedbacks("عملیات موفق آمیز", "دیدگاه شما با موفقیت ثبت گردید");


        return redirect($commentable->path());

    }


}
