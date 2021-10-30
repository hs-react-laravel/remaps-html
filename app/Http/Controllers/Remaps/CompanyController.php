<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\CompanyActivateEmail;
use App\Mail\WelcomeCustomer;
use App\Models\User;
use App\Models\Company;
use App\Http\Controllers\Controller;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
                if($company->name && $company->main_email_address && $company->address_line_1 && $company->town && $company->country && $company->domain_link) {
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
                                'new-file-service-created-email',
                                'file-service-modified-email',
                                'file-service-processed-email',
                                'new-ticket-created',
                                'new-file-ticket-created',
                                'reply-to-your-ticket',
                                'file-service-upload-limited'
                            ])->get();

						if($emailTemplates->count() > 0){
							foreach($emailTemplates as $emailTemplate){
								$userTemplate = $emailTemplate->replicate();
								$userTemplate->company_id = $company->id;
								$userTemplate->save();
							}
						}
						$token = app('auth.password.broker')->createToken($companyUser);
						try{
							Mail::to($companyUser->email)->send(new WelcomeCustomer($companyUser, $token));
						}catch(\Exception $e) {
                            session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
						}
					}
                }
            }
            if(!($company->name && $company->address_line_1 && $company->town && $company->country)) {
                session()->flash('warning', 'Please update company name and address in order to complete company registration.');
                return redirect(route('companies.edit', ['company' => $company->id, 'tab' => 'name']));
            }

            if(!$company->domain_link) {
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
                if($entry->name && $entry->main_email_address && $entry->address_line_1 && $entry->town && $entry->country && $entry->domain_link){
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
                                'new-file-service-created-email',
                                'file-service-modified-email',
                                'file-service-processed-email',
                                'new-ticket-created',
                                'new-file-ticket-created',
                                'reply-to-your-ticket'
                            ])->get();

                        if($emailTemplates->count() > 0){
                            foreach($emailTemplates as $emailTemplate){
                                $userTemplate = $emailTemplate->replicate();
                                $userTemplate->company_id = $entry->id;
                                $userTemplate->save();
                            }
                        }
                        $token = app('auth.password.broker')->createToken($companyUser);
                        try{
                            Mail::to($companyUser->email)->send(new WelcomeCustomer($companyUser, $token));
                        }catch(\Exception $e){
                            session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
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

            if(!$entry->domain_link) {
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
			try{
            	Mail::to($companyUser->email)->send((new CompanyActivateEmail($companyUser, $token)));
			}catch(\Exception $e){
                session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
			}
		}
        return redirect(route('companies.index'));
    }

    public function resendPasswordResetLink($id){
        $company = Company::find($id);
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
        $company = Company::find($id);
        $user = $company->users()->where('is_master', 0)->where('is_admin', 1)->first();
        if($user){
            Auth::login($user);
            // return redirect()->away($user->company->domain_link);
            return redirect(route('dashboard'));
        }
    }

    public function trial($id) {
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
                    //  \Alert::success(__('admin.subscription_saved'))->flash();
                     return redirect(url('company/subscriptions?company='.$company->id))->withInput($request->all());
                 }else{
                    //  \Alert::error(__('admin.opps'))->flash();
                     return redirect()->back()->withInput($request->all());
                 }
            }else{
                return redirect()->back()->withInput($request->all())->withErrors($validations->errors());
            }
         }catch(\Exception $e){
            //  \Alert::error(__('admin.opps'))->flash();
             return redirect()->back()->withInput($request->all());
         }
    }
}
