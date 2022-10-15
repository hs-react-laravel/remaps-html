<?php

namespace App\Http\Controllers\Remaps\Shop;

use App\Http\Controllers\MasterController;
use App\Models\Shop\ShopCategory;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductSku;
use App\Models\Shop\ShopProductSkuItem;
use App\Models\Shop\ShopShippingOption;
use App\Models\Shop\ShopProductDigital;
use Illuminate\Http\Request;

class ShopProductController extends MasterController
{
    private function getMaxProductCount() {
        $maxProductCt = 3;
        $isActive = $this->company->hasActiveShopSubscription();
        if ($isActive) {
            $sub = $this->company->getActiveShopSubscription();
            $maxProductCt = $sub->package->product_count;
        }
        return $maxProductCt;
    }

    private function checkMembership() {
        $cpt = $this->getCurrentProductCount();
        $mpt = $this->getMaxProductCount();
        if ($cpt > $mpt) {
            $products = ShopProduct::where('company_id', $this->company->id)->take($mpt)->pluck('id')->toArray();
            ShopProduct::where('company_id', $this->company->id)
                ->whereNotIn('id', $products)
                ->update([
                    'live' => 0
                ]);
        }
    }

    private function getCurrentProductCount() {
        return ShopProduct::where('company_id', $this->company->id)->count();
    }

    public function index()
    {
        $this->checkMembership();
        $maxProductCt = $this->getMaxProductCount();

        $tab = request()->get('tab') ?? 'tool';
        $entries = ShopProduct::where('company_id', $this->company->id)->whereNull('digital_id')->paginate(10);
        if ($tab == 'digital') {
            $entries = ShopProduct::where('company_id', $this->company->id)->whereNotNull('digital_id')->paginate(10);
        }

        return view('pages.ecommerce.shopproducts.index')->with(compact('entries', 'maxProductCt'));
    }

