<?php

namespace App\Mail;

use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class CompanyActivateEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */

    public $user;

    /**
     * The token.
     *
     * @var Token
     */

    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailTemplate = EmailTemplate::where('company_id', 1)->where('label', 'customer-activate-email')->first(['subject', 'body']);
		if($emailTemplate){
            $subject = $emailTemplate->subject;
            $body = $emailTemplate->body;
            $body = str_replace('##APP_NAME', $this->user->name, $body);

            if($this->user->is_admin){
                $company = \App\Models\Company::where('is_default', 1)->first(['logo']);
                $body = str_replace('##APP_LOGO', Storage::disk('azure')->url($company->logo), $body);
                $body = str_replace('##LINK', $this->user->company->v2_domain_link.'/admin/password/reset/'.$this->token, $body);
            }else{
                $body = str_replace('##APP_LOGO', Storage::disk('azure')->url($this->user->company->logo), $body);
                $body = str_replace('##LINK', $this->user->company->v2_domain_link.'/password/reset/'.$this->token, $body);
            }
            $body = str_replace('##USER_NAME', $this->user->full_name, $body);

            $this->subject($subject)
                ->view('emails.layout')
                ->with(['body'=>$body]);

        }
    }
}
