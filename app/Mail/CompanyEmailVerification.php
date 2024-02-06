<?php

namespace App\Mail;

use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompanyEmailVerification extends Mailable
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
        $emailTemplate = EmailTemplate::where('company_id', 1)->where('label', 'company-verify-email')->first(['subject', 'body']);
		if($emailTemplate){
            $subject = $emailTemplate->subject;
            $body = $emailTemplate->body;
            $body = str_replace('##APP_NAME', $this->user->name, $body);

            $company = \App\Models\Company::where('is_default', 1)->first(['logo']);
            $body = str_replace('##APP_LOGO', env('AZURE_STORAGE_URL').'uploads/'.$company->logo, $body);
            // $body = str_replace('##LINK', $this->user->company->v2_domain_link.'/admin/password/reset/'.$this->token, $body);

            $body = str_replace('##USER_NAME', $this->user->full_name, $body);

            $this->subject($subject)
                ->view('emails.layout')
                ->with(['body'=>$body]);

        }
    }
}
