<?php

namespace ali\Ticket\Models;

use ali\User\Models\User;
use Illuminate\Database\Eloquent\Model;


class Ticket extends Model
{

    public function user()
    {

        return $this->belongsTo(User::class);

    }



    public function ticketable()
    {

        return $this->morphTo();

    }

    public function ticketReplies()
    {
        return $this->hasMany(Reply::class);
    }

}
