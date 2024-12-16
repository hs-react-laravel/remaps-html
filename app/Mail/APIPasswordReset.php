<?php

namespace App\Mail;

use App\Models\Api\ApiUser;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class APIPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var ApiUser
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
    public function __construct(ApiUser $user, $token)
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
        $company = \App\Models\Company::where('is_default', 1)->first();
        $emailTemplate = EmailTemplate::where('company_id', $company->id)->where('label', 'api-reset-email')->first(['subject', 'body']);

        if($emailTemplate){
            $subject = $emailTemplate->subject;
            $body = $emailTemplate->body;

            $body = str_replace('##APP_LOGO', env('AZURE_STORAGE_URL').'uploads/'.$company->logo, $body);
            $body = str_replace('##LINK', 'https://remapdash.com/api-password-reset?token='.$this->token.'&email='.$this->user->email, $body);
            $body = str_replace('##USER_NAME', $this->user->full_name, $body);

            $this->subject($subject)
                ->view('emails.layout')
                ->with(['body'=>$body]);

        }
    }
}
