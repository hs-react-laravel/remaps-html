<?php

namespace App\Http\Controllers\Remaps;

use App\Http\Controllers\MasterController;
use Illuminate\Http\Request;
use App\Models\Shop\ShopOrder;

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
        //
    }
}
