<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MasterController;
use App\Models\Shop\ShopCard;
use App\Models\Shop\ShopCart;
use App\Models\Shop\ShopComment;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderProduct;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductSkuItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Stripe\StripeClient;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class ShopCustomerController extends MasterController
{
    public function index()
    {
        $products = ShopProduct::where('company_id', $this->company->id)->where('live', 1)->paginate(9);
        return view('pages.consumers.ec.index')->with(compact('products'));
    }

    public function detail($id)
    {
        $product = ShopProduct::find($id);
        return view('pages.consumers.ec.detail')->with(compact('product'));
    }

    public function add2cart(Request $request) {
        $product = ShopProduct::find($request->product_id);
        $price = $product->price;
        $sku_detail = null;
        if ($request->has('sku_selection')) {
            $selection = $request->get('sku_selection');
            $sku = $product->sku;
            foreach($selection as $i => $eachSku) {
                $price += ShopProductSkuItem::whereIn('id', $eachSku)->sum('price');
                $skuObj[$i] = [
                    'title' => $sku[$i]->title,
                    'select' => []
                ];
                foreach($eachSku as $j => $eachSkuSelect) {
                    $skuItem = ShopProductSkuItem::find($eachSkuSelect);
                    // dd($skuItem);
                    array_push($skuObj[$i]['select'], [
                        'title' => $skuItem->title,
                        'price' => $skuItem->price
                    ]);
                }
            }
            $sku_detail = json_encode($skuObj);
        }
        ShopCart::create([
            'user_id' => $this->user->id,
            'product_id' => $request->product_id,
            'price' => $price,
            'amount' => 1,
            'sku_detail' => $sku_detail
        ]);

        return redirect()->route('customer.shop');
    }

    public function updateCartItem(Request $request) {
        try {
            $cartItem = ShopCart::find($request->id);
            $cartItem->update([
                'amount' => $request->amount
            ]);

            $currencyCode = config('constants.currency_signs')[$this->company->paypal_currency_code];
            $newAmount = $cartItem->price * $cartItem->amount;
            $cartProducts = ShopCart::where('user_id', $this->user->id)->get();
            $totalCartAmount = 0;
            foreach ($cartProducts as $item)  {
                $totalCartAmount += $item->price * $item->amount;
            }
            $tax = $this->company->vat_percentage ?? 0;
            return response()->json([
                'itemCount' => count($cartProducts),
                'newAmount' => $currencyCode.number_format($newAmount, 2),
                'totalAmount' => $currencyCode.number_format($totalCartAmount, 2),
                'taxAmount' => $currencyCode.number_format($totalCartAmount * $tax / 100, 2),
                'orderAmount' => $currencyCode.number_format($totalCartAmount * ($tax + 100) / 100, 2)
            ], 200);
        } catch(\Exception $e) {
            return response()->json(['status'=> $e->getMessage()], 500);
        }
    }

    public function deleteCartItem(Request $request) {
        try {
            $cartItem = ShopCart::find($request->id);
            $cartItem->delete();

            $currencyCode = config('constants.currency_signs')[$this->company->paypal_currency_code];
            $cartProducts = ShopCart::where('user_id', $this->user->id)->get();
            $totalCartAmount = 0;
            foreach ($cartProducts as $item)  {
                $totalCartAmount += $item->price * $item->amount;
            }
            $tax = $this->company->vat_percentage ?? 0;
            return response()->json([
                'itemCount' => count($cartProducts),
                'totalAmount' => $currencyCode.number_format($totalCartAmount, 2),
                'taxAmount' => $currencyCode.number_format($totalCartAmount * $tax / 100, 2),
                'orderAmount' => $currencyCode.number_format($totalCartAmount * ($tax + 100) / 100, 2)
            ], 200);
        } catch(\Exception $e) {
            return response()->json(['status'=> FALSE], 500);
        }
    }

    public function checkout(Request $request) {
        $order = null;
        if ($request->has('order')) {
            $order = ShopOrder::find($request->get('order'));
        }
        return view('pages.consumers.ec.checkout')->with(compact('order'));
    }

    public function addCard(Request $request) {
        ShopCard::create($request->all());
    }

    public function placeOrder(Request $request) {
        DB::beginTransaction();
        try {
            $cartProducts = ShopCart::where('user_id', $this->user->id)->get();
            $totalCartAmount = 0;
            foreach ($cartProducts as $item)  {
                $totalCartAmount += $item->price * $item->amount;
            }
            $tax = $this->company->vat_percentage ?? 0;
            $taxAmount = $totalCartAmount * $tax / 100;
            $order = ShopOrder::create([
                'user_id' => $this->user->id,
                'amount' => $totalCartAmount,
                'tax' => $taxAmount,
                'status' => 'placed'
            ]);
            foreach ($cartProducts as $item)  {
                ShopOrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'amount' => $item->amount,
                    'sku_detail' => $item->sku_detail,
                ]);
                $product = ShopProduct::find($item->product_id);
                if ($product->stock < $item->amount) {
                    throw new Exception('Exceeds stock of '. $item->product->title);
                }
                $product->stock = $product->stock - $item->amount;
                $product->save();
            }
            ShopCart::where('user_id', $this->user->id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', $e->getMessage());
        }
        return redirect()->route('customer.shop.checkout', ['order' => $order->id]);
    }

    public function setOrderAddress(Request $request, $id) {
        $order = ShopOrder::find($id);
        $request->request->add([
            'status' => 'addressed'
        ]);
        $order->update($request->all());
        return redirect()->route('customer.shop.checkout', ['order' => $order->id]);
    }

    public function payOrderByStripe(Request $request, $id) {
        try {
            $order = ShopOrder::find($id);
            $total_amount = $order->amount + $order->tax;
            $stripe = new StripeClient($this->user->company->stripe_secret);
            $result = $stripe->charges->create([
                'amount' => $total_amount * 100,
                'currency' => $this->company->paypal_currency_code,
                'source' => $request->stripeToken,
                'description' => 'Buy items from '. $this->company->name,
            ]);
            if ($result->status != 'succeeded') {
                return;
            }
            $order->update([
                'payment_method' => 'stripe',
                'status' => 'paid',
                'transaction' => $result->id
            ]);
        } catch (\Exception $ex) {

        }
        return redirect()->route('customer.shop.order.list');
    }

    public function payOrderByPaypal(Request $request, $id) {
        try {
            $order = ShopOrder::find($id);
            $total_amount = $order->amount + $order->tax;
            $items = array();
            $tax = $this->company->vat_percentage ?? 0;
            foreach($order->items as $item) {
                $reqItem = array(
                    'name' => $item->product->title,
                    'description' => $this->company->name,
                    'unit_amount' => array(
                        'currency_code' => $this->company->paypal_currency_code,
                        'value' => $item->price
                    ),
                    'tax' => array(
                        'currency_code' => $this->company->paypal_currency_code,
                        'value' => number_format(($item->price * $tax) / 100, 2),
                    ),
                    'quantity' => $item->amount,
                );
                array_push($items, $reqItem);
            }

            $req = new OrdersCreateRequest();
            $req->prefer('return=representation');
            $req->body = array(
                'intent' => 'CAPTURE',
                'application_context' => array(
                    'return_url' => route('customer.shop.order.pay.paypal.success', ['id' => $id]),
                    'cancel_url' => route('customer.shop.order.pay.paypal.cancel', ['id' => $id])
                ),
                'purchase_units' => array(
                    0 => array(
                        'amount' => array(
                            'currency_code' => $this->company->paypal_currency_code,
                            'value' => $total_amount,
                            'breakdown' => array(
                                'item_total' => array(
                                    'currency_code' => $this->company->paypal_currency_code,
                                    'value' => $order->amount
                                ),
                                'shipping' => array(
                                    'currency_code' => $this->company->paypal_currency_code,
                                    'value' => 0
                                ),
                                'tax_total' => array(
                                    'currency_code' => $this->company->paypal_currency_code,
                                    'value' => $order->tax
                                )
                            )
                        ),
                        'items' => $items
                    )
                )
            );
            // dd($req->body);
            $env = new ProductionEnvironment($this->company->paypal_client_id, $this->paypal_secret);
            // $env = new SandboxEnvironment('AdibmcjffSYZR9TSS5DuKIQpnf80KfY-3pBGd30JKz2Ar1xHIipwijo4eZOJvbDCFpfmOBItDqZoiHmM', 'EEPRF__DLqvkwnnpi2Hi3paQ-9SZFRqypUH-u0fr4zAzvv7hWtz1bJHF0CEwvrvZpHyLeKSTO_FwAeO_');
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
                'order_id' => $response->result->id
            ]);
            return redirect($redirect);
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
        return redirect()->route('customer.shop.checkout', ['order' => $order->id]);
    }

    public function paypalPaymentSuccess(Request $request, $id) {
        $order = ShopOrder::find($id);
        $request = new OrdersCaptureRequest($request->session()->get('order_id'));
        $request->body = "{}";
        $env = new ProductionEnvironment($this->company->paypal_client_id, $this->paypal_secret);
        // $env = new SandboxEnvironment('AdibmcjffSYZR9TSS5DuKIQpnf80KfY-3pBGd30JKz2Ar1xHIipwijo4eZOJvbDCFpfmOBItDqZoiHmM', 'EEPRF__DLqvkwnnpi2Hi3paQ-9SZFRqypUH-u0fr4zAzvv7hWtz1bJHF0CEwvrvZpHyLeKSTO_FwAeO_');
        $paypal_client = new PayPalHttpClient($env);
        $response = $paypal_client->execute($request);
        $result = $response->result;

        if ($response->statusCode == 201) {
            $order->update([
                'payment_method' => 'paypal',
                'status' => 'paid',
                'transaction' => $result->id
            ]);
        }
        return redirect()->route('customer.shop');
    }

    public function paypalPaymentCancel($id) {
        return redirect()->route('customer.shop.checkout', ['order' => $id]);
    }

    public function orderList() {
        $entries = ShopOrder::where('user_id', $this->user->id)->paginate('10');
        return view('pages.consumers.ec.orders')->with(compact('entries'));
    }

    public function orderShow($id) {
        $order = ShopOrder::find($id);
        return view('pages.consumers.ec.order-show')->with(compact('order'));
    }

    public function commentProduct(Request $request, $id) {
        // dd($request);
        $orderProduct = ShopOrderProduct::find($id);
        ShopComment::create([
            'order_product_id' => $id,
            'product_id' => $orderProduct->product->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->back();
    }
}
