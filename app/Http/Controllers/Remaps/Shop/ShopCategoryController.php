<?php

namespace App\Http\Controllers\Remaps\Shop;

use App\Helpers\Helper;
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
        return view('pages.ecommerce.shopcategory.index')->with([
            'entries' => ShopCategory::where('company_id', $this->company->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $tree = Helper::categoryTree($this->company->id);
        return view('pages.ecommerce.shopcategory.create')->with(compact('tree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add([
            'company_id' => $this->company->id
        ]);
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
        ShopCategory::find($id)->delete();
        return redirect()->route('shopcategories.index');
    }
}
