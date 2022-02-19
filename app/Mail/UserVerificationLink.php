<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerificationLink extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $link;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $user)
    {
        $this->link = $link;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('User Verification Link')
                    ->markdown('emails.userVerificationLink')
                    ->with('user', $this->user)
                    ->with('link', $this->link);
    }
}
