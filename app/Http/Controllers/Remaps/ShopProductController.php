<?php

namespace App\Http\Controllers\Remaps;

use App\Http\Controllers\MasterController;
use App\Models\ShopCategory;
use App\Models\ShopProduct;
use Illuminate\Http\Request;

class ShopProductController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ShopProduct::where('company_id', $this->company->id)->get();
        return view('pages.ecommerce.shopproducts.index')->with([
            'entries' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ShopCategory::get();
        return view('pages.ecommerce.shopproducts.create')->with([
            'categories' => $categories
        ]);
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
        dd($request);
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

    public function uploadImageFile(Request $request){
        // return response()->json($request->all(), 200);
        if($request->file('files')){
            $files = $request->file('files');
            $filenames = array();
            foreach($files as $file) {
                $filename = time() . '.' . $file->getClientOriginalExtension();
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
}
