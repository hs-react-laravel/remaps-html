<?php

namespace App\Http\Controllers\Remaps\Shop;

use App\Http\Controllers\MasterController;
use App\Models\Shop\ShopPackage;
use App\Models\Shop\ShopSubscription;
use App\Models\Shop\ShopSubscriptionPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class ShopSubscriptionController extends MasterController
{
    public function getAccessToken() {
        $ch = curl_init();

        $company = \App\Models\Company::where('is_default', 1)->first();
        if(!$company) return;

        // $clientId = $company->paypal_client_id;
        // $secret = $company->paypal_secret;
        $clientId = 'AdibmcjffSYZR9TSS5DuKIQpnf80KfY-3pBGd30JKz2Ar1xHIipwijo4eZOJvbDCFpfmOBItDqZoiHmM';
        $secret = 'EEPRF__DLqvkwnnpi2Hi3paQ-9SZFRqypUH-u0fr4zAzvv7hWtz1bJHF0CEwvrvZpHyLeKSTO_FwAeO_';

        // $api_url = "https://api.paypal.com/v1/oauth2/token";
        $api_url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";

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

    public function choose() {
        $packages = ShopPackage::get();
        return view('pages.ecommerce.package.choose', compact('packages'));
    }

    public function subscribeSubscription($id) {
        try {
            $prevSub = $this->company->getActiveShopSubscription();
            if ($prevSub)
                $this->curlCancelSubscription($prevSub->id);
        }catch(\Exception $e){
            session()->flash('error', $e->getMessage());
            return redirect(route('shop.subscription.index'));
        }
        try {
            $package = ShopPackage::find($id);
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

            // $url = "https://api.paypal.com/v1/billing/subscriptions";
            $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions";

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
                    'brand_name' => 'eCommerce Subscription',
                    'locale' => 'en-UK',
                    'shipping_preference' => 'SET_PROVIDED_ADDRESS',
                    'user_action' => 'SUBSCRIBE_NOW',
                    'payment_method' => array(
                        'payer_selected' => 'PAYPAL',
                        'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                    ),
                    'return_url' => route('shop.paypal.subscription.execute').'?success=true',
                    'cancel_url' => route('shop.paypal.subscription.execute').'?success=false'
                )
            );
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $resp = curl_exec($curl);
            curl_close($curl);

            session([
                'package_id' => $package->id
            ]);

            $respObj = json_decode($resp);
            return redirect()->away($respObj->links[0]->href);
        } catch (\Exception $ex) {
            return redirect(route('shop.packages.choose'));
        }
    }

    public function executeSubscription(Request $request){
        // dd(session('package_id'));
        if ($request->has('success') && $request->query('success') == 'true') {
            $id = $request->subscription_id;
            // $url = "https://api.paypal.com/v1/billing/subscriptions/{$id}";
            $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$id}";

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
            $currencySymbol = config('constants.currency_signs')[$company->paypal_currency_code];

            try {
                $subscription = new ShopSubscription;
                $subscription->user_id = $this->user->id;
                $subscription->package_id = session('package_id');
                $subscription->pay_agreement_id = $id;
                $subscription->description = 'Amount: '.$currencySymbol.round($subscriptionDetail->billing_info->last_payment->amount->value);
                $subscription->start_date = \Carbon\Carbon::parse($subscriptionDetail->start_time)->format('Y-m-d H:i:s');
                $subscription->status = $subscriptionDetail->status;
                $subscription->save();
            } catch (\Exception $ex) {

            }
        }else {

        }
        return redirect(route('shop.subscription.index'));
    }

    public function index(Request $request) {
        $query = ShopSubscription::where('user_id', $this->user->id);
        $company = $request->input('company');
        if($this->user->is_master){
            if($company){
                $query = ShopSubscription::whereHas('user', function($query) use($company){
                    $query->where('company_id', $company);
                });
            }
        }
        $entries = $query->orderBy('id', 'DESC')->get();
        return view('pages.ecommerce.subscription.index', compact('entries'));
    }

    public function payments($id)
    {
        $subscription = ShopSubscription::find($id);
        $entries = $subscription->subscriptionPayments;
        return view('pages.ecommerce.subscription.payments', compact('entries'));
    }

    public function invoice($id)
    {
        $subscription_payment = ShopSubscriptionPayment::find($id);
        $pdf = new Dompdf;
        $invoiceName = 'invoice_'.$subscription_payment->id.'.pdf';
        $pdf->loadHtml(
            view('pdf.subscription_invoice')->with(['subscription_payment'=>$subscription_payment, 'company'=>$this->company, 'user'=>$this->user])->render()
        );
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        return $pdf->stream($invoiceName);
    }

    public function immediateCancelSubscription($id){
        $subscription = ShopSubscription::find($id);
        try {
            // $url = "https://api.paypal.com/v1/billing/subscriptions/{$subscription->pay_agreement_id}/suspend";
            $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$subscription->pay_agreement_id}/suspend";

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
                'reason' => 'Suspend the subscription'
            ];
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_exec($curl);
            curl_close($curl);

            $subscription->status = 'SUSPENDED';
            if($subscription->save()){
                // \Alert::success(__('admin.company_cancelled_subscription'))->flash();
            }else{
                // \Alert::error(__('admin.opps'))->flash();
            }
            // \Alert::success(__('admin.company_cancelled_subscription'))->flash();
        }catch(\Exception $e){
            // \Alert::error($e->getMessage())->flash();
        }
        return redirect(route('shop.subscription.index'));
    }

    public function reactiveSubscription($id){
        $subscription = ShopSubscription::find($id);
        try {
            // $url = "https://api.paypal.com/v1/billing/subscriptions/{$subscription->pay_agreement_id}/suspend";
            $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$subscription->pay_agreement_id}/activate";

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
                'reason' => 'Reactivating the subscription'
            ];
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_exec($curl);
            curl_close($curl);

            $subscription->status = 'ACTIVE';
            if($subscription->save()){
                // \Alert::success(__('admin.company_cancelled_subscription'))->flash();
            }else{
                // \Alert::error(__('admin.opps'))->flash();
            }
            // \Alert::success(__('admin.company_cancelled_subscription'))->flash();
        }catch(\Exception $e){
            // \Alert::error($e->getMessage())->flash();
        }
        return redirect(route('shop.subscription.index'));
    }

    public function cancelSubscription($id){
        $subscription = ShopSubscription::find($id);

        try {
            $this->curlCancelSubscription($id);
        }catch(\Exception $e){
            session()->flash('error', $e->getMessage());
        }
        return redirect(route('shop.subscription.index'));
    }

    private function curlCancelSubscription($id) {
        $subscription = ShopSubscription::find($id);

        try {
            // $url = "https://api.paypal.com/v1/billing/subscriptions/{$subscription->pay_agreement_id}/cancel";
            $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$subscription->pay_agreement_id}/cancel";

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

            $subscription->status = 'CANCELLED';
            if($subscription->save()){
                // \Alert::success(__('admin.company_cancelled_subscription'))->flash();
            }else{
                // \Alert::error(__('admin.opps'))->flash();
            }
        }catch(\Exception $e){
            throw $e;
        }
    }
}
