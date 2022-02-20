<?php

namespace App\Jobs;

use App\Mail\MagicLoginTOkenMail;
use App\Models\MagicLoginToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMagicLoginLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $magicLoginToken;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MagicLoginToken $magicLoginToken)
    {
        $this->magicLoginToken = $magicLoginToken;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->magicLoginToken->email)->send(new MagicLoginTOkenMail($this->magicLoginToken));
    }
}
