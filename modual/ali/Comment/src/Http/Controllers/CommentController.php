<?php

namespace ali\Comment\Http\Controllers;

use ali\Comment\Http\Requests\CommentRequest;
use ali\Comment\Models\Comment;
use ali\Comment\Repositories\CommentRepo;
use ali\Common\Responses\AjaxResponses;
use ali\Course\Models\Course;
use ali\RolePermissions\Models\Permission;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    public function index(CommentRepo $commentRepo)
    {
        $this->authorize("index", Comment::class);

        $comments = $commentRepo
            ->searchBody(request("body1"))
            ->searchEamil(request("email"))
            ->searchName(request("name"))
            ->searchStatus(request("status"));

        if (!auth()->user()->hasAnyPermission(Permission::PERMISSION_SUPER_ADMIN, Permission::PERMISSION_MANAGE_COMMENTS)) {

            $comments->query
                ->whereHasMorph("commentable", [Course::class], function ($query) {

                    return $query->where("teacher_id", auth()->id());

                })
                ->where("status", Comment::STATUS_APPROVED);

        }


        $comments = $comments->paginateParents();


        return view("Comment::index", compact("comments"));

    }

    public function show($comment_id, CommentRepo $commentRepo)
    {

        $comment = $commentRepo->findWithRelations($comment_id);
        $this->authorize("view", $comment);
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
        $this->authorize("manage", Comment::class);
        $comment = $commentRepo->findOrFail($comment_id);
        $comment->delete();
        return AjaxResponses::successResponse();
    }

    public function accept($comment_id, CommentRepo $commentRepo)
    {
        $this->authorize("manage", Comment::class);
        if ($commentRepo->updateStatus($comment_id, Comment::STATUS_APPROVED)) {
            return AjaxResponses::successResponse();
        }
        return AjaxResponses::failResponse();
    }

    public function reject($comment_id, CommentRepo $commentRepo)
    {
        $this->authorize("manage", Comment::class);
        if ($commentRepo->updateStatus($comment_id, Comment::STATUS_REJECT)) {

            return AjaxResponses::successResponse();

        }

        return AjaxResponses::failResponse();
    }


}
