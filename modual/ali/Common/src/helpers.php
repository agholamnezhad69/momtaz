<?php

use Illuminate\Support\Carbon;
use Morilog\Jalali\Jalalian;

function newFeedbacks($title = "عملیات موفق آمیز ", $body = "عملیات با موفقیت آمیز انجام شد", $type = "success")
{
    $session = session()->get('feedbacks') ? session()->get('feedbacks') : [];

    $session [] = ["title" => $title, "body" => $body, "type" => $type];

    session()->flash('feedbacks', $session);

}

function getDateFromJalaliToCarbon($date, $format = "Y/m/d")
{


    return $date ? Jalalian::fromFormat("Y/m/d", $date)->toCarbon() : null;


}

function getDateFromCarbonToJalali($date, $format = "Y-m-d")
{


    return Jalalian::fromCarbon(Carbon::createFromFormat($format, $date))->format($format);


}

function createJalaliFromCarbon(Carbon $carbon)
{


    return Jalalian::fromCarbon($carbon);


}

