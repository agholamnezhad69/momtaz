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

    public function updateProfile($request)
    {

        auth()->user()->name = $request->name;
        auth()->user()->website = $request->website;
        auth()->user()->linkedin = $request->linkedin;
        auth()->user()->facebook = $request->facebook;
        auth()->user()->youtube = $request->youtube;
        auth()->user()->twitter = $request->twitter;
        auth()->user()->instagram = $request->instagram;
        auth()->user()->telegram = $request->telegram;

        if ($request->password) {
            auth()->user()->password = bcrypt($request->password);
        }

//        if (auth()->user()->email != $request->email) {
//            auth()->user()->email = $request->email;
//            auth()->user()->email_verified_at = null;
//        }

        if (auth()->user()->email != $request->email) {
            auth()->user()->email = $request->email;
        }


        if (auth()->user()->mobile != $request->mobile) {
            auth()->user()->mobile = $request->mobile;
            auth()->user()->email_verified_at = null;

        }

        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_TEACH)) {

            auth()->user()->card_number = $request->card_number;
            auth()->user()->shaba = $request->shaba;
            auth()->user()->headline = $request->headline;
            auth()->user()->bio = $request->bio;
            auth()->user()->username = $request->username;

        }


        auth()->user()->save();

    }


}
