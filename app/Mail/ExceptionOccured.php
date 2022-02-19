<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExceptionOccured extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $exceptions;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($exceptions)
    {
        $this->exceptions = $exceptions;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.exception', $this->exceptions);
    }
}
