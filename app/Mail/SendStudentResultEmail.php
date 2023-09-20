<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendStudentResultEmail extends Mailable
{
    use Queueable, SerializesModels;

    // /**
    //  * Create a new message instance.
    //  *
    //  * @return void
    //  */
    public function __construct($subj,$msg,$path)
    {
        $this->subj = $subj;
        $this->path = $path;
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
            ->markdown('send_student_result')
            ->with([
                'msg' => $this->msg
            ]);
        $email->attach($this->path);
        return $email;
    }
}
