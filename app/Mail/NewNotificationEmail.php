<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var Company
     */

    public $company;

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
    public function __construct(Company $company, User $user)
    {

		$this->user = $user;
		$this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $emailTemplate = EmailTemplate::where('company_id', 1)->where('label', 'new-notification')->first(['subject', 'body']);

        if($emailTemplate){
            $subject = str_replace('##COMPANY_NAME##', $this->company['name'], $emailTemplate->subject);
            $body = $emailTemplate->body;
            $body = str_replace('##COMPANY_NAME##', $this->company['name'], $body);
			$body = str_replace('##USER_NAME##', $this->user->first_name.' '.$this->user->last_name, $body);
			$body = str_replace('##APP_NAME##', config('app.name'), $body);
            $this->subject($subject)
                ->view('emails.layout')
                ->with(['body'=>$body]);

        }
    }
}
