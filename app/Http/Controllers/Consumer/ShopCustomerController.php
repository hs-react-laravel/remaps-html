<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\MasterController;
use App\Models\ShopCart;
use App\Models\ShopProduct;
use App\Models\ShopProductSkuItem;
use Illuminate\Http\Request;

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
            return response()->json([
                'itemCount' => count($cartProducts),
                'newAmount' => $currencyCode.number_format($newAmount, 2),
                'totalAmount' => $currencyCode.number_format($totalCartAmount, 2)
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
            return response()->json([
                'itemCount' => count($cartProducts),
                'totalAmount' => $currencyCode.number_format($totalCartAmount, 2)
            ], 200);
        } catch(\Exception $e) {
            return response()->json(['status'=> FALSE], 500);
        }
    }
}
