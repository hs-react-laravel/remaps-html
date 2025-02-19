<?php

namespace App\Mail;

use App\Models\Subscription;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BillingSubscriptionCancelled extends Mailable
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
        $emailTemplate = EmailTemplate::whereLabel('subscription-cancelled')->first(['subject', 'body']);

        if($emailTemplate){
            $masterCompany = \App\Models\Company::where('is_default', 1)->first(['name', 'logo']);
            $company = $this->subscription->user->company;

            $subject = $emailTemplate->subject;
            $subject = str_replace('##COMPANY_NAME', $company->name, $subject);

            $body = $emailTemplate->body;

            $body = str_replace('##APP_NAME', $masterCompany->name, $body);
            $body = str_replace('##APP_LOGO', env('AZURE_STORAGE_URL').'uploads/'.$masterCompany->logo, $body);
            $body = str_replace('##COMPANY_NAME', $company->name, $body);
            $body = str_replace('##PLAN_ID', $this->subscription->pay_agreement_id, $body);

            $lastPayment = $this->subscription->subscriptionPayments()->orderBY('id', 'DESC')->first();
            if($lastPayment){
                $body = str_replace('##AGREEMENT_NEXT_BILLING_DATE', $lastPayment->next_billing_date, $body);
            }

            $this->subject($subject)
                ->view('emails.layout')
                ->with(['body'=>$body]);
        }
    }
}
