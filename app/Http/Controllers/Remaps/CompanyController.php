<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

use App\Mail\CompanyActivateEmail;
use App\Mail\WelcomeCustomer;
use App\Models\User;
use App\Models\Company;
use App\Http\Controllers\MasterController;
use App\Http\Requests\CompanyRequest;

class CompanyController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->check_master();
        $user = $this->user;
        $entries = Company::where('id', '!=', $user->company->id)->orderBy('id', 'DESC')->paginate(20);
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
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(storage_path('app/public/uploads/logo'), $filename);
                    $request->request->add(['logo' => $filename]);
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
							Mail::to($companyUser->email)->send(new WelcomeCustomer($companyUser, $token));
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
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(storage_path('app/public/uploads/logo'), $filename);
                    $request->request->add(['logo' => $filename]);
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
                            Mail::to($companyUser->email)->send(new WelcomeCustomer($companyUser, $token));
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
        Company::find($id)->delete();
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
            	Mail::to($companyUser->email)->send((new CompanyActivateEmail($companyUser, $token)));
			}catch(\Exception $e){
                dd($e);
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
            Mail::to($user->email)->send(new WelcomeCustomer($user, $token));
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

    public function setCompanyMailSender() {
        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.host', 'mail.remapdash.com');
        Config::set('mail.mailers.smtp.port', 25);
        Config::set('mail.mailers.smtp.encryption', '');
        Config::set('mail.mailers.smtp.username', 'sales@remapdash.com');
        Config::set('mail.mailers.smtp.password', '#1Te8tm0');
        Config::set('mail.from.address', 'sales@remapdash.com');
    }
}
