<?php

namespace App\Http\Controllers\Consumer;

use App\Models\TuningCreditGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
// use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Auth;

class BuyTuningCreditsController extends MasterController
{
    protected $paypal_client;
    public function __construct() {
        parent::__construct();
    }
    public function index()
    {
        $tuningCreditGroup = $this->user->tuningCreditGroup;
        $tuningEVCCreditGroup = $this->user->tuningEVCCreditGroup;
        $groupCreditTires  = $tuningCreditGroup
            ? $this->user->tuningCreditGroup->tuningCreditTires()->withPivot('from_credit', 'for_credit')->wherePivot('from_credit', '!=', 0.00)->orderBy('amount', 'ASC')->get()
            : [];
        $groupEVCCreditTires = $this->user->tuningEVCCreditGroup
            ? $this->user->tuningEVCCreditGroup->tuningCreditTires()->withPivot('from_credit', 'for_credit')->wherePivot('from_credit', '!=', 0.00)->orderBy('amount', 'ASC')->get()
            : [];
        $isVatCalculation = ($this->company->vat_number != null) && ($this->company->vat_percentage != null) && ($this->user->add_tax);
        // $stripeKey = "pk_test_bRcRJEVm0RNqTW3Ge72Cmlfv00qvW84uiQ";
        $stripeKey = $this->company->stripe_key;
        return view('pages.consumers.bc.index', compact('groupCreditTires', 'groupEVCCreditTires', 'isVatCalculation', 'tuningCreditGroup', 'tuningEVCCreditGroup', 'stripeKey'));
    }
    public function handlePayment(Request $request)
    {
        $tuningCreditGroup = TuningCreditGroup::find($request->group_id);
        $groupCreditTires  = $this->user->tuningCreditGroup->tuningCreditTires()->withPivot('from_credit', 'for_credit')->wherePivot('from_credit', '!=', 0.00);
        if ($request->type == 'evc') {
            $groupCreditTires  = $this->user->tuningEVCCreditGroup->tuningCreditTires()->withPivot('from_credit', 'for_credit')->wherePivot('from_credit', '!=', 0.00);
        }
        $tire = $groupCreditTires->where('id', $request->tire_id)->first();

        $isVatCalculation = ($this->company->vat_number != null) && ($this->company->vat_percentage != null) && ($this->user->add_tax);
        $vat_percentage = $isVatCalculation ? $this->company->vat_percentage : 0;

        $tax = $tire->pivot->for_credit * $vat_percentage / 100;
        $total_amount = $tire->pivot->for_credit + $tax;
        $req = new OrdersCreateRequest();
        $req->prefer('return=representation');
        $req->body = array(
            'intent' => 'CAPTURE',
            'application_context' => array(
                'return_url' => route('consumer.buy-credits.success'),
                'cancel_url' => route('consumer.buy-credits.cancel')
            ),
            'purchase_units' => array(
                0 => array(
                    'amount' => array(
                        'currency_code' => $this->company->paypal_currency_code,
                        'value' => $total_amount,
                        'breakdown' => array(
                            'item_total' => array(
                                'currency_code' => $this->company->paypal_currency_code,
                                'value' => $tire->pivot->for_credit
                            ),
                            'shipping' => array(
                                'currency_code' => $this->company->paypal_currency_code,
                                'value' => 0
                            ),
                            'tax_total' => array(
                                'currency_code' => $this->company->paypal_currency_code,
                                'value' => $tax
                            )
                        )
                    ),
                    'items' => array(
                        0 => array(
                            'name' => 'Tuning Credits',
                            'description' => $tuningCreditGroup->name.'('.$tire->amount.' credits)',
                            'unit_amount' => array(
                                'currency_code' => $this->company->paypal_currency_code,
                                'value' => $tire->pivot->for_credit
                            ),
                            'tax' => array(
                                'currency_code' => $this->company->paypal_currency_code,
                                'value' => $tax
                            ),
                            'quantity' => '1',
                        )
                    )
                )
            )
        );
        $user = Auth::guard('customer')->user();
        $env = new ProductionEnvironment($user->company->paypal_client_id, $user->company->paypal_secret);
        $paypal_client = new PayPalHttpClient($env);
        $response = $paypal_client->execute($req);
        $links = $response->result->links;
        $redirect = "/";
        foreach($links as $link) {
            if ($link->rel == "approve") {
                $redirect = $link->href;
            }
        }
        session([
            'order_id' => $response->result->id,
            'transaction' => array(
                'tax' => $tax,
                'total' => $total_amount,
                'description' => $tuningCreditGroup->name.'('.$tire->amount.' credits)'
            ),
            'item_count' => $tire->amount,
            'credit_type' => $tuningCreditGroup->group_type,
        ]);
        return redirect($redirect);
    }

