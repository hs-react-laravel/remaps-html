<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class BankTransferNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The file service instance.
     *
     * @var Order
     */

    public $order;

    public $credits;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $credits)
    {
        $this->order = $order;
        $this->credits = $credits;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailTemplate = EmailTemplate::where('company_id', 1)->where('label', 'bank-transfer-notify-admin')->first(['subject', 'body']);
        if($emailTemplate){
            $subject = $emailTemplate->subject;
            $body = $emailTemplate->body;

            $company = $this->order->user->company;
            $currencyCode = config('constants.currency_signs')[$company->paypal_currency_code];

            $body = str_replace('##APP_NAME', $company->name, $body);
            $body = str_replace('##APP_LOGO', Storage::disk('azure')->url($company->logo), $body);
            $body = str_replace('##USER_NAME', $company->owner->full_name, $body);
            $body = str_replace('##CREDIT_COUNT', $this->credits, $body);
            $body = str_replace('##AMOUNT', $currencyCode.$this->order->amount, $body);
            $body = str_replace('##CUSTOMER_NAME', $this->order->user->full_name, $body);
            $body = str_replace('##CUSTOMER_BUSINESS_NAME', $this->order->user->business_name, $body);

            $this->subject($subject)
                ->view('emails.layout')
                ->with(['body'=>$body]);
        }
    }
}
