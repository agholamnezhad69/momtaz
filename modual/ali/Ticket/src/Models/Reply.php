<?php

namespace ali\Ticket\Models;

use ali\Media\Models\Media;
use ali\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;


class Reply extends Model
{
    protected $guarded = [];
    protected $table = "ticket_replies";

    public function user()
    {

        return $this->belongsTo(User::class);

    }

    public function ticket()
    {

        return $this->belongsTo(Ticket::class);

    }

    public function media()
    {

        return $this->belongsTo(Media::class);

    }

    public function attachmentLink()
    {
        if ($this->media_id)

            return URL::temporarySignedRoute('media.download', now()->addDay(), ['media' => $this->media_id]);


    }

}
