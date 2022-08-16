<?php

namespace ali\Comment\Repositories;

use ali\Comment\Models\Comment;
use ali\RolePermissions\Models\Permission;

class CommentRepo
{
    public $query;

    public function __construct()
    {
        $this->query = Comment::query();
    }

    public function paginate()
    {

        return Comment::query()->latest()->paginate();

    }


    public function store($data)
    {
        $comment = Comment::query()->create([
            "user_id" => auth()->id(),
            "comment_id" => array_key_exists("comment_id", $data) ? $data["comment_id"] : null,
            "commentable_id" => $data["commentable_id"],
            "commentable_type" => $data["commentable_type"],
            "body" => $data["body"],
        ]);

        if (auth()->user()->can('replies', $comment)) {

            Comment::query()->where("id", $comment->id)->update([
                "status" => Comment::STATUS_APPROVED
            ]);
        }

        return $comment;
    }

    public function findApproved($commentId)
    {

        return Comment::query()
            ->where("id", $commentId)
            ->where("status", Comment::STATUS_APPROVED)
            ->first();

    }

    public function findOrFail($comment_id)
    {

        return Comment::query()->findOrFail($comment_id);

    }

    public function updateStatus($comment_id, string $status)
    {
        return Comment::query()
            ->where('id', $comment_id)
            ->update(["status" => $status]);
    }

    public function findWithRelations($comment_id)
    {

        return Comment::query()
            ->where("id", $comment_id)
            ->with("commentable", "user", "replies")
            ->firstOrFail();

    }


    public function searchStatus($status)
    {

        if (!is_null($status))
            $this->query->where("comments.status", $status);
        return $this;
    }

    public function searchBody($body)
    {

        if (!is_null($body))
            $this->query->where("body", "like", "%" . $body . "%");
        return $this;
    }

    public function searchEamil($email)
    {
        if (!is_null($email))
            $this->query->whereHas("user", function ($q) use ($email) {
                return $q->where("email", "like", "%" . $email . "%");
            });
        return $this;
    }

    public function searchName($name)
    {
        if (!is_null($name))
            $this->query->whereHas("user", function ($q) use ($name) {
                return $q->where("name", "like", "%" . $name . "%");
            });
        return $this;
    }

    public function paginateParents()
    {
        return $this->query
            ->latest()
            ->whereNull("comment_id")
            ->withCount("notApprovedComments")
            ->latest()
            ->paginate();
    }

//    public function paginateTeacher($user_id)
//    {
//        return $this->query
//            ->latest()
//            ->where("user_id", $user_id)
//            ->whereNull("comment_id")
//            ->withCount("notApprovedComments")
//            ->latest()
//            ->paginate();
//    }

}
