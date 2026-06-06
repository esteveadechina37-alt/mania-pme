<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RhNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $userName;

    public function __construct($subject, $body, $userName)
    {
        $this->subject  = $subject;
        $this->body     = $body;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.rh-notification')
                    ->with([
                        'subject'  => $this->subject,
                        'body'     => $this->body,
                        'userName' => $this->userName,
                    ]);
    }
}