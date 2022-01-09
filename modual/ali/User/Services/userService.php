<?php


namespace ali\User\Services;


class userService
{
    public static function changePassword($user, $newPassword)
    {
        $user->password = bcrypt($newPassword);
        $user->save();
    }
}
