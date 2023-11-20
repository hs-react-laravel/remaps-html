<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MasterController;
use App\Http\Requests\SliderManagerRequest;
use App\Models\SliderManager;

class SliderManagerController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->check_master();
        $entries = SliderManager::get();
        return view('pages.sliders.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->check_master();
        return view('pages.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderManagerRequest $request)
    {
        if ($request->file('upload_file')) {
            $file = $request->file('upload_file');
            $res = Storage::disk('azure')->put('logo', $file);
            $request->request->add(['logo' => $res]);
        }
        SliderManager::create($request->all());
        return redirect(route('slidermanagers.index'));
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
        $entry = SliderManager::find($id);
        return view('pages.sliders.edit', compact('entry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderManagerRequest $request, $id)
    {
        if ($request->file('upload_file')) {
            $file = $request->file('upload_file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/logo'), $filename);
            $request->request->add(['image' => $filename]);
        }
        SliderManager::find($id)->update($request->all());
        return redirect(route('slidermanagers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SliderManager::find($id)->delete();
        return redirect(route('slidermanagers.index'));
    }
}
