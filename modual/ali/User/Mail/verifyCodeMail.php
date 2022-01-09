<?php

namespace ali\User\Mail;

use ali\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class verifyCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */

    public $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('User::mails.verify-email')
            ->subject('وب آموز| کد فعال سازی');
    }
}
