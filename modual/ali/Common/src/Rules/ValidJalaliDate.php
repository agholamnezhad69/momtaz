<?php

namespace ali\Common\Rules;

use Illuminate\Contracts\Validation\Rule;
use Morilog\Jalali\Jalalian;

class ValidJalaliDate implements Rule
{

    public function __construct()
    {

    }


    public function passes($attribute, $value)

    {
        $persianDate = convertPersianNumberToEnglish($value);
        $persianDate = str_replace("  ", "", $persianDate);

        try {
            Jalalian::fromFormat("Y/m/d H:i:s", $persianDate)->toCarbon();
            return true;

        } catch (\Exception $exception) {

            return false;

        }

    }

    public function message()
    {
        return 'یک تاریخ معتبر شمسی انتخاب کنید';
    }
}
