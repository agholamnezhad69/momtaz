<?php

use Morilog\Jalali\Jalalian;

function newFeedbacks($title = "عملیات موفق آمیز ", $body = "عملیات با موفقیت آمیز انجام شد", $type = "success")
{
    $session = session()->get('feedbacks') ? session()->get('feedbacks') : [];

    $session [] = ["title" => $title, "body" => $body, "type" => $type];

    session()->flash('feedbacks', $session);

}

function dateFromJalali($date, $format = "Y/m/d")
{


    return $date ? Jalalian::fromFormat("Y/m/d", $date)->toCarbon() : null;


}

