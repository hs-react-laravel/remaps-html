<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailFlag;

class SendMail implements ShouldQueue
{
    use Dispatchable, Queueable;

    public $email;
    public $instance;
    public $owner;
    public $desc;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $instance, $owner, $desc)
    {
        //
        $this->email = $email;
        $this->instance = $instance;
        $this->owner = $owner;
        $this->desc = $desc;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->email)->send($this->instance);
        } catch(\Exception $e){
            $ef = new EmailFlag;
            $ef->company_id = $this->owner->id;
            $ef->is_email_failed = 1;
            $ef->description = $this->desc;
            $ef->save();
            $this->fail();
        }
    }
}
