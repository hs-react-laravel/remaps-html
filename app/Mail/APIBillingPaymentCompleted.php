<?php

namespace App\Mail;

use App\Models\Subscription;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class APIBillingPaymentCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The subscription.
     *
     * @var Token
     */

    public $subscription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailTemplate = EmailTemplate::whereLabel('api-welcome-email')->first(['subject', 'body']);

        if($emailTemplate){
            $masterCompany = \App\Models\Company::where('is_default', 1)->first(['name', 'logo']);

            $body = $emailTemplate->body;
            $subject = $emailTemplate->subject;

            $body = str_replace('##APP_NAME', $masterCompany->name, $body);
            $body = str_replace('##APP_LOGO', Storage::disk('azure')->url($masterCompany->logo), $body);
            $body = str_replace('##USER_NAME', $this->subscription->user->fullname, $body);
            $body = str_replace('##AGREEMENT_ID', $this->subscription->pay_agreement_id, $body);

            $lastPayment = $this->subscription->subscriptionPayments()->orderBY('id', 'DESC')->first();
            if($lastPayment){
                $body = str_replace('##AGREEMENT_AMOUNT', $lastPayment->last_payment_amount, $body);
            }

            $this->subject($subject)
                ->view('emails.layout')
                ->with(['body'=>$body]);
        }
    }
}
