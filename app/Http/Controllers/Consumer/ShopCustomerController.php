<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\MasterController;
use App\Models\ShopProduct;
use Illuminate\Http\Request;

class ShopCustomerController extends MasterController
{
    public function index()
    {
        $products = ShopProduct::where('company_id', $this->company->id)->where('live', 1)->paginate(9);
        // dd($products);
        return view('pages.consumers.ec.index')->with(compact('products'));
    }
}
