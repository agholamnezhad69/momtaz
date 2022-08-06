<?php

namespace ali\Comment\Repositories;

use ali\Comment\Models\Comment;
use ali\RolePermissions\Models\Permission;

class CommentRepo
{

    public function paginate()
    {

        return Comment::query()->latest()->paginate();

    }

    public function paginateParents()
    {

        return Comment::query()
            ->latest()
            ->whereNull("comment_id")
            ->latest()
            ->withCount("notApprovedComments")
            ->paginate();

    }


    public function store($data)
    {
        return Comment::query()->create([
            "user_id" => auth()->id(),
            "comment_id" => array_key_exists("comment_id", $data) ? $data["comment_id"] : null,
            "commentable_id" => $data["commentable_id"],
            "commentable_type" => $data["commentable_type"],
            "body" => $data["body"],
            "status" =>
                auth()->user()->can(Permission::PERMISSION_MANAGE_COMMENTS) ||
                auth()->user()->can(Permission::PERMISSION_TEACH)
                    ?
                    Comment::STATUS_APPROVED
                    :
                    Comment::STATUS_NEW

        ]);
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

}
