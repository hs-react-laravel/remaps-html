<?php

namespace App\Http\Controllers\Remaps\Shop;

use App\Helpers\Helper;
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
    private function getMaxProductCount($mode) {
        $maxProductCt = 50;
        $isActive = $this->company->hasActiveShopSubscription($mode);
        if ($isActive) {
            $sub = $this->company->getActiveShopSubscription($mode);
            $maxProductCt = $sub->package->product_count;
        }
        return $maxProductCt;
    }

    private function checkMembership($mode) {
        $cpt = $this->getCurrentProductCount($mode);
        $mpt = $this->getMaxProductCount($mode);
        if ($cpt > $mpt) {
            $products = ShopProduct::where('company_id', $this->company->id);
            if ($mode == 1) {
                $products = $products->whereNull('digital_id')->take($mpt)->pluck('id')->toArray();
            } else if ($mode == 2) {
                $products = $products->whereNotNull('digital_id')->take($mpt)->pluck('id')->toArray();
            }
            ShopProduct::where('company_id', $this->company->id)
                ->whereNotIn('id', $products)
                ->update([
                    'live' => 0
                ]);
        }
    }

    private function getCurrentProductCount($mode) {
        if ($mode == 1)
            return ShopProduct::where('company_id', $this->company->id)->whereNull('digital_id')->count();
        else
            return ShopProduct::where('company_id', $this->company->id)->whereNotNull('digital_id')->count();
    }

    public function index()
    {
        $tab = request()->get('tab') ?? 'tool';
        $mode = $tab == 'tool' ? 1 : 2;

        $this->checkMembership($mode);
        $maxProductCt = $this->getMaxProductCount($mode);
        $entries = ShopProduct::where('company_id', $this->company->id)->whereNull('digital_id')->paginate(10);
        if ($tab == 'digital') {
            $entries = ShopProduct::where('company_id', $this->company->id)->whereNotNull('digital_id')->paginate(10);
        }

        return view('pages.ecommerce.shopproducts.index')->with(compact('entries', 'maxProductCt'));
    }

    public function create()
    {
        $categoryTree = Helper::categoryTree($this->company->id, 'tool');
        if ($this->getMaxProductCount(1) <= $this->getCurrentProductCount(1) && !$this->user->is_master) {
            if ($this->user->is_semi_admin) {
                return redirect(route('staff.shopproducts.index'));
            }
            return redirect()->route('shopproducts.index');
        }
        return view('pages.ecommerce.shopproducts.create')->with([
            'categoryTree' => $categoryTree
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
        if ($this->user->is_semi_admin) {
            return redirect(route('staff.shopproducts.index'));
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
        $categoryTree = Helper::categoryTree($this->company->id, 'tool', [$entry->category_id]);
        return view('pages.ecommerce.shopproducts.edit')->with(compact('entry', 'categoryTree'));
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
        if ($this->user->is_semi_admin) {
            return redirect(route('staff.shopproducts.index'));
        }
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
        if ($this->user->is_semi_admin) {
            return redirect(route('staff.shopproducts.index'));
        }
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
        if ($this->getMaxProductCount(2) <= $this->getCurrentProductCount(2) && !$this->user->is_master) {
            if ($this->user->is_semi_admin) {
                return redirect()->route('staff.shopproducts.index', ['tab' => 'digital']);
            }
            return redirect()->route('shopproducts.index', ['tab' => 'digital']);
        }
        $categoryTree = Helper::categoryTree($this->company->id, 'digital');
        return view('pages.ecommerce.shopproducts.create-digital')->with([
            'categoryTree' => $categoryTree
        ]);
    }

    public function store_digital(Request $request) {
        $product = ShopProduct::create([
            'company_id' => $this->company->id,
            'title' => $request->title,
            'brand' => $request->make,
            'live' => $request->live,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
        ]);
        $request->request->add([
            'product_id' => $product->id
        ]);
        $digital_info = ShopProductDigital::create($request->all());
        $product->digital_id = $digital_info->id;
        $product->save();
        if ($this->user->is_semi_admin) {
            return redirect()->route('staff.shopproducts.index', ['tab' => 'digital']);
        }
        return redirect()->route('shopproducts.index', ['tab' => 'digital']);
    }

    public function edit_digital($id) {
        $product = ShopProduct::find($id);
        $categoryTree = Helper::categoryTree($this->company->id, 'digital', [$product->category_id]);
        return view('pages.ecommerce.shopproducts.edit-digital')->with([
            'product' => $product,
            'categoryTree' => $categoryTree
        ]);
    }

    public function update_digital(Request $request, $id) {
        $product = ShopProduct::find($id);
        $product->update([
            'title' => $request->title,
            'live' => $request->live,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);
        // update digital info
        $digital_info = ShopProductDigital::find($product->digital_id);
        if (!$request->document) {
            $request->request->remove('document');
        }
        $digital_info->update($request->all());
        if ($this->user->is_semi_admin) {
            return redirect()->route('staff.shopproducts.index', ['tab' => 'digital']);
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
        if ($this->user->is_semi_admin) {
            return redirect()->route('staff.shopproducts.index', ['tab' => 'digital']);
        }
        return redirect()->route('shopproducts.index', ['tab' => 'digital']);
    }
}