    public function create()
    {
        $categories = ShopCategory::where('company_id', $this->company->id)->get();
        if ($this->getMaxProductCount() <= $this->getCurrentProductCount() && !$this->user->is_master) {
            return redirect()->route('shopproducts.index');
        }
        return view('pages.ecommerce.shopproducts.create')->with([
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->request->add([
            'company_id' => $this->company->id
        ]);
        if ($request->file('thumb_image')) {
            $thumb = $request->file('thumb_image');
            $filename = time().'.'.$thumb->getClientOriginalExtension();
            $thumb->move(storage_path('app/public/uploads/products/thumbnails/'), $filename);
            $request->request->add([
                'thumb' => $filename
            ]);
        }
        $product = ShopProduct::create($request->all());
        if ($request->has('sku_names')) {
            $skuNames = $request->get('sku_names');
            $skuTypes = $request->get('sku_types');
            $skuItems = $request->get('sku_items');
            $skuPrices = $request->get('sku_prices');
            foreach ($skuNames as $i => $sName) {
                $sku = ShopProductSku::create([
                    'product_id' => $product->id,
                    'title' => $sName,
                    'type' => $skuTypes[$i]
                ]);
                if (isset($skuItems) && isset($skuItems[$i])) {
                    foreach($skuItems[$i] as $j => $si) {
                        ShopProductSkuItem::create([
                            'product_sku_id' => $sku->id,
                            'title' => $si,
                            'price' => $skuPrices[$i][$j]
                        ]);
                    }
                }
            }
        }
        if ($request->has('shipping_items')) {
            $shippingOptionNames = $request->get('shipping_items');
            $shippingOptionValues = $request->get('shipping_prices');
            foreach ($shippingOptionNames as $i => $sName) {
                ShopShippingOption::create([
                    'product_id' => $product->id,
                    'option' => $sName,
                    'price' => $shippingOptionValues[$i]
                ]);
            }
        }
        return redirect()->route('shopproducts.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $entry = ShopProduct::find($id);
        $categories = ShopCategory::where('company_id', $this->company->id)->get();
        return view('pages.ecommerce.shopproducts.edit')->with(compact('entry', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $product = ShopProduct::find($id);
        $request->request->add([
            'company_id' => $this->company->id
        ]);
        if ($request->file('thumb_image')) {
            $thumb = $request->file('thumb_image');
            $filename = time().'.'.$thumb->getClientOriginalExtension();
            $thumb->move(storage_path('app/public/uploads/products/thumbnails/'), $filename);
            $request->request->add([
                'thumb' => $filename
            ]);
        }
        // delete removed shipping options
        $rShippingIDs = $request->get('shipping_ids') ?? [];
        $dShippingIDs = $product->shipping->pluck('id')->toArray();
        $deletedIDs = array_filter($dShippingIDs, function($it) use($rShippingIDs) {
            return !in_array($it, $rShippingIDs);
        });
        ShopShippingOption::whereIn('id', $deletedIDs)->delete();
        // update or create shipping options
        if ($request->has('shipping_items')) {
            $shippingNames = $request->get('shipping_items');
            $shippingValues = $request->get('shipping_prices');
            $shippingIDs = $request->get('shipping_ids');
            foreach ($shippingNames as $i => $sName) {
                if ($shippingIDs[$i] > 0) {
                    $shipping = ShopShippingOption::find($shippingIDs[$i]);
                    $shipping->update([
                        'option' => $sName,
                        'price' => $shippingValues[$i]
                    ]);
                } else {
                    ShopShippingOption::create([
                        'product_id' => $product->id,
                        'option' => $sName,
                        'price' => $shippingValues[$i]
                    ]);
                }
            }
        }
        // delete removed sku
        $rskuIDs = $request->get('sku_ids') ?? [];
        $dskuIDs = $product->sku->pluck('id')->toArray();
        $deletedIds = array_filter($dskuIDs, function($it) use($rskuIDs) {
            return !in_array($it, $rskuIDs);
        });
        $willRemovedSkus = ShopProductSku::whereIn('id', $deletedIds)->get();
        foreach($willRemovedSkus as $sk) {
            $sk->items()->delete();
            $sk->delete();
        }
        // update or create sku
        if ($request->has('sku_names')) {
            $skuNames = $request->get('sku_names');
            $skuTypes = $request->get('sku_types');
            $skuItems = $request->get('sku_items');
            $skuPrices = $request->get('sku_prices');
            $skuIDs = $request->get('sku_ids');
            $skuItemIDs = $request->get('sku_item_ids');
            foreach ($skuNames as $i => $skuName) {
                if ($skuIDs[$i] > 0) {
                    $sku = ShopProductSku::find($skuIDs[$i]);
                    $sku->update([
                        'title' => $skuName,
                        'type' => $skuTypes[$i]
                    ]);
                    $rskuItemIDs = $skuItemIDs[$i] ?? [];
                    $dskuItemIDs = $sku->items->pluck('id')->toArray();
                    $deletedIds = array_filter($dskuItemIDs, function($it) use($rskuItemIDs) {
                        return !in_array($it, $rskuItemIDs);
                    });
                    ShopProductSkuItem::whereIn('id', $deletedIds)->delete();
                } else {
                    $sku = ShopProductSku::create([
                        'product_id' => $product->id,
                        'title' => $skuName,
                        'type' => $skuTypes[$i]
                    ]);
                }
                if (isset($skuItems) && isset($skuItems[$i])) {
                    foreach($skuItems[$i] as $j => $si) {
                        if ($skuItemIDs[$i][$j] > 0) {
                            $dSkuItem = ShopProductSkuItem::find($skuItemIDs[$i][$j]);
                            $dSkuItem->update([
                                'title' => $si,
                                'price' => $skuPrices[$i][$j]
                            ]);
                        } else {
                            ShopProductSkuItem::create([
                                'product_sku_id' => $sku->id,
                                'title' => $si,
                                'price' => $skuPrices[$i][$j]
                            ]);
                        }
                    }
                }
            }
        }

        // update main info
        $product->update($request->all());
        return redirect()->route('shopproducts.index');
    }

    public function destroy($id)
    {
        $product = ShopProduct::find($id);
        $skus = $product->sku;
        foreach($skus as $sku) {
            $sku->items()->delete();
            $sku->delete();
        }
        $product->delete();
        return redirect()->route('shopproducts.index');
    }

    public function uploadImageFile(Request $request){
        if($request->file('files')){
            $files = $request->file('files');
            $filenames = array();
            foreach($files as $key => $file) {
                $filename = time().'-'.$key.'.'.$file->getClientOriginalExtension();
                $file->move(storage_path('app/public/uploads/products/'), $filename);
                array_push($filenames, $filename);
            }
            return response()->json([
                'status'=> TRUE,
                'files' => $filenames,
            ], 200);

        }else{
            return response()->json(['status'=> FALSE], 404);
        }
    }

    public function create_digital()
    {
        if ($this->getMaxProductCount() <= $this->getCurrentProductCount() && !$this->user->is_master) {
            return redirect()->route('shopproducts.index', ['tab' => 'digital']);
        }
        $categories = ShopCategory::where('company_id', $this->company->id)->get();
        return view('pages.ecommerce.shopproducts.create-digital')->with([
            'categories' => $categories
        ]);
    }

    public function store_digital(Request $request) {
        $product = ShopProduct::create([
            'company_id' => $this->company->id,
            'title' => $request->title,
            'live' => $request->live,
            'price' => $request->price
        ]);
        $request->request->add([
            'product_id' => $product->id
        ]);
        $digital_info = ShopProductDigital::create($request->all());
        $product->digital_id = $digital_info->id;
        $product->save();

        if ($request->has('sku_names')) {
            $skuNames = $request->get('sku_names');
            $skuTypes = $request->get('sku_types');
            $skuItems = $request->get('sku_items');
            $skuPrices = $request->get('sku_prices');
            foreach ($skuNames as $i => $sName) {
                $sku = ShopProductSku::create([
                    'product_id' => $product->id,
                    'title' => $sName,
                    'type' => $skuTypes[$i]
                ]);
                if (isset($skuItems) && isset($skuItems[$i])) {
                    foreach($skuItems[$i] as $j => $si) {
                        ShopProductSkuItem::create([
                            'product_sku_id' => $sku->id,
                            'title' => $si,
                            'price' => $skuPrices[$i][$j]
                        ]);
                    }
                }
            }
        }
        return redirect()->route('shopproducts.index', ['tab' => 'digital']);
    }

    public function edit_digital($id) {
        $product = ShopProduct::find($id);
        return view('pages.ecommerce.shopproducts.edit-digital')->with([
            'product' => $product
        ]);
    }

    public function update_digital(Request $request, $id) {
        $product = ShopProduct::find($id);
        $product->update([
            'title' => $request->title,
            'live' => $request->live,
            'price' => $request->price
        ]);
        // update digital info
        $digital_info = ShopProductDigital::find($product->digital_id);
        if (!$request->document) {
            $request->request->remove('document');
        }
        $digital_info->update($request->all());
        // delete removed sku
        $rskuIDs = $request->get('sku_ids') ?? [];
        $dskuIDs = $product->sku->pluck('id')->toArray();
        $deletedIds = array_filter($dskuIDs, function($it) use($rskuIDs) {
            return !in_array($it, $rskuIDs);
        });
        $willRemovedSkus = ShopProductSku::whereIn('id', $deletedIds)->get();
        foreach($willRemovedSkus as $sk) {
            $sk->items()->delete();
            $sk->delete();
        }
        // update or create sku
        if ($request->has('sku_names')) {
            $skuNames = $request->get('sku_names');
            $skuTypes = $request->get('sku_types');
            $skuItems = $request->get('sku_items');
            $skuPrices = $request->get('sku_prices');
            $skuIDs = $request->get('sku_ids');
            $skuItemIDs = $request->get('sku_item_ids');
            foreach ($skuNames as $i => $skuName) {
                if ($skuIDs[$i] > 0) {
                    $sku = ShopProductSku::find($skuIDs[$i]);
                    $sku->update([
                        'title' => $skuName,
                        'type' => $skuTypes[$i]
                    ]);
                    $rskuItemIDs = $skuItemIDs[$i] ?? [];
                    $dskuItemIDs = $sku->items->pluck('id')->toArray();
                    $deletedIds = array_filter($dskuItemIDs, function($it) use($rskuItemIDs) {
                        return !in_array($it, $rskuItemIDs);
                    });
                    ShopProductSkuItem::whereIn('id', $deletedIds)->delete();
                } else {
                    $sku = ShopProductSku::create([
                        'product_id' => $product->id,
                        'title' => $skuName,
                        'type' => $skuTypes[$i]
                    ]);
                }
                if (isset($skuItems) && isset($skuItems[$i])) {
                    foreach($skuItems[$i] as $j => $si) {
                        if ($skuItemIDs[$i][$j] > 0) {
                            $dSkuItem = ShopProductSkuItem::find($skuItemIDs[$i][$j]);
                            $dSkuItem->update([
                                'title' => $si,
                                'price' => $skuPrices[$i][$j]
                            ]);
                        } else {
                            ShopProductSkuItem::create([
                                'product_sku_id' => $sku->id,
                                'title' => $si,
                                'price' => $skuPrices[$i][$j]
                            ]);
                        }
                    }
                }
            }
        }
        return redirect()->route('shopproducts.index', ['tab' => 'digital']);
    }

    public function delete_digital($id) {
        $product = ShopProduct::find($id);
        $skus = $product->sku;
        foreach($skus as $sku) {
            $sku->items()->delete();
            $sku->delete();
        }
        $product->digital->delete();
        $product->delete();
        return redirect()->route('shopproducts.index', ['tab' => 'digital']);
    }
}
