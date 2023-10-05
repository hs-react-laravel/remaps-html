<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;

use App\Http\Controllers\MasterController;
use App\Models\AdminUpdate;
use App\Models\AdminupdateRead;
use App\Models\Company;
use App\Models\Content;

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
        $adminupdate = AdminUpdate::create([
            'message' => $request->message,
            'theme' => $request->theme,
            'closed' => 0
        ]);
        $companies = Company::all();
        foreach($companies as $c) {
            AdminupdateRead::create([
                'adminupdate_id' => $adminupdate->id,
                'company_id' => $c->id,
                'is_read' => 0
            ]);
        }

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
        $adminupdate = AdminUpdate::find($id);
        $adminupdate->update($request->all());

        AdminupdateRead::where('adminupdate_id', $id)->delete();
        $companies = Company::all();
        foreach($companies as $c) {
            AdminupdateRead::create([
                'adminupdate_id' => $adminupdate->id,
                'company_id' => $c->id,
                'is_read' => 0
            ]);
        }

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

    public function bottom()
    {
        $entry = Content::where('key', 'BOTTOM_UPDATE')->first();
        return view('pages.update.bottom')->with(compact('entry'));
    }

    public function bottom_post(Request $request)
    {
        $entry = Content::where('key', 'BOTTOM_UPDATE')->first();
        $entry->update([
            'body' => $request->body
        ]);
        return redirect(route('adminupdates.index'));
    }
}
