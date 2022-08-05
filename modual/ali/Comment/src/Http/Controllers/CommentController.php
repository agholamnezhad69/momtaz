<?php

namespace ali\Comment\Http\Controllers;

use ali\Comment\Http\Requests\CommentRequest;
use ali\Comment\Repositories\CommentRepo;
use ali\Common\Responses\AjaxResponses;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    public function index(CommentRepo $commentRepo)
    {

        $comments = $commentRepo->paginateParents();




        return view("Comment::index", compact("comments"));

    }


    public function store(CommentRequest $commentRequest, CommentRepo $commentRepo)
    {


        $commentable = $commentRequest->commentable_type::findOrFail($commentRequest->commentable_id);

        $commentRepo->store($commentRequest->all());

        newFeedbacks("عملیات موفق آمیز", "دیدگاه شما با موفقیت ثبت گردید");


        return redirect($commentable->path());

    }

    public function destroy($comment_id, CommentRepo $commentRepo)
    {
        $comment = $commentRepo->findOrFail($comment_id);
        $comment->delete();

        return AjaxResponses::successResponse();


    }


}
