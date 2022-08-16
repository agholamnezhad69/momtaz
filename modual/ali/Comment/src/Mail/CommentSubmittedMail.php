<?php

namespace ali\Comment\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
//        dd($this->comment);
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->markdown('Comment::mails.comment-submitted-mail');
    }
}
