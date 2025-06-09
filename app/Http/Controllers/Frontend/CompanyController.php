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
use App\Models\CompanyReg;
use App\Models\TuningCreditGroup;
use App\Models\Package;
use App\Models\TuningType;
use App\Models\TuningTypeOption;
use App\Models\TuningTypeGroup;
use App\Models\TuningCreditTire;
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
use App\Services\PleskService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Svg\Tag\Rect;

class CompanyController extends Controller
{

  protected $base_url_sandbox = "https://api-m.sandbox.paypal.com";
  protected $base_url_production = "https://api.paypal.com";
  protected $environment;

  public function __construct()
  {
    // $this->environment = 'development'; // development
    $this->environment = 'production'; // production
  }

  public function getAccessToken() {
    $ch = curl_init();

    $company = \App\Models\Company::where('is_default', 1)->first();
    if(!$company) return;

    $clientId = $this->environment == 'development' ? $company->paypal_client_id_development : $company->paypal_client_id;
    $secret = $this->environment == 'development' ? $company->paypal_secret_development : $company->paypal_secret;

    $base_url = $this->environment == 'development' ? $this->base_url_sandbox : $this->base_url_production;
    $api_url = $base_url."/v1/oauth2/token";

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
  public function create(){
		$company = Company::all();
		return view('Frontend.create',compact('company'));
  }

  public function submitRegisterCompanyWithPaypal(CompanyRegisterFront $request){
    // 1. save company register data to CompanyReg table
    if($request->hasFile('upload_file')){ // Handle logo upload
      if($request->file('upload_file')->isValid()){
        $file = $request->file('upload_file');
        $logo = Storage::disk('azure')->put('logo', $file);
        $request->merge(['logo' => $logo]);
      }
    }

    $companyReg = new \App\Models\CompanyReg();
    $companyReg->fill($request->all());
    $companyReg->save();

    $package = $this->environment == 'development'? Package::find(22): Package::find(21);

    // 2. create paypal subscription
    $planId = $package->pay_plan_id;
    $accessToken = $this->getAccessToken();

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

    $headers = array(
      'Accept: application/json',
      'Authorization: '."Bearer ". $accessToken,
      'PayPal-Request-Id: '."SUBSCRIPTION-".$startDate,
      'Prefer: return=representation',
      'Content-Type: application/json',
    );
    
    $data = [
        'plan_id' => $planId,
        'subscriber' => [
            'name' => [
                'given_name' => $request->name,
                'surname' => $request->name
            ],
            'email_address' => $request->main_email_address
        ],
        'application_context' => [
          'brand_name' => 'Tuning Service Subscription',
          'locale' => 'en-UK',
          'shipping_preference' => 'SET_PROVIDED_ADDRESS',
          'user_action' => 'SUBSCRIBE_NOW',
          'payment_method' => array(
              'payer_selected' => 'PAYPAL',
              'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
          ),
          'return_url' => route('excute.subscription.register.company', ['success' => 'true', 'company_reg_id' => $companyReg->id]),
          'cancel_url' => route('excute.subscription.register.company', ['success' => 'false', 'company_reg_id' => $companyReg->id]),
        ]
    ];

    $base_url = $this->environment == 'development' ? $this->base_url_sandbox : $this->base_url_production;
    $url = $base_url."/v1/billing/subscriptions";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);

    $respObj = json_decode($resp, true);
    Log::info('====== paypal response ====== >');
    Log::info($respObj);

    // 3. redirect to approve_url
    if (isset($respObj['links'])) {
        foreach ($respObj['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return redirect()->away($link['href']);
            }
        }
    }
    // if failed, handle error
    return redirect()->back()->with('error', 'PayPal subscription creation failed.');
  }

