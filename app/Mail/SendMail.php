<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public string $subjects;
    public string $message;
    public string $vw;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $subjects,string $message,string $vw , $testMailData )
    {
        $this->subjects=$subjects;
        $this->message=$message;
        $this->vw=$vw;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
     return $this->subject($this->subjects)
                    ->view($this->vw)->with([
                        'emailmessage' => $this->message,
                      
                    ]);
    }
}
