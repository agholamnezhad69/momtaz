<?php


namespace ali\User\Repositories;

use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;

class UserRepo
{

    public function finById($id)
    {
        return User::query()->findOrFail($id);
    }

    public function findByEmail($email)
    {
        return User::query()->where('email', $email)->first();

    }

    public function getTeachers()
    {

        return User::permission(Permission::PERMISSION_TEACH)->get();
    }

    public function paginate()
    {

        return User::paginate();
    }

    public function update($userId, $values)
    {
        $update =
            [
                "name" => $values->name,
                "email" => $values->email,
                "username" => $values->username,
                "headline" => $values->headline,
                "mobile" => $values->mobile,
                "website" => $values->website,
                "linkedin" => $values->linkedin,
                "facebook" => $values->facebook,
                "youtube" => $values->youtube,
                "twitter" => $values->twitter,
                "instagram" => $values->instagram,
                "telegram" => $values->telegram,
                "status" => $values->status,
                "bio" => $values->bio,
                "image_id" => $values->image_id,
            ];
        if (!is_null($values->password)) {
            $update["password"] = bcrypt($values->password);
        }
        User::query()->where("id", $userId)->update($update);
    }


}
