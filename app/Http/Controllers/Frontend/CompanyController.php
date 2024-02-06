<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRegisterFront;
use App\Http\Controllers\Controller;
use App\Mail\RegisterCompanyFront;
use App\Mail\NewCompanyApply;
use App\Mail\CompanyEmailVerification;

use App\Models\Company;
use App\Models\TuningCreditGroup;
use App\Models\Package;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\Payer;

use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Agreement;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

use App\Models\Api\ApiUser;
use App\Models\Api\ApiUserReg;
use App\Models\Api\ApiPackage;
use App\Models\Api\ApiSubscription;
use Illuminate\Support\Str;

class CompanyController extends Controller
{

	public function companies(Request $request){
		$qry = $request->all();
		if(!empty($qry) && isset($qry['keyword']) && isset($qry['sort'])  ){
			$keyword = $qry['keyword'];
			$sort = $qry['sort'];
		}

		$companies = Company::where('is_public', '1')->with('tuningCreditGroups', 'tuningCreditGroups.tuningCreditTires')->get()->toArray();
		return view('Frontend.companies',compact('companies'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$company = Company::all();
		return view('Frontend.create',compact('company'));
    }

	/**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

	 public function postPaymentWithpaypal(CompanyRegisterFront $request){
		 $company = new \App\Models\Company();
		 $company->name = $request->name;
		 $company->main_email_address = $request->main_email_address;

         if ($request->has('own_domain')) {
            $company->v2_domain_link = $request->own_domain;
         } else {
            $company->v2_domain_link = 'https://'.$request->v2_domain_link;
         }
		 $company->address_line_1 = $request->address_line_1;
		 $company->address_line_2 = $request->address_line_2;
		 $company->town = $request->town;
		 $company->country = $request->country;
		 $company->vat_number = $request->vat_number;

		 if($company->save()){
		  	 $companyUser = new \App\Models\User();
			 $companyUser->company_id = $company->id;
			 $companyUser->tuning_credit_group_id = Null;
			 $companyUser->first_name =  $request->name;
			 $companyUser->last_name = $request->name;
			 $companyUser->lang = 'en';
			 $companyUser->email = $request->main_email_address;
			 $companyUser->password =  Hash::make($request->password);
			 $companyUser->business_name =  $request->name;
			 $companyUser->address_line_1 =  $request->address_line_1;
			 $companyUser->address_line_2 =  $request->address_line_2;
			 $companyUser->county =  $request->country;
			 $companyUser->town =  $request->town;
			 $companyUser->is_master = 0;
			 $companyUser->is_admin = 1;
			 $companyUser->is_active = 0;
             $companyUser->is_verified = 0;
			 $companyUser->save();

			 $emailTemplates = \App\Models\EmailTemplate::where('company_id', 1)->whereIn('label', [
                'customer-welcome-email',
                'file-service-opened-email',
                'new-file-service-created-email',
                'file-service-modified-email',
                'file-service-processed-email',
                'new-subscription-email',
                'subscription-cancelled',
                'payment-completed',
                'payment-denied',
                'payment-pending',
                'new-ticket-created',
                'new-file-ticket-created',
                'reply-to-your-ticket',
                'customer-activate-email',
                'new-company-apply',
                'file-service-upload-limited',
                'staff-job-assigned',
                'new-notification',
                'shoporder-processed',
                'shoporder-dispatched',
                'shoporder-delivered',
                'car-data-text'
            ])->get();
            if($emailTemplates->count() > 0){
                foreach($emailTemplates as $emailTemplate){
                    $userTemplate = $emailTemplate->replicate();
                    $userTemplate->company_id = $company->id;
                    $userTemplate->save();
                }
            }
            $mainCompany = Company::where('id', '1')->first()->toArray();

            Config::set('mail.default', 'smtp');
            Config::set('mail.mailers.smtp.host', 'mail.remapdash.com');
            Config::set('mail.mailers.smtp.port', 25);
            Config::set('mail.mailers.smtp.encryption', '');
            Config::set('mail.mailers.smtp.username', 'no-reply@remapdash.com');
            Config::set('mail.mailers.smtp.password', '5Cp38@gj2');
            Config::set('mail.from.address', $mainCompany['mail_username']);
            Config::set('mail.from.name', $mainCompany['name']);
            Config::set('app.name', $mainCompany['name']);

            $token = app('auth.password.broker')->createToken($user);

            try{
                Mail::to($companyUser->email)->send(new CompanyEmailVerification($companyUser));
            }catch(\Exception $e){
            }
            return redirect()->route('thankyou')->with('Regististration received, Please wait for your application to be processed');
		}else{
			return redirect()->back()->with('error', 'Unknown error occurred');
		}

	 }

	public function thankyou(){
        $msg = 'Regististration received, Please wait for your application to be processed';
		return view('Frontend.thankyou', compact('msg'));
	}

    public function api_intro() {
        $token = session('api_token');
        $apiUser = ApiUser::where('api_token', $token)->first();
        if ($apiUser) {
            return redirect()->route('frontend.api.dashboard');
        }

        return view('Frontend.api_reg');
    }

    public function api_login() {
        $token = session('api_token');
        $apiUser = ApiUser::where('api_token', $token)->first();
        if ($apiUser) {
            return redirect()->route('frontend.api.dashboard');
        }

        return view('Frontend.api_login');
    }

    public function api_login_post(Request $request) {
        $apiUser = Apiuser::where('email', $request->email)->first();
        if (!$apiUser || !Hash::check($request->new_password, $apiUser->password)) {
            session()->flash('error', 'These credentials do not match our records.');
            return redirect()->route('frontend.api.login');
        }

        session(['api_token' => $apiUser->api_token]);
        return redirect()->route('frontend.api.dashboard');
    }

    public function api_logout(Request $request) {
        session()->forget('api_token');
        return redirect()->route('frontend.api.login');
    }

    public function api_dashboard(Request $request) {
        $token = session('api_token');
        $apiUser = ApiUser::where('api_token', $token)->first();

        if (!$apiUser) {
            return redirect()->route('frontend.api.login');
        }

        $body = $apiUser->body;
        if (!$body) {
            $company = Company::where('is_default', 1)->first();
            $template = \App\Models\EmailTemplate::where('company_id', $company->id)->where('label', 'car-data-text')->first(['subject', 'body']);
            $body = $template->body;
        }

        return view('Frontend.api_dashboard', compact('apiUser', 'body'));
    }

    public function api_save_template(Request $request) {
        $apiUser = ApiUser::find($request->id);
        $apiUser->update([
            'body_default' => $request->body_default,
            'body' => $request->body
        ]);

        $body = $apiUser->body;
        if (!$body) {
            $company = Company::where('is_default', 1)->first();
            $template = \App\Models\EmailTemplate::where('company_id', $company->id)->where('label', 'car-data-text')->first(['subject', 'body']);
            $body = $template->body;
        }
        return view('Frontend.api_dashboard', compact('apiUser', 'body'));
    }

    public function api_document(Request $request) {
        return view('Frontend.api_documentation');
    }

    public function api_desc() {
        $token = session('api_token');
        $apiUser = ApiUser::where('api_token', $token)->first();
        $package = ApiPackage::first();
        $price = $package->amount;
        if ($apiUser) {
            return redirect()->route('frontend.api.dashboard');
        }
        return view('Frontend.api_intro')->with(compact('price'));
    }

    public function api_reg(Request $request) {
        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|unique:api_users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|required_with:password|min:6|same:password',
            'phone' => 'required|max:255',
            'company' => 'required|max:255',
            'domain' => 'required|max:255',
        ]);

        $token = Str::random(50);
        $request->request->add([
            'api_token'=> $token,
            'password' => Hash::make($request->password)
        ]);
        $user = ApiUserReg::create($request->all());
        return redirect()->route('frontend.api.register.confirm', ['token' => $token]);
    }

    public function api_reg_confirm(Request $request) {
        $token = $request->token;
        return view('Frontend.api_intro_confirm', compact('token'));
    }

    public function api_tc(Request $request) {
        return view('Frontend.api_tc');
    }

    public function api_subscription(Request $request, $token) {
        $apiUser = ApiUserReg::where('api_token', $token)->first();
        if (!$apiUser) {
            return redirect()->route('frontend.api.intro');
        }

        try {
            $package = ApiPackage::first();
            $accessToken = $this->getAccessToken();
            return $this->curlSubscription($package, $apiUser, $accessToken);
        } catch (\Exception $ex) {
            dd($ex);
            return redirect()->route('frontend.api.intro');
        }
    }

    public function api_edit_profile() {
        $token = session('api_token');
        $apiUser = ApiUser::where('api_token', $token)->first();
        return view('Frontend.api_profile_edit')->with([
            'user' => $apiUser
        ]);
    }

    public function api_edit_profile_save(Request $request) {
        $token = session('api_token');
        $apiUser = ApiUser::where('api_token', $token)->first();
        $apiUser->update($request->all());
        return redirect()->route('frontend.api.dashboard');
    }

    public function curlSubscription($package, $apiUser, $accessToken) {
        $startDate = '';

        switch ($package->billing_interval) {
            case 'Day':
                $startDate = \Carbon\Carbon::now()->addDay()->format('Y-m-d\TH:i:s\Z');
                break;
            case 'Week':
                $startDate = \Carbon\Carbon::now()->addWeek()->format('Y-m-d\TH:i:s\Z');
                break;
            case 'Month':
                $startDate = \Carbon\Carbon::now()->addMonth()->format('Y-m-d\TH:i:s\Z');
                break;
            case 'Year':
                $startDate = \Carbon\Carbon::now()->addYear()->format('Y-m-d\TH:i:s\Z');
                break;
            default:
                $startDate = \Carbon\Carbon::now()->addMinutes(5)->format('Y-m-d\TH:i:s\Z');
                break;
        }

        $url = "https://api.paypal.com/v1/billing/subscriptions";
        // $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);;
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            'Accept: application/json',
            'Authorization: '."Bearer ". $accessToken,
            'PayPal-Request-Id: '."SUBSCRIPTION-".$startDate,
            'Prefer: return=representation',
            'Content-Type: application/json',
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = array(
            'plan_id' => $package->pay_plan_id,
            'start_time' => $startDate,
            'subscriber' => array(
                'name' => array(
                    'given_name' => $apiUser->last_name,
                    'surname' => $apiUser->first_name
                ),
                'email_address' => $apiUser->email
            ),
            'application_context' => array(
                'brand_name' => 'Tuning Service Subscription',
                'locale' => 'en-UK',
                'shipping_preference' => 'SET_PROVIDED_ADDRESS',
                'user_action' => 'SUBSCRIBE_NOW',
                'payment_method' => array(
                    'payer_selected' => 'PAYPAL',
                    'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                ),
                'return_url' => route('frontend.subscription.execute').'?success=true&apiuser='.$apiUser->id,
                'cancel_url' => route('frontend.subscription.execute').'?success=false&apiuser='.$apiUser->id,
            )
        );

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        $respObj = json_decode($resp);
        return redirect()->away($respObj->links[0]->href);
    }

    public function executeSubscription (Request $request) {
        if ($request->has('success') && $request->query('success') == 'true') {
            $id = $request->subscription_id;
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

            $subscriptionDetail = json_decode($resp);
            $currencySymbol = '£';

            try {
                $apiReg = ApiUserReg::find($request->apiuser);
                $apiUser = ApiUser::create([
                    'first_name' => $apiReg->first_name,
                    'last_name' => $apiReg->last_name,
                    'email' => $apiReg->email,
                    'password' => $apiReg->password,
                    'phone' => $apiReg->phone,
                    'company' => $apiReg->company,
                    'domain' => $apiReg->domain,
                    'api_token' => $apiReg->api_token,
                    'body_default' => 1,
                ]);
                // Execute agreement
                $subscription = new ApiSubscription();
                $subscription->user_id = $apiUser->id;
                $subscription->pay_agreement_id = $id;
                $subscription->description = 'Amount: '.$currencySymbol.round($subscriptionDetail->billing_info->last_payment->amount->value);
                $subscription->start_date = \Carbon\Carbon::parse($subscriptionDetail->start_time)->format('Y-m-d H:i:s');
                $subscription->status = $subscriptionDetail->status;
                $subscription->save();
                session(['api_token' => $apiUser->api_token]);
                // \Alert::success(__('admin.company_subscribed'))->flash();
            } catch (\Exception $ex) {
                // \Alert::error($ex->getMessage())->flash();
                dd($ex);
            }
        }else {
            // \Alert::error(__('admin.company_not_subscribed'))->flash();
        }
        return redirect()->route('frontend.api.dashboard');
    }

    public function getAccessToken() {
        $ch = curl_init();

        $company = \App\Models\Company::where('is_default', 1)->first();
        if(!$company) return;

        $clientId = $company->paypal_client_id;
        $secret = $company->paypal_secret;

        // $clientId = "AdibmcjffSYZR9TSS5DuKIQpnf80KfY-3pBGd30JKz2Ar1xHIipwijo4eZOJvbDCFpfmOBItDqZoiHmM";
        // $secret = "EEPRF__DLqvkwnnpi2Hi3paQ-9SZFRqypUH-u0fr4zAzvv7hWtz1bJHF0CEwvrvZpHyLeKSTO_FwAeO_";

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
}
