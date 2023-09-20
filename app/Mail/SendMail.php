<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    // /**
    //  * Create a new message instance.
    //  *
    //  * @return void
    //  */
    public function __construct($subj,$msg)
    {
        $this->subj = $subj;
        $this->msg = $msg;
    }

    // /**
    //  * Build the message.
    //  *
    //  * @return $this
    //  */
    public function build()
    {
        $email = $this->subject($this->subj)
            ->markdown('send_mail')
            ->with([
                'msg' => $this->msg
            ]);
        return $email;
    }
}
