<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;

use App\Http\Controllers\MasterController;
use App\Models\AdminUpdate;

class AdminUpdateController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $entries = AdminUpdate::paginate(10);
        return view('pages.update.index')->with(compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.update.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        AdminUpdate::create([
            'message' => $request->message,
            'theme' => $request->theme,
            'closed' => 0
        ]);
        return redirect(route('adminupdates.index'));
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
        $entry = AdminUpdate::find($id);
        return view('pages.update.edit')->with(compact('entry'));
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
        AdminUpdate::find($id)->update($request->all());
        return redirect(route('adminupdates.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AdminUpdate::find($id)->delete();
        return redirect(route('adminupdates.index'));
    }

    public function close($id)
    {
        AdminUpdate::find($id)->update([
            'closed' => 1
        ]);
        return redirect(route('adminupdates.index'));
    }

    public function open($id)
    {
        AdminUpdate::find($id)->update([
            'closed' => 0
        ]);
        return redirect(route('adminupdates.index'));
    }
}
