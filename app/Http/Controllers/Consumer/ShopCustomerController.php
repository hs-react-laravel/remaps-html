<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MasterController;
use App\Models\Shop\ShopCard;
use App\Models\Shop\ShopCart;
use App\Models\Shop\ShopCategory;
use App\Models\Shop\ShopComment;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderProduct;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductSkuItem;
use App\Models\Shop\ShopShippingOption;
use App\Helpers\Helper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Stripe\StripeClient;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use ZipArchive;
use File;

class ShopCustomerController extends MasterController
{
    public function physical_list(Request $request) {
        $mode = 'tool';
        $products = ShopProduct::where('company_id', $this->company->id)->where('live', 1);
        $products = $products->whereNull('digital_id');
        $tree = Helper::categoryTree($this->company->id, 'tool');
        $selected = [];

        if ($request->has('category_filter')) {
            $selected = explode(',', $request->get('category_filter'));
            $tree = Helper::categoryTree($this->company->id, 'tool', $selected);
            $products = $products->whereIn('category_id', $selected);
        }
        if ($request->has('product_brands')) {
            $products = $products->whereIn('brand', $request->get('product_brands'));
        }
        if ($request->has('min_selected_price')) {
            $products = $products->where('price', '>=', $request->get('min_selected_price'));
        }
        if ($request->has('max_selected_price')) {
            $products = $products->where('price', '<=', $request->get('max_selected_price'));
        }
        if ($request->has('rating')) {
            $products = $products->where('rating', '>=', $request->get('rating'));
        }
        $keyword = '';
        if ($request->has('keyword')) {
            $keyword = $request->get('keyword');
            $products = $products->where(function($query) use($keyword) {
                $query->where('title', 'like', '%'.$keyword.'%')
                    ->orWhere('brand', 'like', '%'.$keyword.'%')
                    ->orWhere('description', 'like', '%'.$keyword.'%');
            });
        }

        $products = $products->paginate(9);

        $maxPrice = ShopProduct::where('company_id', $this->company->id)->where('live', 1)->max('price');
        $minPrice = ShopProduct::where('company_id', $this->company->id)->where('live', 1)->min('price');
        if ($minPrice == $maxPrice) {
            $minPrice = 0;
        }
        $categories = ShopCategory::where('company_id', $this->company->id)->get();
        $brandNames = ShopProduct::where('company_id', $this->company->id)
            ->select('id', 'brand')
            ->groupBy('brand')
            ->pluck('brand');
        $brands = array();
        foreach($brandNames as $bn) {
            $count = ShopProduct::where('company_id', $this->company->id)
                ->where('brand', $bn)
                ->where('live', 1)
                ->count();
            array_push($brands, [
                'title' => $bn,
                'count' => $count
            ]);
        }
        $ratingValues = [4, 3, 2, 1];
        $ratings = array();
        foreach($ratingValues as $rv) {
            array_push($ratings, [
                'rating' => $rv,
                'count' => ShopProduct::where('company_id', $this->company->id)
                    ->where('live', 1)
                    ->where('rating', '>=', $rv)
                    ->count()
            ]);
        }

        $d_make = '';
        $d_model = '';
        $d_engine_code = '';
        $d_engine_disp = '';
        $d_hp = '';
        $d_ecu_make = '';
        $d_ecu_model = '';
        $d_soft_num = '';
        $d_soft_ver = '';
        $d_hard_ver = '';
        $d_checksum = '';
        $d_tuning_tool = '';
        return view('pages.consumers.ec.index')->with(compact(
            'mode',
            'products',
            'categories',
            'maxPrice',
            'minPrice',
            'brands',
            'ratings',
            'tree',
            'selected',
            'keyword',
            'd_make', 'd_model','d_engine_code', 'd_engine_disp','d_hp', 'd_ecu_make','d_ecu_model', 'd_soft_ver','d_soft_num', 'd_hard_ver','d_checksum', 'd_tuning_tool',
        ));
    }

