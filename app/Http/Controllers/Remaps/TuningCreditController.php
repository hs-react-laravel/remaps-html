<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TuningCreditGroup;
use App\Models\TuningCreditTire;

class TuningCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = TuningCreditGroup::where('company_id', $this->user->company_id)
            ->where('group_type', 'normal')
            ->orderBy('id', 'DESC')
            ->get();
        $tires = TuningCreditTire::where('company_id', $this->user->company_id)
            ->where('group_type', 'normal')
            ->orderBy('amount', 'ASC')
            ->get();
        return view('pages.tuning-credits.index', [
            'entries' => $entries,
            'tires' => $tires,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tires = TuningCreditTire::where('company_id', $this->user->company_id)
            ->where('group_type', 'normal')
            ->orderBy('amount', 'ASC')
            ->get();
        return view('pages.tuning-credits.create', ['tires' => $tires]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add(['company_id'=> $this->company->id]);
        $request->request->add(['group_type'=> 'normal']);
        $tuningCreditGroup = TuningCreditGroup::create($request->all());
        if($request->has('credit_tires')){
            $tuningCreditGroup->tuningCreditTires()->sync($request->credit_tires);
        }
        return redirect(route('tuning-credits.index'));
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
        $group = TuningCreditGroup::find($id);
        $tires = TuningCreditTire::where('company_id', $this->user->company_id)
            ->where('group_type', 'normal')
            ->orderBy('amount', 'ASC')
            ->get();
        return view('pages.tuning-credits.edit', [
            'entry' => $group,
            'tires' => $tires,
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
        $tuningCreditGroup = TuningCreditGroup::find($id);
        $tuningCreditGroup->update($request->all());
        if($request->has('credit_tires')){
            $tuningCreditGroup->tuningCreditTires()->sync($request->credit_tires);
        }
        return redirect(route('tuning-credits.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tuningCreditGroup = TuningCreditGroup::find($id);
        $tuningCreditGroup->delete();
        return redirect(route('tuning-credits.index'));
    }

    public function set_default($id)
    {
        TuningCreditGroup::where('company_id', $this->user->company_id)
            ->where('group_type', 'normal')
            ->update([
                'set_default_tier' => 0
            ]);
        TuningCreditGroup::find($id)->update([
            'set_default_tier' => 1
        ]);
        return redirect(route('tuning-credits.index'));
    }

    public function delete_tire($id)
    {
        $tire = TuningCreditTire::find($id);
        $tire->delete();
        return redirect(route('tuning-credits.index'));
    }

    public function add_tire()
    {
        return view('pages.tuning-credits.add_tire');
    }

    public function store_tire(Request $request)
    {
        $request->request->add(['company_id'=> $this->company->id, 'group_type' => 'normal']);
        TuningCreditTire::create($request->all());
        return redirect(route('tuning-credits.index'));
    }
}
