<?php

namespace ali\Course\Rules;


use ali\Course\Models\Season;
use ali\RolePermissions\Models\Permission;
use ali\User\Repositories\UserRepo;
use ali\Course\Repositories\SeasonRepo;
use Illuminate\Contracts\Validation\Rule;

class ValidSeason implements Rule
{

    public function passes($attribute, $season_id)
    {


        $season = resolve(SeasonRepo::class)->finByIdAndCourseId($season_id, request()->route('course'));

        if ($season) {
            return true;
        }
        return false;

    }

    public function message()
    {
        return 'سرفصل انتخاب شده معتبر نمی باشد';

    }
}
