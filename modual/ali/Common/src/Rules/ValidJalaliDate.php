<?php

namespace ali\Common\Rules;

use Illuminate\Contracts\Validation\Rule;
use Morilog\Jalali\Jalalian;

class ValidJalaliDate implements Rule
{
    private $messageError;

    public function __construct()
    {

    }

    public function passes($attribute, $value)

    {
        try {
            $persianDate = convertPersianNumberToEnglish($value);
            $persianDate = str_replace("  ", "", $persianDate);
            Jalalian::fromFormat("Y/m/d H:i:s", $persianDate)->toCarbon();
            return true;
        } catch (\Exception $exception) {
            $this->messageError = $exception->getMessage() . " - {$value}";
            return false;
        }
    }

    public function message()
    {
        return "یک تاریخ معتبر شمسی انتخاب کنید" . "{$this->messageError}";
    }
}
