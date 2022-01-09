<?php

namespace ali\Course\Rules;


use ali\RolePermissions\Models\Permission;
use ali\User\Repositories\UserRepo;
use Illuminate\Contracts\Validation\Rule;

class ValidTeacher implements Rule
{

    public function passes($attribute, $value)
    {

        $user = resolve(UserRepo::class)->finById($value);

        return $user->hasPermissionTo(Permission::PERMISSION_TEACH);

    }

    public function message()
    {
        return 'کاربر انتخاب شده یک مدرس معتبر نیست';

    }
}
