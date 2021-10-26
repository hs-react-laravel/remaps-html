<?php

namespace App\Http\Controllers\Consumer;

use App\Models\TuningCreditGroup;
use App\Models\TuningCreditTire;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

use Session;

class BuyTuningCreditsController extends Controller
{
    protected $paypal_client;
    public function __construct() {
        $env = new SandboxEnvironment(config('paypal.sandbox.client_id'), config('paypal.sandbox.client_secret'));
        $this->paypal_client = new PayPalHttpClient($env);
        parent::__construct();
    }
    public function index()
    {
        $tuningCreditGroup = $this->user->tuningCreditGroup;
        $groupCreditTires  = $tuningCreditGroup
            ? $this->user->tuningCreditGroup->tuningCreditTires()->withPivot('from_credit', 'for_credit')->wherePivot('from_credit', '!=', 0.00)->orderBy('amount', 'ASC')->get()
            : [];
        $isVatCalculation = ($this->company->vat_number != null) && ($this->company->vat_percentage != null) && ($this->user->add_tax);
        // dd($groupCreditTires);
        return view('pages.consumers.bc.index', [
            'groupCreditTires' => $groupCreditTires,
            'isVatCalculation' => $isVatCalculation,
            'tuningCreditGroup' => $tuningCreditGroup
        ]);
    }
    public function handlePayment(Request $request)
    {
        $tuningCreditGroup = TuningCreditGroup::find($request->group_id);
        $groupCreditTires  = $this->user->tuningCreditGroup->tuningCreditTires()->withPivot('from_credit', 'for_credit')->wherePivot('from_credit', '!=', 0.00);
        $tire = $groupCreditTires->where('id', $request->tire_id)->first();

        $tax = $tire->pivot->for_credit * $this->company->vat_percentage / 100;
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
        $response = $this->paypal_client->execute($req);
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
            'item_count' => $tire->amount
        ]);
        return redirect($redirect);
    }

    public function paymentSuccess(Request $request)
    {
        $request = new OrdersCaptureRequest($request->session()->get('order_id'));
        $request->body = "{}";
        $response = $this->paypal_client->execute($request);
        $result = $response->result;

        $user = $this->user;
        /* save order displayable id */
        $displableId = \App\Models\Order::wherehas('user', function($query) use($user){
            $query->where('company_id', $user->company_id);
        })->max('displayable_id');

        $displableId++;

        if ($response->statusCode == 201) {
            $transaction = session('transaction');
            $totalCredits = ($user->tuning_credits + session('item_count'));
            $user->tuning_credits = $totalCredits;
            $user->save();
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
        dd($request);
    }
}
