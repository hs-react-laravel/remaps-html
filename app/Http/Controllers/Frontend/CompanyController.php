<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRegisterFront;
use App\Http\Controllers\Controller;
use App\Mail\RegisterCompanyFront;
use App\Mail\NewCompanyApply;

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

class CompanyController extends Controller
{

	public function companies(Request $request){
        dd('companies');
		$qry = $request->all();
		if(!empty($qry) && isset($qry['keyword']) && isset($qry['sort'])  ){
			$keyword = $qry['keyword'];
			$sort = $qry['sort'];
		}

		$companies = Company::where('is_public', '1')->with('tuningCreditGroups', 'tuningCreditGroups.tuningCreditTires')->get()->toArray();
		dd($companies);
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
			 $companyUser->save();

			 $emailTemplates = \App\Models\EmailTemplate::where('company_id', 1)->whereIn('label', ['customer-welcome-email', 'new-file-service-created-email', 'file-service-opened-email', 'file-service-modified-email', 'file-service-processed-email','new-ticket-created','new-file-ticket-created','reply-to-your-ticket'])->get();
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
                Config::set('mail.mailers.smtp.password', '73B#6lbt9');
                Config::set('mail.from.address', $mainCompany['mail_username']);
                Config::set('mail.from.name', $mainCompany['name']);
                Config::set('app.name', $mainCompany['name']);

			 	try{
					Mail::to($mainCompany['main_email_address'])->send(new NewCompanyApply($companyUser,$mainCompany));
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
}