    public function digital_list(Request $request) {
        $mode = 'digital';
        $products = ShopProduct::where('company_id', $this->company->id)->where('live', 1);
        $products = $products->whereNotNull('digital_id');
        $tree = Helper::categoryTree($this->company->id, 'digital');
        $selected = [];

        if ($request->has('category_filter')) {
            $selected = explode(',', $request->get('category_filter'));
            $tree = Helper::categoryTree($this->company->id, 'digital', $selected);
            $products = $products->whereIn('category_id', $selected);
        }
        if ($request->has('product_brands')) {
            $products = $products->whereIn('brand', $request->get('product_brands'));
        }
        if ($request->has('min_selected_price')) {
            $products = $products->where('price', '>=', $request->get('min_selected_price'));
        }
        if ($request->has('max_selected_price')) {
            $products = $products->where('price', '<=', $request->get('max_selected_price'));
        }
        if ($request->has('rating')) {
            $products = $products->where('rating', '>=', $request->get('rating'));
        }
        $keyword = '';
        if ($request->has('keyword')) {
            $keyword = $request->get('keyword');
            $products = $products->where(function($query) use($keyword) {
                $query->where('title', 'like', '%'.$keyword.'%')
                    ->orWhere('brand', 'like', '%'.$keyword.'%')
                    ->orWhere('description', 'like', '%'.$keyword.'%');
            });
        }
        $d_make = $request->get('d_make');
        $d_model = $request->get('d_model');
        $d_engine_code = $request->get('d_engine_code');
        $d_engine_disp = $request->get('d_engine_disp');
        $d_hp = $request->get('d_hp');
        $d_ecu_make = $request->get('d_ecu_make');
        $d_ecu_model = $request->get('d_ecu_model');
        $d_soft_num = $request->get('d_soft_num');
        $d_soft_ver = $request->get('d_soft_ver');
        $d_hard_ver = $request->get('d_hard_ver');
        $d_checksum = $request->get('d_checksum');
        $d_tuning_tool = $request->get('d_tuning_tool');

        if ($d_make) {
            $products = $products->whereHas('digital', function($query) use($d_make) {
                $query->where('make', 'like', '%'.$d_make.'%');
            });
        }
        if ($request->has('d_model')) {
            $products = $products->whereHas('digital', function($query) use($d_model) {
                $query->where('model', 'like', '%'.$d_model.'%');
            });
        }

        if ($request->has('d_engine_code')) {
            $products = $products->whereHas('digital', function($query) use($d_engine_code) {
                $query->where('engine_code', 'like', '%'.$d_engine_code.'%');
            });
        }

        if ($request->has('d_engine_disp')) {
            $products = $products->whereHas('digital', function($query) use($d_engine_disp) {
                $query->where('engine_displacement', 'like', '%'.$d_engine_disp.'%');
            });
        }

        if ($request->has('d_hp')) {
            $products = $products->whereHas('digital', function($query) use($d_hp) {
                $query->where('hp_stock', 'like', '%'.$d_hp.'%');
            });
        }

        if ($request->has('d_ecu_make')) {
            $products = $products->whereHas('digital', function($query) use($d_ecu_make) {
                $query->where('ecu_make', 'like', '%'.$d_ecu_make.'%');
            });
        }

        if ($request->has('d_ecu_model')) {
            $products = $products->whereHas('digital', function($query) use($d_ecu_model) {
                $query->where('ecu_model', 'like', '%'.$d_ecu_model.'%');
            });
        }

        if ($request->has('d_soft_ver')) {
            $products = $products->whereHas('digital', function($query) use($d_soft_ver) {
                $query->where('software_version', 'like', '%'.$d_soft_ver.'%');
            });
        }

        if ($request->has('d_soft_num')) {
            $products = $products->whereHas('digital', function($query) use($d_soft_num) {
                $query->where('software_number', 'like', '%'.$d_soft_num.'%');
            });
        }

        if ($request->has('d_hard_ver')) {
            $products = $products->whereHas('digital', function($query) use($d_hard_ver) {
                $query->where('make', 'hardware_version', '%'.$d_hard_ver.'%');
            });
        }

        if ($request->has('d_checksum')) {
            $products = $products->whereHas('digital', function($query) use($d_checksum) {
                $query->where('checksum', 'like', '%'.$d_checksum.'%');
            });
        }

        if ($request->has('d_tuning_tool')) {
            $products = $products->whereHas('digital', function($query) use($d_tuning_tool) {
                $query->where('tuning_tool', 'like', '%'.$d_tuning_tool.'%');
            });
        }

        $products = $products->paginate(9);

        $maxPrice = ShopProduct::where('company_id', $this->company->id)->where('live', 1)->max('price');
        $minPrice = ShopProduct::where('company_id', $this->company->id)->where('live', 1)->min('price');
        if ($minPrice == $maxPrice) {
            $minPrice = 0;
        }
        $categories = ShopCategory::where('company_id', $this->company->id)->get();
        $brandNames = ShopProduct::where('company_id', $this->company->id)
            ->select('id', 'brand')
            ->groupBy('brand')
            ->pluck('brand');
        $brands = array();
        foreach($brandNames as $bn) {
            $count = ShopProduct::where('company_id', $this->company->id)
                ->where('brand', $bn)
                ->where('live', 1)
                ->count();
            array_push($brands, [
                'title' => $bn,
                'count' => $count
            ]);
        }
        $ratingValues = [4, 3, 2, 1];
        $ratings = array();
        foreach($ratingValues as $rv) {
            array_push($ratings, [
                'rating' => $rv,
                'count' => ShopProduct::where('company_id', $this->company->id)
                    ->where('live', 1)
                    ->where('rating', '>=', $rv)
                    ->count()
            ]);
        }
        return view('pages.consumers.ec.index')->with(compact(
            'mode',
            'products',
            'categories',
            'maxPrice',
            'minPrice',
            'brands',
            'ratings',
            'tree',
            'selected',
            'keyword',
            'd_make', 'd_model','d_engine_code', 'd_engine_disp','d_hp', 'd_ecu_make','d_ecu_model', 'd_soft_ver','d_soft_num', 'd_hard_ver','d_checksum', 'd_tuning_tool',
        ));
    }
    public function detail($id)
    {
        $product = ShopProduct::find($id);
        if ($product->digital_id) {
            return view('pages.consumers.ec.detail-digital')->with(compact('product'));
        } else {
            return view('pages.consumers.ec.detail')->with(compact('product'));
        }
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

        return redirect()->route('customer.shop.physical');
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

        $isVatCalculation = ($this->company->vat_number != null) && ($this->company->vat_percentage != null) && ($this->user->add_tax);

        return view('pages.consumers.ec.checkout')->with(compact('order', 'isVatCalculation'));
    }

