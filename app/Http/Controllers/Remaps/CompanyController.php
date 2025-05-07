<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

use App\Mail\CompanyActivateEmail;
use App\Mail\WelcomeCustomer;
use App\Models\User;
use App\Models\Company;
use App\Http\Controllers\MasterController;
use App\Http\Requests\CompanyRequest;
use App\Jobs\SendMail;
use Illuminate\Support\Facades\Log;
use App\Services\PleskService;
use App\Services\PleskRestService;

class CompanyController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


      // set up DNS A record for the domain==========================<
      // $pleskRestService = new PleskRestService();
      // $result = $pleskRestService->addDomain('tenssengineer12.com', '217.40.29.235');
      // Log::info('result');
      // Log::info($result);
      // set up DNS A record for the domain========================== />
        $this->check_master();
        $user = $this->user;
        $entries = Company::where('id', '!=', $user->company->id)
            ->whereHas('owner', function($query) use($user){
                $query->where('is_verified', 1);
            })->orderBy('id', 'DESC')->paginate(20);
        return view('pages.company.index', [
            'entries' => $entries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->check_master();
        $entry = new Company;
        return view('pages.company.edit', [
            'entry' => $entry
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = Request::capture();
        switch($request->tab){
            case 'name':
                $validator = Validator::make($request->only(['name', 'country', 'state', 'town', 'address_line_1', 'address_line_2', 'post_code', 'logo', 'theme_color', 'copy_right_text']),[
                    'name' => 'bail|required|string|max:100',
                    'address_line_1'=> 'bail|required|string|max:100',
                    'address_line_2'=> 'bail|nullable|string|max:100',
                    'town'=> 'bail|required|string|max:50',
                    'post_code'=> 'bail|nullable|string|max:30',
                    'country'=> 'bail|required|string|max:50',
                    'state'=> 'bail|nullable|string|max:50',
					//'rating'=> 'bail|nullable|string|max:50',
                    'file'=> 'bail|nullable|image|mimes:jpg,png,jpeg',
                    'copy_right_text'=> 'bail|nullable|string|max:100'
                ]);

                $requestData->replace($request->only(['name', 'country', 'state', 'town', 'address_line_1', 'address_line_2', 'post_code', 'logo', 'theme_color', 'copy_right_text']));
                break;
            case 'domain':
                $validator = Validator::make($request->only('v2_domain_link'), [
                    'v2_domain_link'=> 'bail|required|url|unique:companies,v2_domain_link|max:100'
                ]);
                $requestData->replace($request->only('v2_domain_link'));
                break;
            case 'email':
                // 'main_email_address'=> 'bail|required|email|unique:companies,main_email_address,'.$company->id.'|unique:users,email,'.$company->owner->id.'|max:100',
                $validator = Validator::make($request->only(['main_email_address', 'support_email_address', 'billing_email_address']), [
                    'main_email_address'=> 'bail|required|email|unique:companies,main_email_address|max:100',
                    'support_email_address'=> 'bail|nullable|email|max:100',
                    'billing_email_address'=> 'bail|nullable|email|max:100'
                ]);
                $requestData->replace($request->only(['main_email_address', 'support_email_address', 'billing_email_address']));
                break;
            case 'finance':
                $validator = Validator::make($request->only(['bank_account', 'bank_identification_code', 'vat_number', 'vat_percentage']), [
                    'bank_account'=> 'bail|nullable|string|max:100',
                    'bank_identification_code'=> 'bail|nullable|string|max:100',
                    'vat_number'=> 'bail|nullable|string|max:100',
                    'vat_percentage'=> 'bail|nullable|required_with:vat_number|regex:/^\d*(\.\d{1,2})?$/|max:8'
                ]);
                $requestData->replace($request->only(['bank_account', 'bank_identification_code', 'vat_number', 'vat_percentage']));
                break;
            case 'note':
                $validator = Validator::make($request->only('customer_note'), [
                    'customer_note'=> 'bail|nullable|string',
                ]);
                $requestData->replace($request->only('customer_note'));
                break;

            case 'smtp':
                $validator = Validator::make($request->only(['mail_host', 'mail_port', 'mail_username', 'mail_password']), [
                    'mail_driver'=> 'bail|nullable|string|max:20',
                    'mail_host'=> 'bail|nullable|string|max:100',
                    'mail_port'=> 'bail|nullable|integer',
                    'mail_username'=> 'bail|nullable|email|max:100',
                    'mail_password'=> 'bail|nullable|string|max:100'
                ]);
                $requestData->replace($request->only(['mail_host', 'mail_port', 'mail_username', 'mail_password']));
                break;
            case 'paypal':
                $validator = Validator::make($request->only(['paypal_client_id', 'paypal_secret', 'paypal_currency_code']), [
                    'paypal_client_id'=> 'bail|nullable|string|max:200',
                    'paypal_secret'=> 'bail|nullable|string|max:200',
                    'paypal_currency_code'=> 'bail|nullable|string|max:10'
                ]);
                $requestData->replace($request->only(['paypal_client_id', 'paypal_secret', 'paypal_currency_code']));
                break;
            case 'stripe':
                $validator = Validator::make($request->only(['stripe_key', 'stripe_secret']), [
                    'stripe_key'=> 'bail|nullable|string|max:200',
                    'stripe_secret'=> 'bail|nullable|string|max:200',
                ]);
                $requestData->replace($request->only(['id', 'stripe_key', 'stripe_secret']));
                break;
            default:
                break;
        }

        if ($validator->fails()) {
            return redirect(route('companies.create', ['tab' => $request->tab]))
                        ->withErrors($validator)
                        ->withInput();
        }
        try {
            if($request->hasFile('upload_file')){
                if($request->file('upload_file')->isValid()){
                    $file = $request->file('upload_file');
                    $res = Storage::disk('azure')->put('logo', $file);
                    $request->request->add(['logo' => $res]);
                }
            }
            $company = Company::create($request->all());
            if($company->owner == NULL){
                if($company->name && $company->main_email_address && $company->address_line_1 && $company->town && $company->country && $company->v2_domain_link) {
                    $companyUser = new User();
					$companyUser->company_id = $company->id;
					$companyUser->tuning_credit_group_id = Null;
					$companyUser->first_name = $request->name;
					$companyUser->last_name = $request->name;
					$companyUser->lang = 'en';
					$companyUser->email = $request->main_email_address;
					$companyUser->business_name = $request->name;
					$companyUser->address_line_1 = $request->address_line_1;
					$companyUser->address_line_2 = $request->address_line_2;
					$companyUser->county = $request->country;
					$companyUser->town = $request->town;
					$companyUser->post_code = $request->post_code;
					$companyUser->is_master = 0;
					$companyUser->is_admin = 1;
                    if($companyUser->save()){
                        $emailTemplates = \App\Models\EmailTemplate::where('company_id', $this->company->id)
                            ->whereIn('label', [
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
						$token = app('auth.password.broker')->createToken($companyUser);
                        $this->setCompanyMailSender();
						try{
                            SendMail::dispatch($companyUser->email, new WelcomeCustomer($companyUser, $token), $this->company, 'Create a new customer');
                            // Mail::to($companyUser->emai)->send(new WelcomeCustomer($companyUser, $token));
						}catch(\Exception $e) {
                            session()->flash('error', $e->getMessage());
						}
					}
                }
            }
            if(!($company->name && $company->address_line_1 && $company->town && $company->country)) {
                session()->flash('warning', 'Please update company name and address in order to complete company registration.');
                return redirect(route('companies.edit', ['company' => $company->id, 'tab' => 'name']));
            }

            if(!$company->v2_domain_link) {
                session()->flash('warning', 'Please update company domain in order to complete company registration.');
                return redirect(route('companies.edit', ['company' => $company->id, 'tab' => 'domain']));
            }

            if(!$company->main_email_address){
                session()->flash('warning', 'Please update company main email address in order to complete company registration.');
                return redirect(route('companies.edit', ['company' => $company->id, 'tab' => 'email']));
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
            return redirect(route('companies.create'));
        }

        return redirect(route('companies.edit', ['company'=> $company->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->check_master();
        $entry = Company::find($id);
        return view('pages.company.edit', [
            'entry' => $entry
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = Request::capture();
        $company = Company::find($id);
        switch($request->tab){
            case 'name':
                $validator = Validator::make($request->only(['name', 'country', 'state', 'town', 'address_line_1', 'address_line_2', 'post_code', 'logo', 'theme_color', 'copy_right_text']),[
                    'name' => 'bail|required|string|max:100',
                    'address_line_1'=> 'bail|required|string|max:100',
                    'address_line_2'=> 'bail|nullable|string|max:100',
                    'town'=> 'bail|required|string|max:50',
                    'post_code'=> 'bail|nullable|string|max:30',
                    'country'=> 'bail|required|string|max:50',
                    'state'=> 'bail|nullable|string|max:50',
					//'rating'=> 'bail|nullable|string|max:50',
                    'file'=> 'bail|nullable|image|mimes:jpg,png,jpeg',
                    'copy_right_text'=> 'bail|nullable|string|max:100'
                ]);

                $requestData->replace($request->only(['name', 'country', 'state', 'town', 'address_line_1', 'address_line_2', 'post_code', 'logo', 'theme_color', 'copy_right_text']));
                break;
            case 'domain':
                $validator = Validator::make($request->only('v2_domain_link'), [
                    'v2_domain_link'=> 'bail|required|url|unique:companies,v2_domain_link,'.$company->id.'|max:100'
                ]);
                $requestData->replace($request->only('v2_domain_link'));
                break;
            case 'email':
                $validator = Validator::make($request->only(['main_email_address', 'support_email_address', 'billing_email_address']), [
                    'main_email_address'=> 'bail|required|email|unique:companies,main_email_address,'.$company->id.'|max:100',
                    'support_email_address'=> 'bail|nullable|email|max:100',
                    'billing_email_address'=> 'bail|nullable|email|max:100'
                ]);
                $requestData->replace($request->only(['main_email_address', 'support_email_address', 'billing_email_address']));
                break;
            case 'finance':
                $validator = Validator::make($request->only(['bank_account', 'bank_identification_code', 'vat_number', 'vat_percentage']), [
                    'bank_account'=> 'bail|nullable|string|max:100',
                    'bank_identification_code'=> 'bail|nullable|string|max:100',
                    'vat_number'=> 'bail|nullable|string|max:100',
                    'vat_percentage'=> 'bail|nullable|required_with:vat_number|regex:/^\d*(\.\d{1,2})?$/|max:8'
                ]);
                $requestData->replace($request->only(['bank_account', 'bank_identification_code', 'vat_number', 'vat_percentage']));
                break;
            case 'note':
                $validator = Validator::make($request->only('customer_note'), [
                    'customer_note'=> 'bail|nullable|string',
                ]);
                $requestData->replace($request->only('customer_note'));
                break;

            case 'smtp':
                $validator = Validator::make($request->only(['mail_host', 'mail_port', 'mail_username', 'mail_password']), [
                    'mail_driver'=> 'bail|nullable|string|max:20',
                    'mail_host'=> 'bail|nullable|string|max:100',
                    'mail_port'=> 'bail|nullable|integer',
                    'mail_username'=> 'bail|nullable|email|max:100',
                    'mail_password'=> 'bail|nullable|string|max:100'
                ]);
                $requestData->replace($request->only(['mail_host', 'mail_port', 'mail_username', 'mail_password']));
                break;
            case 'paypal':
                $validator = Validator::make($request->only(['paypal_client_id', 'paypal_secret', 'paypal_currency_code']), [
                    'paypal_client_id'=> 'bail|nullable|string|max:200',
                    'paypal_secret'=> 'bail|nullable|string|max:200',
                    'paypal_currency_code'=> 'bail|nullable|string|max:10'
                ]);
                $requestData->replace($request->only(['paypal_client_id', 'paypal_secret', 'paypal_currency_code']));
                break;
            case 'stripe':
                $validator = Validator::make($request->only(['stripe_key', 'stripe_secret']), [
                    'stripe_key'=> 'bail|nullable|string|max:200',
                    'stripe_secret'=> 'bail|nullable|string|max:200',
                ]);
                $requestData->replace($request->only(['id', 'stripe_key', 'stripe_secret']));
                break;
            default:
                break;
        }

        if ($validator->fails()) {
            return redirect(route('companies.edit', ['tab' => $request->tab, 'company' => $id]))
                        ->withErrors($validator)
                        ->withInput();
        }
        try {
            $entry = Company::find($id);
            if($request->hasFile('upload_file')){
                if($request->file('upload_file')->isValid()){
                    $file = $request->file('upload_file');
                    $res = Storage::disk('azure')->put('logo', $file);
                    $request->request->add(['logo' => $res]);
                }
            }
            $tab = $request->tab;
            $entry->update($request->all());

            if($entry->owner == NULL){
                /* register company owner*/
                if($entry->name && $entry->main_email_address && $entry->address_line_1 && $entry->town && $entry->country && $entry->v2_domain_link){
                    $companyUser = new User();
                    $companyUser->company_id = $entry->id;
                    $companyUser->tuning_credit_group_id = Null;
                    $companyUser->first_name = $request->name;
                    $companyUser->last_name = $request->name;
                    $companyUser->lang = 'en';
                    $companyUser->email = $request->main_email_address;
                    $companyUser->business_name = $request->name;
                    $companyUser->address_line_1 = $request->address_line_1;
                    $companyUser->address_line_2 = $request->address_line_2;
                    $companyUser->county = $request->country;
                    $companyUser->town = $request->town;
                    $companyUser->post_code = $request->post_code;
                    $companyUser->is_master = 0;
                    $companyUser->is_admin = 1;
                    if($companyUser->save()){
                        $emailTemplates = \App\Models\EmailTemplate::where('company_id', $this->company->id)
                            ->whereIn('label', [
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
                                $userTemplate->company_id = $entry->id;
                                $userTemplate->save();
                            }
                        }
                        $token = app('auth.password.broker')->createToken($companyUser);
                        $this->setCompanyMailSender();
                        try{
                            SendMail::dispatch($companyUser->email, new WelcomeCustomer($companyUser, $token), $this->company, 'Create a new customer');
                            // Mail::to($companyUser->email)->send(new WelcomeCustomer($companyUser, $token));
                        }catch(\Exception $e){
                            session()->flash('error', $e->getMessage());
                        }
                    }
                }
            } else {
                $companyOwner = $entry->owner;
                $companyOwner->email = $request->main_email_address;
                $companyOwner->save();
            }

            if(!($entry->name && $entry->address_line_1 && $entry->town && $entry->country)) {
                session()->flash('warning', 'Please update company name and address in order to complete company registration.');
                return redirect(route('companies.edit', ['company' => $entry->id, 'tab' => 'name']));
            }

            if(!$entry->v2_domain_link) {
                session()->flash('warning', 'Please update company domain in order to complete company registration.');
                return redirect(route('companies.edit', ['company' => $entry->id, 'tab' => 'domain']));
            }

            if(!$entry->main_email_address){
                session()->flash('warning', 'Please update company main email address in order to complete company registration.');
                return redirect(route('companies.edit', ['company' => $entry->id, 'tab' => 'email']));
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }

        return redirect(route('companies.edit', ['company' => $id, 'tab' => $tab]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->owner->delete();
        $company->delete();
        return redirect(route('companies.index'));
    }

    public function activate($id)
    {
        $this->check_master();
        $company = Company::find($id);
		$companyUser = $company->owner;
        if($companyUser->is_active ==1){
			$companyUser->is_active = 0;
			$companyUser->save();
		}else{
			$companyUser->is_active = 1;
			$companyUser->save();
			$token = app('auth.password.broker')->createToken($companyUser);
            session()->flash('message', 'Comapny has been activated successfully.');
            $this->setCompanyMailSender();
			try{
                SendMail::dispatch($companyUser->email, new CompanyActivateEmail($companyUser, $token), $this->company, 'Activate Company');
                // Mail::to($companyUser->email)->send(new CompanyActivateEmail($companyUser, $token));
			}catch(\Exception $e){
                // dd($e);
                session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
			}
		}
        return redirect(route('companies.index'));
    }

    public function resendPasswordResetLink($id){
        $this->check_master();
        $company = Company::find($id);
        $this->setCompanyMailSender();
        try {
            $user = $company->owner;
            $token = app('auth.password.broker')->createToken($user);
            SendMail::dispatch($user->email, new WelcomeCustomer($user, $token), $this->company, 'Send reset password link');
            // Mail::to($user->email)->send(new WelcomeCustomer($user, $token));
            session()->flash('message', __('admin.password_reset_link_send'));
        } catch(\Exception $e){
            session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
        }
        return redirect(route('companies.index'));
    }

    public function public($id)
    {
        $this->check_master();
        $company = Company::find($id);
		if($company->is_public == 1){
			$company->is_public = 0;
		} else {
			$company->is_public = 1;
		}
		$company->Save();
        return redirect(route('companies.index'));
    }

    public function switchAsCompany($id){
        $this->check_master();
        $company = Company::find($id);
        $user = $company->users()->where('is_master', 0)->where('is_admin', 1)->first();
        if($user){
            Auth::guard('admin')->login($user);
            return redirect()->away($user->company->v2_domain_link.'/admin/dashboard');
        }
    }

    public function trial($id) {
        $this->check_master();
        $subscriptions = Company::find($id)->owner->subscriptions->sortByDesc('id');
        return view('pages.company.trial', compact('id', 'subscriptions'));
    }

    public function trial_post(Request $request, $id) {
        try{
            $validations = Validator::make($request->all(), [
                'description' => 'max:191',
                'trial_days' => 'required|numeric'
            ]);
            $company = Company::find($id);
            if(!$validations->fails()){
                 $subscription = new \App\Models\Subscription();
                 $subscription->user_id = $company->owner->id;
                 $subscription->start_date = date("Y-m-d h:i:s");
                 $subscription->trial_days = $request['trial_days'];
                 $subscription->description = $request['description'];
                 $subscription->pay_agreement_id = 'TRIAL'.rand(11111111, 99999999);
                 $subscription->status = 'Active';
                 $subscription->is_trial = 1;
                 if($subscription->save()){
                    session()->flash('success', __('admin.subscription_saved'));
                    return redirect(route('companies.trial', ['id' => $id]))->withInput($request->all());
                 }else{
                    session()->flash('error', __('admin.opps'));
                     return redirect()->back()->withInput($request->all());
                 }
            }else{
                return redirect()->back()->withInput($request->all())->withErrors($validations->errors());
            }
         }catch(\Exception $e){
            session()->flash('error', __('admin.opps'));
            return redirect()->back()->withInput($request->all());
         }
    }

    public function reset_twofa_key(Request $request, $id) {
        $company = Company::find($id);
        $company->secret_2fa_key = NULL;
        $company->secret_2fa_verified = NULL;
        $company->save();
        return redirect(route('companies.index'));
    }

    public function auto_accept(Request $request, $id) {
        $company = Company::find($id);
        $company->update($request->all());
        return redirect()->back();
    }

    public function enable_forum($id, $fid) {
        $company = Company::find($id);
        $company->is_forum_enabled = 1;
        $company->forum_id = $fid;
        $company->save();
        return redirect(route('companies.index'));
    }

    public function disable_forum($id) {
        $company = Company::find($id);
        $company->is_forum_enabled = 0;
        $company->forum_id = NULL;
        $company->save();
        return redirect(route('companies.index'));
    }

    public function setCompanyMailSender() {
        $master = Company::where('is_default', 1)->first();
        Config::set('mail.default', $master->mail_driver);
        Config::set('mail.mailers.smtp.host', $master->mail_host);
        Config::set('mail.mailers.smtp.port', $master->mail_port);
        Config::set('mail.mailers.smtp.encryption', $master->mail_encryption);
        Config::set('mail.mailers.smtp.username', $master->mail_username);
        Config::set('mail.mailers.smtp.password', $master->mail_password);
        Config::set('mail.from.address', $master->main_email_address);
    }

    /**
     * set up DNS A record for the domain
     */
    public function setupDNSARecordTest($domain) {
        try {
          $pleskUri = config('plesk.base_url');
          $pleskUsername = config('plesk.username');
          $pleskPassword = config('plesk.password');
          $targetIp = config('plesk.target_ip');

            Log::info('Testing Plesk API connection...');
            Log::info('Plesk URI: ' . $pleskUri);
            Log::info('Username configured: ' . ($pleskUsername ? 'Yes' : 'No'));
            Log::info($pleskUsername);
            Log::info('Password configured: ' . ($pleskPassword ? 'Yes' : 'No'));
            Log::info($pleskPassword);
            Log::info('Target IP: ' . $targetIp);

            if (!$pleskUsername || !$pleskPassword) {
                throw new \Exception('Plesk credentials are not configured in .env file');
            }

            $client = new \GuzzleHttp\Client([
                'base_uri' => $pleskUri,
                'auth' => [$pleskUsername, $pleskPassword],
                'verify' => false, 
                'timeout' => 30,
                'http_errors' => false,
            ]);

            $response = $client->request('GET', 'enterprise/control/agent.php', [
                'headers' => [
                    'Content-Type' => 'text/xml',
                ],
            ]);

            Log::info('API Response Status: ' . $response->getStatusCode());
            Log::info('API Response Body: ' . $response->getBody());

            if ($response->getStatusCode() === 200) {
                Log::info('Successfully connected to Plesk API');
                return true;
            } else {
                throw new \Exception('Failed to connect to Plesk API. Status: ' . $response->getStatusCode());
            }

        } catch (\Exception $e) {
            Log::error('Plesk API Connection Error: ' . $e->getMessage());
            throw $e;
        }
    }


    public function setupDNSARecord($domain) {
        try {
            $pleskUri = env('PLESK_URI', 'https://apthosting.uk:8443');
            $pleskUsername = env('PLESK_USERNAME');
            $pleskPassword = env('PLESK_PASSWORD');
            $targetIp = env('TARGET_IP', '217.40.29.235');

            Log::info('Starting DNS A record setup for domain: ' . $domain);
            Log::info('Plesk URI: ' . $pleskUri);
            Log::info('Target IP: ' . $targetIp);

            if (!$pleskUsername || !$pleskPassword) {
                throw new \Exception('Plesk credentials are not configured');
            }

            // First check if domain exists in Plesk
            $checkDomainXml = '<?xml version="1.0" encoding="UTF-8"?>
<packet>
  <site>
    <get>
      <filter>
        <name>' . htmlspecialchars($domain) . '</name>
      </filter>
    </get>
  </site>
</packet>';

            $client = new \GuzzleHttp\Client([
                'base_uri' => $pleskUri,
                'auth' => [$pleskUsername, $pleskPassword],
                'verify' => false,
                'timeout' => 30,
                'http_errors' => false,
            ]);

            // Check if domain exists
            $checkResponse = $client->request('POST', 'enterprise/control/agent.php', [
                'body' => $checkDomainXml,
                'headers' => [
                    'Content-Type' => 'text/xml',
                ],
            ]);

            $checkResult = simplexml_load_string($checkResponse->getBody());
            if ($checkResult === false || !isset($checkResult->site->get->result)) {
                throw new \Exception('Failed to check domain existence in Plesk');
            }

            if (empty($checkResult->site->get->result)) {
                throw new \Exception('Domain ' . $domain . ' does not exist in Plesk');
            }

            // Add DNS A record
            $xmlPayload = '<?xml version="1.0" encoding="UTF-8"?>
<packet>
  <dns>
    <add_rec>
      <site-name>' . htmlspecialchars($domain) . '</site-name>
      <type>A</type>
      <value>' . htmlspecialchars($targetIp) . '</value>
      <ttl>3600</ttl>
    </add_rec>
  </dns>
</packet>';

            $response = $client->request('POST', 'enterprise/control/agent.php', [
                'body' => $xmlPayload,
                'headers' => [
                    'Content-Type' => 'text/xml',
                ],
            ]);

            $responseBody = $response->getBody();
            Log::info('Plesk API Response: ' . $responseBody);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Failed to add DNS record. Status: ' . $response->getStatusCode() . ', Response: ' . $responseBody);
            }

            // Verify DNS record was added
            $verifyXml = '<?xml version="1.0" encoding="UTF-8"?>
<packet>
  <dns>
    <get_rec>
      <filter>
        <site-name>' . htmlspecialchars($domain) . '</site-name>
        <type>A</type>
      </filter>
    </get_rec>
  </dns>
</packet>';

            $verifyResponse = $client->request('POST', 'enterprise/control/agent.php', [
                'body' => $verifyXml,
                'headers' => [
                    'Content-Type' => 'text/xml',
                ],
            ]);

            $verifyResult = simplexml_load_string($verifyResponse->getBody());
            if ($verifyResult === false || !isset($verifyResult->dns->get_rec->result)) {
                throw new \Exception('Failed to verify DNS record addition');
            }

            if (empty($verifyResult->dns->get_rec->result)) {
                throw new \Exception('DNS A record was not added successfully');
            }

            Log::info('DNS A record added and verified successfully for domain: ' . $domain);
            return true;

        } catch (\Exception $e) {
            Log::error('Failed to setup DNS A record: ' . $e->getMessage());
            throw $e;
        }
    }
}
