<?php

namespace ali\Comment\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Comment::mails.comment-approved-mail');
    }
}