    public function addCard(Request $request) {
        ShopCard::create($request->all());
    }

    public function placeOrder(Request $request) {
        DB::beginTransaction();
        $digital_count = 0;
        $non_digital_count = 0;
        try {
            $cartProducts = ShopCart::where('user_id', $this->user->id)->get();
            $totalCartAmount = 0;
            foreach ($cartProducts as $item)  {
                $totalCartAmount += $item->price * $item->amount;
            }
            $isVatCalculation = ($this->company->vat_number != null) && ($this->company->vat_percentage != null) && ($this->user->add_tax);
            $tax = $this->company->vat_percentage ?? 0;
            $taxAmount = $isVatCalculation ? $totalCartAmount * $tax / 100 : 0;
            $order = ShopOrder::create([
                'user_id' => $this->user->id,
                'amount' => $totalCartAmount,
                'tax' => $taxAmount,
                'status' => 1
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
                if (!$product->digital_id) {
                    if ($product->stock < $item->amount) {
                        throw new Exception('Exceeds stock of '. $item->product->title);
                    }
                    $product->stock = $product->stock - $item->amount;
                    $product->save();
                    $non_digital_count++;
                } else {
                    $digital_count++;
                }
            }
            if ($non_digital_count == 0 && $digital_count > 0) {
                $order->update([
                    'status' => 3
                ]);
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
            'status' => 2
        ]);
        $order->update($request->all());
        return redirect()->route('customer.shop.checkout', ['order' => $order->id]);
    }

    public function setShippingOption(Request $request, $id) {
        $order = ShopOrder::find($id);
        $shippingObjectIDs = $request->get('shipping_object_id');
        $orderProducts = $order->items;
        foreach ($shippingObjectIDs as $i => $sid) {
            if ($sid > 0) {
                $sop = ShopOrderProduct::find($orderProducts[$i]->id);
                $shipObj = ShopShippingOption::find($sid);
                $sop->shipping_detail = json_encode($shipObj);
                $sop->save();
            }
        }
        $request->request->add([
            'status' => 3
        ]);
        $order->update($request->all());
        return redirect()->route('customer.shop.checkout', ['order' => $order->id]);
    }

    public function payOrderByStripe(Request $request, $id) {
        try {
            $order = ShopOrder::find($id);
            $total_amount = $order->amount + $order->tax + $order->shipPrice();
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
                'status' => 4,
                'transaction' => $result->id
            ]);
            $digital_files = array();
            $digital_count = 0;
            foreach($order->items as $item) {
                if ($item->product->digital_id) {
                    $digital_count++;
                    array_push($digital_files, storage_path('app/public/uploads/products/digital/'.$item->product->digital->document));
                }
            }
            if (count($digital_files) > 0) {
                $zip      = new ZipArchive;
                $fileName = 'storage/downloads/'.time().'.zip';
                if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
                    foreach ($digital_files as $file) {
                      $zip->addFile($file, basename($file));
                    }
                    $zip->close();
                }
                session()->flash('download.in.the.next.request', asset($fileName));
            }
        } catch (\Exception $ex) {

        }
        session()->flash('message', 'Payment is completed. Thank you for your order');
        return redirect()->route('customer.shop.order.list');
    }

    public function payOrderByPaypal(Request $request, $id) {
        try {
            $order = ShopOrder::find($id);
            $total_amount = number_format($order->amount + $order->tax + $order->shipPrice(), 2);
            $items = array();
            $isVatCalculation = ($this->company->vat_number != null) && ($this->company->vat_percentage != null) && ($this->user->add_tax);
            $tax = $isVatCalculation ? $this->company->vat_percentage : 0;
            foreach($order->items as $item) {
                $orderItem = array(
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
                array_push($items, $orderItem);
            }

            $orderReq = new OrdersCreateRequest();
            $orderReq->prefer('return=representation');
            $orderReq->body = array(
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
                                    'value' => $order->shipPrice()
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
            $env = new ProductionEnvironment($this->company->paypal_client_id, $this->company->paypal_secret);
            // $env = new SandboxEnvironment('AdibmcjffSYZR9TSS5DuKIQpnf80KfY-3pBGd30JKz2Ar1xHIipwijo4eZOJvbDCFpfmOBItDqZoiHmM', 'EEPRF__DLqvkwnnpi2Hi3paQ-9SZFRqypUH-u0fr4zAzvv7hWtz1bJHF0CEwvrvZpHyLeKSTO_FwAeO_');
            $paypal_client = new PayPalHttpClient($env);
            $response = $paypal_client->execute($orderReq);
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
        $paypal_order_id = $request->session()->get('order_id');
        $request = new OrdersCaptureRequest($paypal_order_id);
        $request->body = "{}";
        $env = new ProductionEnvironment($this->company->paypal_client_id, $this->company->paypal_secret);
        // $env = new SandboxEnvironment('AdibmcjffSYZR9TSS5DuKIQpnf80KfY-3pBGd30JKz2Ar1xHIipwijo4eZOJvbDCFpfmOBItDqZoiHmM', 'EEPRF__DLqvkwnnpi2Hi3paQ-9SZFRqypUH-u0fr4zAzvv7hWtz1bJHF0CEwvrvZpHyLeKSTO_FwAeO_');
        $paypal_client = new PayPalHttpClient($env);
        $response = $paypal_client->execute($request);
        $result = $response->result;

        if ($response->statusCode == 201) {
            $order->update([
                'payment_method' => 'paypal',
                'status' => 4,
                'transaction' => $result->purchase_units[0]->payments->captures[0]->id
            ]);
        }

        $digital_files = array();
        $digital_count = 0;
        foreach($order->items as $item) {
            if ($item->product->digital_id) {
                $digital_count++;
                array_push($digital_files, storage_path('app/public/uploads/products/digital/'.$item->product->digital->document));
            }
        }
        if (count($digital_files) > 0) {
            $zip      = new ZipArchive;
            $fileName = 'storage/downloads/'.time().'.zip';
            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
                foreach ($digital_files as $file) {
                    $zip->addFile($file, basename($file));
                }
                $zip->close();
            }
            session()->flash('download.in.the.next.request', asset($fileName));
        }

        session()->flash('message', 'Payment is completed. Thank you for your order');
        return redirect()->route('customer.shop.physical');
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
        $product = ShopProduct::find($orderProduct->product_id);
        $product->update([
            'rating' => $product->avgRating()
        ]);

        return redirect()->back();
    }
}
