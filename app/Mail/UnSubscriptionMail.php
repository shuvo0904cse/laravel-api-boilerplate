<?php

namespace App\Mail;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnSubscriptionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $unSubscription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscription $unSubscription)
    {
        $this->unSubscription = $unSubscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Subscription')
                    ->markdown('emails.unSubscriptionMail')
                    ->with('subscription', $this->unSubscription);
    }
}
