<?php

namespace App\Http\Controllers\Remaps\Shop;

use App\Http\Controllers\MasterController;
use App\Models\Guide;
use Illuminate\Http\Request;

class ShopGuideController extends MasterController
{
    //
    public function index() {
        $guide = Guide::where('message_id', 'shop_guide')->first();
        if (!$guide) $guide = new Guide;
        return view('pages.guide.shop')->with(compact('guide'));
    }

    public function store(Request $request) {
        $request->request->add([
            'message_id' => 'shop_guide'
        ]);
        $guide = Guide::where('message_id', 'shop_guide')->first();
        if ($guide) {
            $guide->update($request->all());
        } else {
            Guide::create($request->all());
        }
        return redirect()->route('shop.guide');
    }
}
