<?php

namespace App\Http\Controllers\Remaps\Shop;

use App\Http\Controllers\MasterController;
use Illuminate\Http\Request;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopProduct;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Payments\CapturesRefundRequest;
use Stripe\StripeClient;

class ShopOrderController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $entries = ShopOrder::where('user_id', $this->user->id)->paginate('10');
        $user = $this->user;
        $entries = ShopOrder::whereHas('user', function($query) use($user){
            return $query->where('company_id', $user->company_id);
        })->orderBy('id', 'DESC')->paginate(10);
        return view('pages.ecommerce.shoporder.index')->with(compact('entries'));
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
        $order = ShopOrder::find($id);
        $order->is_checked = 1;
        $order->save();
        return view('pages.ecommerce.shoporder.show')->with(compact('order'));
    }

    public function deliver($id)
    {
        $order = ShopOrder::find($id);
        $order->status = 'delivered';
        $order->save();
        return redirect()->route('shoporders.index');
    }

    public function refund($id)
    {
        try {
            $order = ShopOrder::find($id);
            $request = new CapturesRefundRequest($order->transaction);
            $request->body = "{}";
            if ($order->payment_method == 'paypal') {
                // $env = new ProductionEnvironment($this->company->paypal_client_id, $this->company->paypal_secret);
                $env = new SandboxEnvironment('AdibmcjffSYZR9TSS5DuKIQpnf80KfY-3pBGd30JKz2Ar1xHIipwijo4eZOJvbDCFpfmOBItDqZoiHmM', 'EEPRF__DLqvkwnnpi2Hi3paQ-9SZFRqypUH-u0fr4zAzvv7hWtz1bJHF0CEwvrvZpHyLeKSTO_FwAeO_');
                $paypal_client = new PayPalHttpClient($env);
                $response = $paypal_client->execute($request);
                if ($response->result->status == "COMPLETED") {
                    $order = ShopOrder::find($id);
                    foreach($order->items as $item) {
                        $product = ShopProduct::find($item->product_id);
                        $product->stock = $product->stock + $item->amount;
                        $product->save();
                    }
                    $order->update([
                        'status' => '5'
                    ]);
                }
            } else if ($order->payment_method == 'stripe') {
                $stripe = new StripeClient($this->user->company->stripe_secret);
                $result = $stripe->refunds->create([
                    'charge' => $order->transaction
                ]);
                if ($result->status == 'succeeded') {
                    $order = ShopOrder::find($id);
                    foreach($order->items as $item) {
                        $product = ShopProduct::find($item->product_id);
                        $product->stock = $product->stock + $item->amount;
                        $product->save();
                    }
                    $order->update([
                        'status' => '5'
                    ]);
                }
            }
            return redirect()->route('shoporders.index');
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
            return redirect()->route('shoporders.index');
        }
    }

    public function process(Request $request, $id) {
        $order = ShopOrder::find($id);
        $request->request->add([
            'status' => 6
        ]);
        $order->update($request->all());
        return redirect()->route('shoporders.index');
    }

    public function dispatched(Request $request, $id) {
        $order = ShopOrder::find($id);
        $request->request->add([
            'status' => 7
        ]);
        $order->update($request->all());
        return redirect()->route('shoporders.index');
    }

    public function completed($id) {
        $order = ShopOrder::find($id);
        $order->update([
            'status' => 8
        ]);
        return redirect()->route('shoporders.index');
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
        $order = ShopOrder::find($id);
        foreach($order->items as $item) {
            $product = ShopProduct::find($item->product_id);
            $product->stock = $product->stock + $item->amount;
            $product->save();
            $item->delete();
        }
        $order->delete();
        return redirect()->route('shoporders.index');
    }
}
