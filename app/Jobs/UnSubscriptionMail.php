<?php

namespace App\Jobs;

use App\Mail\UnSubscriptionMail as MailUnSubscriptionMail;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UnSubscriptionMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $unSubscription;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Subscription $unSubscription)
    {
        $this->unSubscription = $unSubscription;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->unSubscription->email)->send(new MailUnSubscriptionMail($this->unSubscription));
    }
}
