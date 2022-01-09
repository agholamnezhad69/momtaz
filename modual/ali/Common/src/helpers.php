<?php

function newFeedbacks($title="عملیات موفق آمیز ", $body="عملیات با موفقیت آمیز انجام شد", $type="success")
{
    $session = session()->get('feedbacks') ? session()->get('feedbacks') : [];

    $session [] = ["title" => $title, "body" => $body, "type" => $type];

    session()->flash('feedbacks', $session);

}

