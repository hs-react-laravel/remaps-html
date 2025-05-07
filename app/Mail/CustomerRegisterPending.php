<?php

namespace App\Mail;

use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class CustomerRegisterPending extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $company = \App\Models\Company::where('is_default', 1)->first();
        $emailTemplate = EmailTemplate::where('company_id', $company->id)->where('label', 'customer-pending')->first(['subject', 'body']);

        if($emailTemplate){
            $subject = $emailTemplate->subject;
            $body = $emailTemplate->body;

            $body = str_replace('##APP_LOGO', Storage::disk('azure')->url($this->user->company->logo), $body);
            $body = str_replace('##APP_NAME', $this->user->company->name, $body);
            $body = str_replace('##USER_NAME', $this->user->full_name, $body);

            $this->subject($subject)
                ->view('emails.layout')
                ->with(['body'=>$body]);

        }
    }
}
