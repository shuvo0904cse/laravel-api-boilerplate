<?php

namespace App\Jobs;

use App\Models\Email;
use App\Services\EmailService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmailCsvProcess implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $header;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $header)
    {
        $this->data   = $data;
        $this->header = $header;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data as $email) {
            $newEmail = array_combine($this->header, $email);

            //email Exists Check
            $existsEmail = $this->emailModel()->checkEmailAddress($newEmail['email']);

            //if email not exists then store
            if(empty($existsEmail)) $this->emailService()->store($newEmail);
        }
    }

    protected function emailService(){
        return new EmailService();
    }

    protected function emailModel(){
        return new Email();
    }
}
