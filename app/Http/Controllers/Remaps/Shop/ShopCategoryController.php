<?php

namespace App\Http\Controllers\Remaps\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Models\Shop\ShopCategory;

class ShopCategoryController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->check_master();
        return view('pages.ecommerce.shopcategory.index')->with([
            'entries' => ShopCategory::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->check_master();
        return view('pages.ecommerce.shopcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->check_master();
        ShopCategory::create($request->all());
        return redirect()->route('shopcategories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->check_master();
        $sc = ShopCategory::find($id);
        return view('pages.ecommerce.shopcategory.edit')->with([
            'entry' => $sc
        ]);
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
        $this->check_master();
        $sc = ShopCategory::find($id);
        $sc->update($request->all());
        return redirect()->route('shopcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->check_master();
        ShopCategory::find($id)->delete();
        return redirect()->route('shopcategories.index');
    }
}
