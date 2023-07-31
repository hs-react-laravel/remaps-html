<?php

namespace App\Http\Controllers;

use App\Mail\BillingSubscriptionCancelled;
use App\Mail\BillingSubscriptionCreated;
use PayPal\Auth\OAuthTokenCredential;
use App\Mail\BillingPaymentCompleted;
use App\Mail\BillingPaymentPending;
use App\Mail\BillingPaymentDenied;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionPayment;
use PayPal\Api\AgreementDetails;
use Illuminate\Http\Request;
use App\Models\Subscription;
use PayPal\Rest\ApiContext;
use PayPal\Api\Agreement;
use App\Models\Company;
use App\Models\Shop\ShopSubscription;
use App\Models\Shop\ShopSubscriptionPayment;
use App\Models\Api\ApiSubscription;
use App\Models\Api\ApiSubscriptionPayment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class PaypalWebhookController extends Controller{

    private $apiContext;
    private $master;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(){
        $this->master = Company::where('is_default', 1)->first();
        if($this->master){
            Config::set('mail.default', 'smtp');
            Config::set('mail.mailers.smtp.host', 'mail.remapdash.com');
            Config::set('mail.mailers.smtp.port', 25);
            Config::set('mail.mailers.smtp.encryption', '');
            Config::set('mail.mailers.smtp.username', 'no-reply@remapdash.com');
            Config::set('mail.mailers.smtp.password', '5Cp38@gj2');
            Config::set('mail.from.address', 'no-reply@remapdash.com');
            Config::set('mail.from.address', $this->master->main_email_address);
            Config::set('mail.from.name', $this->master->name);
            Config::set('app.name', $this->master->name);
            Config::set('backpack.base.project_name', $this->master->name);

            Config::set('paypal.client_id', $this->master->paypal_client_id);
            Config::set('paypal.secret', $this->master->paypal_secret);
            Config::set('paypal.settings.mode', $this->master->paypal_mode);

        }
        // $paypalConf = Config::get('paypal');
        // $this->apiContext = new ApiContext(new OAuthTokenCredential($paypalConf['client_id'], $paypalConf['secret']));
        // $this->apiContext->setConfig($paypalConf['settings']);
    }

    /**
     * Handle paypal webhook events.
     * @return void
     */
    public function index(Request $request){
        Log::info($request->event_type);
        /* Check event type */

        switch ($request->event_type) {

            /* Subscription created */
            case 'BILLING.SUBSCRIPTION.CREATED':
                $resource = $request->resource;
                $subscription = Subscription::where('pay_agreement_id', $resource['id'])->first();
                if($subscription){
                    Mail::to($this->master->owner->email)->send(new BillingSubscriptionCreated($subscription));
                    Log::info('BILLING.SUBSCRIPTION.CREATED:: Subscription created.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.CREATED:: Agreement doesn\'t exists.');
                }

                $shopSubscription = ShopSubscription::where('pay_agreement_id', $resource['id'])->first();
                if($shopSubscription){
                    Mail::to($this->master->owner->email)->send(new BillingSubscriptionCreated($subscription));
                    Log::info('BILLING.SUBSCRIPTION.CREATED:: Subscription created.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.CREATED:: Agreement doesn\'t exists.');
                }

                $apiSubscription = ApiSubscription::where('pay_agreement_id', $resource['id'])->first();
                if($apiSubscription){
                    Mail::to($this->master->owner->email)->send(new BillingSubscriptionCreated($subscription));
                    Log::info('BILLING.SUBSCRIPTION.CREATED:: Subscription created.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.CREATED:: Agreement doesn\'t exists.');
                }
                break;
            /* Subscription cancelled */
            case 'BILLING.SUBSCRIPTION.CANCELLED':
                $resource = $request->resource;
                Log::error('Cancelled: '.$resource['id']);
                $subscription = Subscription::where('pay_agreement_id', $resource['id'])->first();
                if($subscription){
                    $subscription->status = $resource['status'];
                    $subscription->save();

                    Mail::to($this->master->owner->email)->send(new BillingSubscriptionCancelled($subscription));

                    Log::info('BILLING.SUBSCRIPTION.CANCELLED:: Subscription cancelled.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.CANCELLED:: Agreement doesn\'t exists.');
                }

                $shopSubscription = ShopSubscription::where('pay_agreement_id', $resource['id'])->first();
                if($shopSubscription){
                    $shopSubscription->status = $resource['status'];
                    $shopSubscription->save();

                    Mail::to($this->master->owner->email)->send(new BillingSubscriptionCancelled($shopSubscription));

                    Log::info('BILLING.SUBSCRIPTION.CANCELLED:: Subscription cancelled.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.CANCELLED:: Agreement doesn\'t exists.');
                }

                $apiSubscription = ApiSubscription::where('pay_agreement_id', $resource['id'])->first();
                if($apiSubscription){
                    $apiSubscription->status = $resource['status'];
                    $apiSubscription->save();

                    Mail::to($this->master->owner->email)->send(new BillingSubscriptionCancelled($apiSubscription));

                    Log::info('BILLING.SUBSCRIPTION.CANCELLED:: Subscription cancelled.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.CANCELLED:: Agreement doesn\'t exists.');
                }

                break;

            /* Subscription suspended */
            case 'BILLING.SUBSCRIPTION.SUSPENDED':
                $resource = $request->resource;
                $subscription = Subscription::where('pay_agreement_id', $resource['id'])->first();
                if($subscription){
                    $subscription->status = $resource['status'];
                    $subscription->save();

                    Log::info('BILLING.SUBSCRIPTION.SUSPENDED:: Subscription suspended.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.SUSPENDED:: Agreement doesn\'t exists.');
                }

                $shopSubscription = ShopSubscription::where('pay_agreement_id', $resource['id'])->first();
                if($shopSubscription){
                    $shopSubscription->status = $resource['status'];
                    $shopSubscription->save();

                    Log::info('BILLING.SUBSCRIPTION.SUSPENDED:: Subscription suspended.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.SUSPENDED:: Agreement doesn\'t exists.');
                }

                $apiSubscription = ApiSubscription::where('pay_agreement_id', $resource['id'])->first();
                if($apiSubscription){
                    $apiSubscription->status = $resource['status'];
                    $apiSubscription->save();

                    Log::info('BILLING.SUBSCRIPTION.SUSPENDED:: Subscription suspended.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.SUSPENDED:: Agreement doesn\'t exists.');
                }

                break;

            /* Subscription suspended */
            case 'BILLING.SUBSCRIPTION.RE-ACTIVATED':
                $resource = $request->resource;
                $subscription = Subscription::where('pay_agreement_id', $resource['id'])->first();
                if($subscription){
                    $subscription->status = $resource['status'];
                    $subscription->save();

                    Log::info('BILLING.SUBSCRIPTION.RE-ACTIVATED:: Subscription re-activated.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.RE-ACTIVATED:: Agreement doesn\'t exists.');
                }

                $shopSubscription = ShopSubscription::where('pay_agreement_id', $resource['id'])->first();
                if($shopSubscription){
                    $shopSubscription->status = $resource['status'];
                    $shopSubscription->save();

                    Log::info('BILLING.SUBSCRIPTION.RE-ACTIVATED:: Subscription re-activated.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.RE-ACTIVATED:: Agreement doesn\'t exists.');
                }

                $apiSubscription = ApiSubscription::where('pay_agreement_id', $resource['id'])->first();
                if($apiSubscription){
                    $apiSubscription->status = $resource['status'];
                    $apiSubscription->save();

                    Log::info('BILLING.SUBSCRIPTION.RE-ACTIVATED:: Subscription re-activated.');
                }else{
                    Log::info('BILLING.SUBSCRIPTION.RE-ACTIVATED:: Agreement doesn\'t exists.');
                }

                break;

            /* Subscription Payment completed */
            case 'PAYMENT.SALE.COMPLETED':
            	$resource = $request->resource;
				//\Log::info(print_r($resource, true));
                $subscription = Subscription::where('pay_agreement_id', @$resource['billing_agreement_id'])->first();
                Log::error('billing_agreement_id: '.@$resource['billing_agreement_id']);
                if($subscription){
                    // $agreement = \PayPal\Api\Agreement::get($subscription->pay_agreement_id, $this->apiContext);
                    // $agreementDetails = $agreement->getAgreementDetails();
                    $billingInfo = $this->getSubscriptionBillingInfo($subscription->pay_agreement_id);

                    $subscriptionPayment = SubscriptionPayment::where('pay_txn_id', $resource['id'])->first();
                    if(!$subscriptionPayment){
                    	$subscriptionPayment = new SubscriptionPayment();
                    }
                    //\Log::info(print_r($agreementDetails, true));
					//\Log::info(print_r($agreementDetails->getLastPaymentAmount(), true));
                    $subscriptionPayment->subscription_id = $subscription->id;
                    $subscriptionPayment->pay_txn_id = $resource['id'];
                    $subscriptionPayment->next_billing_date = \Carbon\Carbon::parse($billingInfo->next_billing_time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_date  = \Carbon\Carbon::parse($billingInfo->last_payment->time)->format('Y-m-d H:i:s');
                    //$subscriptionPayment->last_payment_amount  = $agreementDetails->getLastPaymentAmount()->value;
					if(isset($billingInfo->last_payment->amount->value)) {
						$subscriptionPayment->last_payment_amount  = $billingInfo->last_payment->amount->value;
                    }

					$subscriptionPayment->failed_payment_count  = $billingInfo->failed_payments_count;
                    $subscriptionPayment->status = $resource['state'];

                    if($subscriptionPayment->save()){
                        Mail::to($this->master->owner->email)->send(new BillingPaymentCompleted($subscription));
                    }
                    Log::info('PAYMENT.SALE.COMPLETED:: Payment sale completed.');

                }else{

                    Log::info('PAYMENT.SALE.COMPLETED:: Agreement doesn\'t exists.');
                }

                $shopSubscription = ShopSubscription::where('pay_agreement_id', @$resource['billing_agreement_id'])->first();
                if ($shopSubscription) {
                    $billingInfo = $this->getShopSubscriptionBillingInfo($shopSubscription->pay_agreement_id);

                    $subscriptionPayment = ShopSubscriptionPayment::where('pay_txn_id', $resource['id'])->first();
                    if(!$subscriptionPayment){
                    	$subscriptionPayment = new ShopSubscriptionPayment();
                    }
                    $subscriptionPayment->shop_subscription_id = $shopSubscription->id;
                    $subscriptionPayment->pay_txn_id = $resource['id'];
                    $subscriptionPayment->next_billing_date = \Carbon\Carbon::parse($billingInfo->next_billing_time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_date  = \Carbon\Carbon::parse($billingInfo->last_payment->time)->format('Y-m-d H:i:s');
					if(isset($billingInfo->last_payment->amount->value)) {
						$subscriptionPayment->last_payment_amount  = $billingInfo->last_payment->amount->value;
                    }

					$subscriptionPayment->failed_payment_count  = $billingInfo->failed_payments_count;
                    $subscriptionPayment->status = $resource['state'];

                    if($subscriptionPayment->save()){
                        Mail::to($this->master->owner->email)->send(new BillingPaymentCompleted($shopSubscription));
                    }
                    Log::info('PAYMENT.SALE.COMPLETED:: Payment sale completed.');
                }

                $apiSubscription = ApiSubscription::where('pay_agreement_id', @$resource['billing_agreement_id'])->first();
                if ($apiSubscription) {
                    $billingInfo = $this->getSubscriptionBillingInfo($apiSubscription->pay_agreement_id);

                    $subscriptionPayment = ApiSubscriptionPayment::where('pay_txn_id', $resource['id'])->first();
                    if(!$subscriptionPayment){
                    	$subscriptionPayment = new ApiSubscriptionPayment();
                    }
                    $subscriptionPayment->subscription_id = $apiSubscription->id;
                    $subscriptionPayment->pay_txn_id = $resource['id'];
                    $subscriptionPayment->next_billing_date = \Carbon\Carbon::parse($billingInfo->next_billing_time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_date  = \Carbon\Carbon::parse($billingInfo->last_payment->time)->format('Y-m-d H:i:s');
					if(isset($billingInfo->last_payment->amount->value)) {
						$subscriptionPayment->last_payment_amount  = $billingInfo->last_payment->amount->value;
                    }

					$subscriptionPayment->failed_payment_count  = $billingInfo->failed_payments_count;
                    $subscriptionPayment->status = $resource['state'];

                    if($subscriptionPayment->save()){
                        Mail::to($this->master->owner->email)->send(new BillingPaymentCompleted($apiSubscription));
                    }
                    Log::info('PAYMENT.SALE.COMPLETED:: Payment sale completed.');
                }
                break;

            /* Subscription Payment Denied */
            case 'PAYMENT.SALE.DENIED':
            	$resource = $request->resource;
                $subscription = Subscription::where('pay_agreement_id', @$resource['billing_agreement_id'])->first();

                if($subscription){
                	// $agreement = \PayPal\Api\Agreement::get($subscription->pay_agreement_id, $this->apiContext);
                    // $agreementDetails = $agreement->getAgreementDetails();
                    $billingInfo = $this->getSubscriptionBillingInfo($subscription->pay_agreement_id);

                    $subscriptionPayment = SubscriptionPayment::where('pay_txn_id', $resource['id'])->first();
                    if(!$subscriptionPayment){
                    	$subscriptionPayment = new SubscriptionPayment();
                    }

                    $subscriptionPayment->subscription_id = $subscription->id;
                    $subscriptionPayment->pay_txn_id = $resource['id'];
                    $subscriptionPayment->next_billing_date = \Carbon\Carbon::parse($billingInfo->next_billing_time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_date  = \Carbon\Carbon::parse($billingInfo->last_payment->time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_amount  = $billingInfo->last_payment->amount->value;
                    $subscriptionPayment->failed_payment_count  = $billingInfo->failed_payments_count;
                	$subscriptionPayment->status = $resource['state'];

                	if($subscriptionPayment->save()){
                		Mail::to($this->master->owner->email)->send(new BillingPaymentPending($subscription));
                	}

                    Log::info('PAYMENT.SALE.Denied:: Payment sale denied.');

                }else{

                    Log::info('PAYMENT.SALE.Denied:: Agreement doesn\'t exists.');
                }

                $shopSubscription = ShopSubscription::where('pay_agreement_id', @$resource['billing_agreement_id'])->first();

                if($shopSubscription){
                	// $agreement = \PayPal\Api\Agreement::get($subscription->pay_agreement_id, $this->apiContext);
                    // $agreementDetails = $agreement->getAgreementDetails();
                    $billingInfo = $this->getSubscriptionBillingInfo($shopSubscription->pay_agreement_id);

                    $subscriptionPayment = ShopSubscriptionPayment::where('pay_txn_id', $resource['id'])->first();
                    if(!$subscriptionPayment){
                    	$subscriptionPayment = new ShopSubscriptionPayment();
                    }

                    $subscriptionPayment->shop_subscription_id = $shopSubscription->id;
                    $subscriptionPayment->pay_txn_id = $resource['id'];
                    $subscriptionPayment->next_billing_date = \Carbon\Carbon::parse($billingInfo->next_billing_time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_date  = \Carbon\Carbon::parse($billingInfo->last_payment->time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_amount  = $billingInfo->last_payment->amount->value;
                    $subscriptionPayment->failed_payment_count  = $billingInfo->failed_payments_count;
                	$subscriptionPayment->status = $resource['state'];

                	if($subscriptionPayment->save()){
                		Mail::to($this->master->owner->email)->send(new BillingPaymentPending($shopSubscription));
                	}

                    Log::info('PAYMENT.SALE.Denied:: Payment sale denied.');

                }else{

                    Log::info('PAYMENT.SALE.Denied:: Agreement doesn\'t exists.');
                }

                $apiSubscription = ApiSubscription::where('pay_agreement_id', @$resource['billing_agreement_id'])->first();
                if($apiSubscription){
                    $billingInfo = $this->getSubscriptionBillingInfo($apiSubscription->pay_agreement_id);

                    $subscriptionPayment = ApiSubscriptionPayment::where('pay_txn_id', $resource['id'])->first();
                    if(!$subscriptionPayment){
                    	$subscriptionPayment = new ApiSubscriptionPayment();
                    }

                    $subscriptionPayment->subscription_id = $apiSubscription->id;
                    $subscriptionPayment->pay_txn_id = $resource['id'];
                    $subscriptionPayment->next_billing_date = \Carbon\Carbon::parse($billingInfo->next_billing_time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_date  = \Carbon\Carbon::parse($billingInfo->last_payment->time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_amount  = $billingInfo->last_payment->amount->value;
                    $subscriptionPayment->failed_payment_count  = $billingInfo->failed_payments_count;
                	$subscriptionPayment->status = $resource['state'];

                	if($subscriptionPayment->save()){
                		Mail::to($this->master->owner->email)->send(new BillingPaymentPending($apiSubscription));
                	}

                    Log::info('PAYMENT.SALE.Denied:: Payment sale denied.');

                }else{

                    Log::info('PAYMENT.SALE.Denied:: Agreement doesn\'t exists.');
                }
            	break;

            /* Subscription payment pending */
            case 'PAYMENT.SALE.PENDING':
            	$resource = $request->resource;
                $subscription = Subscription::where('pay_agreement_id', @$resource['billing_agreement_id'])->first();

                if($subscription){
                	// $agreement = \PayPal\Api\Agreement::get($subscription->pay_agreement_id, $this->apiContext);
                    // $agreementDetails = $agreement->getAgreementDetails();
                    $billingInfo = $this->getSubscriptionBillingInfo($subscription->pay_agreement_id);

                    $subscriptionPayment = SubscriptionPayment::where('pay_txn_id', $resource['id'])->first();
                    if(!$subscriptionPayment){
                    	$subscriptionPayment = new SubscriptionPayment();
                    }

                    $subscriptionPayment->subscription_id = $subscription->id;
                    $subscriptionPayment->pay_txn_id = $resource['id'];
                    $subscriptionPayment->next_billing_date = \Carbon\Carbon::parse($billingInfo->next_billing_time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_date  = \Carbon\Carbon::parse($billingInfo->last_payment->time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_amount  = $billingInfo->last_payment->amount->value;
                    $subscriptionPayment->failed_payment_count  = $billingInfo->failed_payments_count;
                	$subscriptionPayment->status = $resource['state'];

                	if($subscriptionPayment->save()){
                		Mail::to($this->master->owner->email)->send(new BillingPaymentPending($subscription));
                	}
                    Log::info('PAYMENT.SALE.PENDING::Payment sale pending.');

                }else{

                    Log::info('PAYMENT.SALE.PENDING:: Agreement doesn\'t exists.');
                }

                $shopSubscription = ShopSubscription::where('pay_agreement_id', @$resource['billing_agreement_id'])->first();
                if($shopSubscription){
                    $billingInfo = $this->getSubscriptionBillingInfo($shopSubscription->pay_agreement_id);

                    $subscriptionPayment = ShopSubscriptionPayment::where('pay_txn_id', $resource['id'])->first();
                    if(!$subscriptionPayment){
                    	$subscriptionPayment = new ShopSubscriptionPayment();
                    }
                    $subscriptionPayment->shop_subscription_id = $shopSubscription->id;
                    $subscriptionPayment->pay_txn_id = $resource['id'];
                    $subscriptionPayment->next_billing_date = \Carbon\Carbon::parse($billingInfo->next_billing_time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_date  = \Carbon\Carbon::parse($billingInfo->last_payment->time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_amount  = $billingInfo->last_payment->amount->value;
                    $subscriptionPayment->failed_payment_count  = $billingInfo->failed_payments_count;
                	$subscriptionPayment->status = $resource['state'];

                	if($subscriptionPayment->save()){
                		Mail::to($this->master->owner->email)->send(new BillingPaymentPending($shopSubscription));
                	}
                    Log::info('PAYMENT.SALE.PENDING::Payment sale pending.');
                }else{
                    Log::info('PAYMENT.SALE.PENDING:: Agreement doesn\'t exists.');
                }

                $apiSubscription = ApiSubscription::where('pay_agreement_id', @$resource['billing_agreement_id'])->first();
                if($apiSubscription){
                    $billingInfo = $this->getSubscriptionBillingInfo($apiSubscription->pay_agreement_id);

                    $subscriptionPayment = ApiSubscriptionPayment::where('pay_txn_id', $resource['id'])->first();
                    if(!$subscriptionPayment){
                    	$subscriptionPayment = new ApiSubscriptionPayment();
                    }
                    $subscriptionPayment->shop_subscription_id = $apiSubscription->id;
                    $subscriptionPayment->pay_txn_id = $resource['id'];
                    $subscriptionPayment->next_billing_date = \Carbon\Carbon::parse($billingInfo->next_billing_time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_date  = \Carbon\Carbon::parse($billingInfo->last_payment->time)->format('Y-m-d H:i:s');
                    $subscriptionPayment->last_payment_amount  = $billingInfo->last_payment->amount->value;
                    $subscriptionPayment->failed_payment_count  = $billingInfo->failed_payments_count;
                	$subscriptionPayment->status = $resource['state'];

                	if($subscriptionPayment->save()){
                		Mail::to($this->master->owner->email)->send(new BillingPaymentPending($apiSubscription));
                	}
                    Log::info('PAYMENT.SALE.PENDING::Payment sale pending.');
                }else{
                    Log::info('PAYMENT.SALE.PENDING:: Agreement doesn\'t exists.');
                }

            	break;
            default:
            break;
        }
    }

    public function getAccessToken() {
        $ch = curl_init();
        $company = \App\Models\Company::where('is_default', 1)->first();
        if(!$company) return '';

        $clientId = $company->paypal_client_id;
        $secret = $company->paypal_secret;
        // $clientId = 'AdibmcjffSYZR9TSS5DuKIQpnf80KfY-3pBGd30JKz2Ar1xHIipwijo4eZOJvbDCFpfmOBItDqZoiHmM';
        // $secret = 'EEPRF__DLqvkwnnpi2Hi3paQ-9SZFRqypUH-u0fr4zAzvv7hWtz1bJHF0CEwvrvZpHyLeKSTO_FwAeO_';

        $api_url = "https://api.paypal.com/v1/oauth2/token";
        // $api_url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result);
        return $json->access_token;
    }

    public function getSubscriptionBillingInfo($id) {
        $url = "https://api.paypal.com/v1/billing/subscriptions/{$id}";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            'Accept: application/json',
            'Authorization: '."Bearer ". $this->getAccessToken(),
            'Prefer: return=representation',
            'Content-Type: application/json',
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $resp = curl_exec($curl);
        curl_close($curl);

        $subscriptionDetails = json_decode($resp);
        $billingInfo = $subscriptionDetails->billing_info;
        return $billingInfo;
    }

    public function getShopSubscriptionBillingInfo($id) {
        $url = "https://api.paypal.com/v1/billing/subscriptions/{$id}";
        // $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$id}";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            'Accept: application/json',
            'Authorization: '."Bearer ". $this->getAccessToken(),
            'Prefer: return=representation',
            'Content-Type: application/json',
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $resp = curl_exec($curl);
        curl_close($curl);

        $subscriptionDetails = json_decode($resp);
        $billingInfo = $subscriptionDetails->billing_info;
        return $billingInfo;
    }
}
