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
        if ($this->owner->mail_host && $this->owner->mail_port
            && $this->owner->mail_username && $this->owner->mail_password) {
            Config::set('mail.default', $this->owner->mail_driver);
            Config::set('mail.mailers.smtp.host', $this->owner->mail_host);
            Config::set('mail.mailers.smtp.port', $this->owner->mail_port);
            Config::set('mail.mailers.smtp.encryption', $this->owner->mail_encryption);
            Config::set('mail.mailers.smtp.username', $this->owner->mail_username);
            Config::set('mail.mailers.smtp.password', $this->owner->mail_password);
            Config::set('mail.from.address',$this->owner->mail_username);
        }
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
