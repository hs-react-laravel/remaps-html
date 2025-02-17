<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Models\Subscription;
use App\Models\Package;
use App\Models\User;
use App\Models\SubscriptionPayment;
use Dompdf\Dompdf;

class SubscriptionController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Subscription::where('user_id', $this->user->id);
        $company = $request->input('company');
        if($this->user->is_master){
            if($company){
                $query = Subscription::whereHas('user', function($query) use($company){
                    $query->where('company_id', $company);
                });
            }
        }
        $entries = $query->orderBy('id', 'DESC')->get();
        return view('pages.subscription.index', compact('entries'));
    }

    public function getAccessToken() {
        $ch = curl_init();

        $company = \App\Models\Company::where('is_default', 1)->first();
        if(!$company) return;

        $clientId = $company->paypal_client_id;
        $secret = $company->paypal_secret;
        // $clientId = config('paypal.sandbox.client_id');
        // $secret = config('paypal.sandbox.client_secret');

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

    public function payments($id)
    {
        $subscription = Subscription::find($id);
        $entries = $subscription->subscriptionPayments;
        return view('pages.subscription.payments', compact('entries'));
    }

    public function invoice($id)
    {
        $subscription_payment = SubscriptionPayment::find($id);
        $pdf = new Dompdf;
        $invoiceName = 'invoice_'.$subscription_payment->id.'.pdf';
        $options = $pdf->getOptions();
        $options->setIsRemoteEnabled(true);
        $pdf->setOptions($options);
        $masterCompany = \App\Models\Company::where('is_default', 1)->first();
        $pdf->loadHtml(
            view('pdf.subscription_invoice')->with(['subscription_payment'=>$subscription_payment, 'company'=>$masterCompany, 'user'=>$this->user])->render()
        );
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        return $pdf->stream($invoiceName);
    }

    public function choose() {
        $packages = Package::get();
        return view('pages.package.choose', compact('packages'));
    }

    public function subscribeSubscription($id){
        try {
            $package = Package::find($id);
            $accessToken = $this->getAccessToken();
            return $this->curlSubscription($package, $accessToken);
        } catch (\Exception $ex) {
            // dd($ex);
            return redirect(route('packages.choose'));
        }
    }

    public function curlSubscription($package, $accessToken) {
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
                    'given_name' => $this->user->last_name,
                    'surname' => $this->user->first_name
                ),
                'email_address' => $this->user->email
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
                'return_url' => route('paypal.subscription.execute').'?success=true',
                'cancel_url' => route('paypal.subscription.execute').'?success=false'
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

    public function executeSubscription(Request $request){
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

            $company = \App\Models\Company::where('is_default', 1)->first();
            $currencySymbol = \App\Helpers\Helper::getCurrencySymbol($company->paypal_currency_code);

            try {
                // Execute agreement
                $subscription = new \App\Models\Subscription();
                $subscription->user_id = $this->user->id;
                $subscription->pay_agreement_id = $id;
                $subscription->description = 'Amount: '.$currencySymbol.round($subscriptionDetail->billing_info->last_payment->amount->value);
                $subscription->start_date = \Carbon\Carbon::parse($subscriptionDetail->start_time)->format('Y-m-d H:i:s');
                $subscription->status = $subscriptionDetail->status;
                $subscription->save();
                // \Alert::success(__('admin.company_subscribed'))->flash();
            } catch (\Exception $ex) {
                // \Alert::error($ex->getMessage())->flash();
            }
        }else {
            // \Alert::error(__('admin.company_not_subscribed'))->flash();
        }
        return redirect(url('admin/dashboard'));
    }

    public function cancelSubscription($id){
        $subscription = Subscription::find($id);
        $user = User::where("id",$subscription->user_id)->first();
        if($subscription->is_trial == 1){
            $subscription->status = 'Cancelled';
            if ($subscription->save()) {
				// \Alert::success(__('admin.company_cancelled_subscription'))->flash();
			}else{
				// \Alert::error(__('admin.opps'))->flash();
			}
        }
        else {
            try {
                $url = "https://api.paypal.com/v1/billing/subscriptions/{$subscription->pay_agreement_id}/cancel";
                // $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$subscription->pay_agreement_id}/cancel";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $headers = array(
                    'Accept: application/json',
                    'Authorization: '."Bearer ". $this->getAccessToken(),
                    'Prefer: return=representation',
                    'Content-Type: application/json',
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                $data = [
                    'reason' => 'Cancel the subscription'
                ];
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                $resp = curl_exec($curl);
                curl_close($curl);

                $subscription->status = 'Cancelled';
                if($subscription->save()){
                    // \Alert::success(__('admin.company_cancelled_subscription'))->flash();
                }else{
                    // \Alert::error(__('admin.opps'))->flash();
                }
            }catch(\Exception $e){
                // \Alert::error($e->getMessage())->flash();
            }
        }
        return redirect(route('subscriptions.index'));
    }

    /**
     * update subscription status.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function immediateCancelSubscription($id){
        $subscription = Subscription::find($id);
        $user = User::where("id",$subscription->user_id)->first();
        if($subscription->is_trial == 1){
            $subscription->status = 'Suspended';
            $subscription->is_immediate = 1;
            if($subscription->save()){
				// \Alert::success(__('admin.company_cancelled_subscription'))->flash();
			}else{
				// \Alert::error(__('admin.opps'))->flash();
			}
        }
        else{
            try {
                $url = "https://api.paypal.com/v1/billing/subscriptions/{$subscription->pay_agreement_id}/suspend";
                // $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$subscription->pay_agreement_id}/suspend";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $headers = array(
                    'Accept: application/json',
                    'Authorization: '."Bearer ". $this->getAccessToken(),
                    'Prefer: return=representation',
                    'Content-Type: application/json',
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                $data = [
                    'reason' => 'Cancel the subscription immediately'
                ];
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                $resp = curl_exec($curl);
                curl_close($curl);

                $subscription->status = 'Suspended';
                $subscription->is_immediate = 1;
                if($subscription->save()){
                    // \Alert::success(__('admin.company_cancelled_subscription'))->flash();
                }else{
                    // \Alert::error(__('admin.opps'))->flash();
                }
                // \Alert::success(__('admin.company_cancelled_subscription'))->flash();
            }catch(\Exception $e){
                // \Alert::error($e->getMessage())->flash();
            }
        }
        $company = $subscription->owner;
        return redirect(route('subscriptions.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
