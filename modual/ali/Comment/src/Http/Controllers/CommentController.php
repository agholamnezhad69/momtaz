<?php

namespace ali\Comment\Http\Controllers;

use ali\Comment\Http\Requests\CommentRequest;
use ali\Comment\Models\Comment;
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

    public function show($comment_id, CommentRepo $commentRepo)
    {
        $comment = $commentRepo->findWithRelations($comment_id);


        return view("Comment::show", compact("comment"));

    }


    public function store(CommentRequest $commentRequest, CommentRepo $commentRepo)
    {


        $commentable = $commentRequest->commentable_type::findOrFail($commentRequest->commentable_id);

        $commentRepo->store($commentRequest->all());

        newFeedbacks("عملیات موفق آمیز", "دیدگاه شما با موفقیت ثبت گردید");


        return back();

    }

    public function destroy($comment_id, CommentRepo $commentRepo)
    {

        $comment = $commentRepo->findOrFail($comment_id);
        $comment->delete();

        return AjaxResponses::successResponse();


    }

    public function accept($comment_id, CommentRepo $commentRepo)
    {


        if ($commentRepo->updateStatus($comment_id, Comment::STATUS_APPROVED)) {

            return AjaxResponses::successResponse();

        }

        return AjaxResponses::failResponse();
    }

    public function reject($comment_id, CommentRepo $commentRepo)
    {


        if ($commentRepo->updateStatus($comment_id, Comment::STATUS_REJECT)) {

            return AjaxResponses::successResponse();

        }

        return AjaxResponses::failResponse();
    }


}