  public function excuteSubscriptionRegisterCompany(Request $request){
    if ($request->has('success') && $request->query('success') == 'true') {
      $companyRegisterData = CompanyReg::find($request->query('company_reg_id'));

      // ======================================= create company ======================================= < 
      $company = new \App\Models\Company();
      $company->name = $companyRegisterData->name;
      $company->main_email_address = $companyRegisterData->main_email_address;

      if ($companyRegisterData->own_domain !== null && $companyRegisterData->own_domain !== '') {
        $company->v2_domain_link = $companyRegisterData->own_domain;
        $urlWithDomain = $companyRegisterData->own_domain;

        if($this->environment == 'development'){
          $company->v2_domain_link = $urlWithDomain;
        } else {
        // ============ add domain to plesk automatically ============ <
          $domainHost = parse_url($urlWithDomain, PHP_URL_HOST);
          $pleskService = new PleskService();
          $responseDomain = $pleskService->addDomain($domainHost);
          if (empty($responseDomain)) {
            Log::error('Plesk response is empty!');
            return redirect()->back()->with('error', 'no response from plesk');
          }
          libxml_use_internal_errors(true);
          $responseXml = simplexml_load_string($responseDomain);
          if ($responseXml === false) {
            $errors = libxml_get_errors();
            $errorMessage = "XML Parse Error: ";
            foreach ($errors as $error) {
                $errorMessage .= trim($error->message) . ' ';
            }
            Log::error('XML Parse Error: ' . $errorMessage);
            return redirect()->back()->with('error', $errorMessage);
          }
          $status = (string) $responseXml->site->add->result->status;
          if ($status === 'ok') {
            $company->v2_domain_link = $urlWithDomain;
          } else {
            $errText = (string) $responseXml->site->add->result->errtext;
            Log::info('====== add domain error ====== >');
            Log::info($errText);
            return redirect()->back()->with('error', $errText);
          }
          // ============ add domain to plesk automatically ============ />
        }
      } else {
        $company->v2_domain_link = 'https://'.$companyRegisterData->v2_domain_link;
      }

      $company->address_line_1 = $companyRegisterData->address_line_1;
      $company->address_line_2 = $companyRegisterData->address_line_2;
      $company->town = $companyRegisterData->town;
      $company->country = $companyRegisterData->country;
      $company->vat_number = $companyRegisterData->vat_number;
      $company->logo = $companyRegisterData->logo;
      // ======================================= create company ======================================= />

      if($company->save()){
        // ======================================= create user ======================================= <
        $companyUser = new \App\Models\User();
        $companyUser->company_id = $company->id;
        $companyUser->tuning_credit_group_id = Null;
        $companyUser->first_name =  $companyRegisterData->name;
        $companyUser->last_name = $companyRegisterData->name;
        $companyUser->lang = 'en';
        $companyUser->email = $companyRegisterData->main_email_address;
        $companyUser->password =  Hash::make($companyRegisterData->password);
        $companyUser->business_name =  $companyRegisterData->name;
        $companyUser->address_line_1 =  $companyRegisterData->address_line_1;
        $companyUser->address_line_2 =  $companyRegisterData->address_line_2;
        $companyUser->county =  $companyRegisterData->country;
        $companyUser->town =  $companyRegisterData->town;
        $companyUser->is_master = 0;
        $companyUser->is_admin = 1;
        $companyUser->is_active = 0;
        $companyUser->is_verified = 0;
        $companyUser->save();
        // ======================================= create user ======================================= />

        // ======================================= save subscription detail ======================================= <
        $id = $request->subscription_id;
        $base_url = $this->environment == 'development' ? $this->base_url_sandbox : $this->base_url_production;
        $url = $base_url."/v1/billing/subscriptions/{$id}";

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
        Log::info('====== paypal response ====== >');
        Log::info($resp);
        
        curl_close($curl);

        $subscriptionDetail = json_decode($resp);

        $company = \App\Models\Company::where('is_default', 1)->first();
        $currencySymbol = \App\Helpers\Helper::getCurrencySymbol($company->paypal_currency_code);

        try {
            // Execute agreement
            $subscription = new \App\Models\Subscription();
            $subscription->user_id = $companyUser->id;
            $subscription->pay_agreement_id = $id;
            // $subscription->description = 'Amount: '.$currencySymbol.round($subscriptionDetail->billing_info->last_payment->amount->value);
            $subscription->description = 'Set up fee (£150) + Monthly subscription (£59)';
            $subscription->start_date = \Carbon\Carbon::parse($subscriptionDetail->start_time)->format('Y-m-d H:i:s');
            $subscription->status = $subscriptionDetail->status;
            $subscription->save();
            // \Alert::success(__('admin.company_subscribed'))->flash();
        } catch (\Exception $ex) {
            // \Alert::error($ex->getMessage())->flash();
        }
        // ======================================= save subscription detail ======================================= />

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
        // default email templates
        if($emailTemplates->count() > 0){
          foreach($emailTemplates as $emailTemplate){
            $userTemplate = $emailTemplate->replicate();
            $userTemplate->company_id = $company->id;
            $userTemplate->save();
          }
        }

        // default tuning type
        $sampleTT = TuningType::create([
          'company_id'=> $company->id,
          'label' => 'Sample Tuning Type',
          'credits' => 1,
          'order_as' => TuningType::where('company_id', $company->id)->count() + 1,
        ]);
        // default tuning type option
        $sampleTTO = TuningTypeOption::create([
          'tuning_type_id'=> $sampleTT->id,
          'label' => 'Sample Option',
          'tooltip' => 'This is a sample one',
          'credits' => 0.33,
          'order_as' => TuningTypeOption::where('tuning_type_id', $sampleTT->id)->count()
        ]);
        // system default tuning type group
        $types = TuningType::where('company_id', $company->id)->get();
        $sync_types = [];
        $sync_options = [];
        foreach ($types as $t) {
          $sync_types[$t->id]['for_credit'] = $t->credits;
          $typeOptions = $t->tuningTypeOptions()->select('id', 'credits')->get();
          foreach ($typeOptions as $to) {
              $sync_options[$to->id] = [
                  'for_credit' => $to->credits
              ];
          }
        }

        $default = TuningTypeGroup::create([
          'company_id' => $company->id,
          'name' => "System Default",
          'is_system_default' => 1,
          'is_default' => 1
        ]);
        $default->tuningTypes()->sync($sync_types);
        $default->tuningTypeOptions()->sync($sync_options);
        // default credit tires
        $sampleTCT1 = TuningCreditTire::create([
          'company_id'=> $company->id,
          'amount' => 1,
          'group_type' => 'normal'
        ]);
        $sampleTCT2 = TuningCreditTire::create([
          'company_id'=> $company->id,
          'amount' => 2,
          'group_type' => 'normal'
        ]);
        $sampleTCT10 = TuningCreditTire::create([
          'company_id'=> $company->id,
          'amount' => 10,
          'group_type' => 'normal'
        ]);
        // default credit group
        $sampleTCG = TuningCreditGroup::create([
          'company_id'=> $company->id,
          'group_type' => 'normal',
          'name' => 'Sample Group',
          'is_default' => 1,
          'set_default_tier' => 1,
          'is_system_default' => 1
        ]);
        $credit_tires = [];
        $credit_tires[$sampleTCT1->id] = [
          'from_credit' => 50,
          'for_credit' => 50
        ];
        $credit_tires[$sampleTCT2->id] = [
          'from_credit' => 100,
          'for_credit' => 100
        ];
        $credit_tires[$sampleTCT10->id] = [
          'from_credit' => 500,
          'for_credit' => 400
        ];
        $sampleTCG->tuningCreditTires()->sync($credit_tires);
        $mainCompany = Company::where('id', '1')->first()->toArray();
        Config::set('mail.default', $mainCompany['mail_driver']);
        Config::set('mail.mailers.smtp.host', $mainCompany['mail_host']);
        Config::set('mail.mailers.smtp.port', $mainCompany['mail_port']);
        Config::set('mail.mailers.smtp.encryption', $mainCompany['mail_encryption']);
        Config::set('mail.mailers.smtp.username', $mainCompany['mail_username']);
        Config::set('mail.mailers.smtp.password', $mainCompany['mail_password']);
        Config::set('mail.from.address', $mainCompany['main_email_address']);
        Config::set('mail.from.name', $mainCompany['name']);
        Config::set('app.name', $mainCompany['name']);

        if($this->environment == 'production'){
          try{
            Mail::to($companyUser->email)->send(new CompanyEmailVerification($companyUser));
          }catch(\Exception $e){
            Log::error('Mail send failed: ' . $e->getMessage());
          }

          try{
            Mail::to($mainCompany['main_email_address'])->send(new NewCompanyApply($companyUser, $mainCompany));
          }catch(\Exception $e){
            Log::error('Mail send failed: ' . $e->getMessage());
          }
        }
        return redirect()->route('thankyou')->with('Regististration received, Please wait for your application to be processed');
      } else{
        return redirect()->route('register-account.create')->with('error', 'paypal subscription creation failed');
      }
    }
    else {
      return redirect()->route('register-account.create')->with('error', 'PayPal subscription creation failed.');
    }
  }

	public function thankyou(Request $request){
        if ($request->has('cve')) {
            $company = Company::find($request->cve);
            $company->owner->is_verified = 1;
            $company->owner->save();
        }

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
                'return_url' => route('frontend.api.subscription.execute').'?success=true&apiuser='.$apiUser->id,
                'cancel_url' => route('frontend.api.subscription.execute').'?success=false&apiuser='.$apiUser->id,
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

    public function executeApiSubscription (Request $request) {
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
}
