<?php

namespace ali\Comment\Repositories;

use ali\Comment\Models\Comment;
use ali\RolePermissions\Models\Permission;

class CommentRepo
{

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

}