    public function paymentSuccess(Request $request)
    {
        $user = $this->user;
        $request = new OrdersCaptureRequest($request->session()->get('order_id'));
        $request->body = "{}";

        $env = new ProductionEnvironment($user->company->paypal_client_id, $user->company->paypal_secret);
        $paypal_client = new PayPalHttpClient($env);
        $response = $paypal_client->execute($request);
        $result = $response->result;
        $credit_type = session('credit_type');

        /* save order displayable id */
        $displableId = \App\Models\Order::wherehas('user', function($query) use($user){
            $query->where('company_id', $user->company_id);
        })->max('displayable_id');

        $displableId++;

        if ($response->statusCode == 201) {
            $transaction = session('transaction');
            if ($credit_type == 'normal') {
                $totalCredits = ($user->tuning_credits + session('item_count'));
                $user->tuning_credits = $totalCredits;
                $user->save();
            } else if ($credit_type == 'evc') {
                $url = "https://evc.de/services/api_resellercredits.asp";
                $dataArray = array(
                    'apiid'=>'j34sbc93hb90',
                    'username'=> $user->company->reseller_id,
                    'password'=> $user->company->reseller_password,
                    'verb'=>'addcustomeraccount',
                    'customer' => $user->reseller_id,
                    'credits' => session('item_count')
                );
                $ch = curl_init();
                $data = http_build_query($dataArray);
                $getUrl = $url."?".$data;
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_URL, $getUrl);
                curl_setopt($ch, CURLOPT_TIMEOUT, 500);

                $response = curl_exec($ch);
                if (strpos($response, 'ok') !== FALSE) {
                    session()->flash('message', 'Payment is successed');
                }
            }
            /* save order */
            $order = new \App\Models\Order();
            $order->user_id = $user->id;
            $order->transaction_id = $result->id;
            $order->invoice_id = $result->purchase_units[0]->payments->captures[0]->id;
            $order->vat_number = $this->company->vat_number;
            $order->vat_percentage = $this->company->vat_percentage;
            $order->tax_amount = $transaction['tax'];
            $order->amount = $transaction['total'];
            $order->description = $transaction['description'];
            $order->status = config('constants.order_status.completed');
            $order->displayable_id = $displableId;
            $order->save();

            // /* save transaction */
            $transaction = new \App\Models\Transaction();
            $transaction->user_id = $user->id;
            $transaction->credits = number_format(session('item_count'), 2);
            $transaction->description = "Tuning credits purchase";
            $transaction->status = config('constants.transaction_status.completed');
            $transaction->save();
        }
        return redirect(route('consumer.buy-credits'));
    }

    public function paymentCancel(Request $request)
    {
        return redirect(route('consumer.buy-credits'));
    }

    public function stripePost(Request $request) {
        $tuningCreditGroup = TuningCreditGroup::find($request->group_id);
        $groupCreditTires  = $this->user->tuningCreditGroup->tuningCreditTires()->withPivot('from_credit', 'for_credit')->wherePivot('from_credit', '!=', 0.00);
        $tire = $groupCreditTires->where('id', $request->tire_id)->first();

        $isVatCalculation = ($this->company->vat_number != null) && ($this->company->vat_percentage != null) && ($this->user->add_tax);
        $vat_percentage = $isVatCalculation ? $this->company->vat_percentage : 0;
        $tax = $tire->pivot->for_credit * $vat_percentage / 100;

        $total_amount = $tire->pivot->for_credit + $tax;

        $stripe = new StripeClient($this->user->company->stripe_secret);
        // $stripe = new StripeClient("sk_test_Woo4C4CI3cf0dvngmUuty49A00csvMGrNg");

        $result = $stripe->charges->create([
            'amount' => $total_amount * 100,
            'currency' => $this->company->paypal_currency_code,
            'source' => $request->stripeToken,
            'description' => $tuningCreditGroup->name.'('.$tire->amount.' credits)'
        ]);
        $user = $this->user;
        if ($request->stripe_credit_type == 'normal') {
            $totalCredits = ($user->tuning_credits + $tire->amount);
            $user->tuning_credits = $totalCredits;
            $user->save();
        } else {
            $url = "https://evc.de/services/api_resellercredits.asp";
            $dataArray = array(
                'apiid'=>'j34sbc93hb90',
                'username'=> $user->company->reseller_id,
                'password'=> $user->company->reseller_password,
                'verb'=>'addcustomeraccount',
                'customer' => $user->reseller_id,
                'credits' => $tire->amount
            );
            $ch = curl_init();
            $data = http_build_query($dataArray);
            $getUrl = $url."?".$data;
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $getUrl);
            curl_setopt($ch, CURLOPT_TIMEOUT, 500);

            $response = curl_exec($ch);
            if (strpos($response, 'ok') !== FALSE) {
                // \Alert::success(__('customer.payment_success'))->flash();
            }
        }
        $displableId = \App\Models\Order::wherehas('user', function($query) use($user){
            $query->where('company_id', $user->company_id);
        })->max('displayable_id');

        $displableId++;

        /* save order */
        $order = new \App\Models\Order();
        $order->user_id = $this->user->id;
        $order->transaction_id = $result->balance_transaction;
        $order->invoice_id = $result->id;
        $order->vat_number = $this->company->vat_number;
        $order->vat_percentage = $this->company->vat_percentage;
        $order->tax_amount = $tax;
        $order->amount = $result->amount_captured / 100;
        $order->description = $result->description;
        $order->status = config('constants.order_status.completed');
        $order->displayable_id = $displableId;
        $order->save();

        /* save transaction */
        $transaction = new \App\Models\Transaction();
        $transaction->user_id = $this->user->id;
        $transaction->credits = number_format($tire->amount, 2);
        if ($request->stripe_credit_type == 'normal') {
            $transaction->description = "Tuning credits purchase";
        } else {
            $transaction->description = "EVC credits purchase";
        }
        $transaction->status = config('constants.transaction_status.completed');
        $transaction->save();

        if ($result->status == 'succeeded') {
            // \Alert::success(__('customer.payment_success'))->flash();
            return redirect(route('consumer.buy-credits'));
        }
        // \Alert::error(__('customer.payment_failed'))->flash();
        return redirect(route('consumer.buy-credits'));
    }
}
