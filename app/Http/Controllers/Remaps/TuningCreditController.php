<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TuningCreditGroupRequest;
use App\Http\Requests\TuningCreditTireRequest;
use App\Models\TuningCreditGroup;
use App\Models\TuningCreditTire;

class TuningCreditController extends MasterController
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
            'group_type' => 'normal'
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
        return view('pages.tuning-credits.create', ['tires' => $tires, 'group_type' => 'normal']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TuningCreditGroupRequest $request)
    {
        $request->request->add(['company_id'=> $this->company->id]);
        $request->request->add(['group_type'=> 'normal']);
        $tuningCreditGroup = TuningCreditGroup::create($request->all());
        if($request->has('credit_tires')){
            $tuningCreditGroup->tuningCreditTires()->sync($request->credit_tires);
        }
        return redirect(route('tuning-credits.index'));
    }

    public function createDefaultGroup($company_id)
    {
        $tires = TuningCreditTire::where('company_id', $company_id)
            ->where('group_type', 'normal')
            ->orderBy('amount', 'ASC')
            ->get();
        $sync = [];
        foreach ($tires as $to) {
            $sync[$to->id] = [
                'from_credit' => $to->amount,
                'for_credit' => $to->amount
            ];
        }
        $default = TuningCreditGroup::create([
            'company_id' => $company_id,
            'name' => "System Default",
            'group_type' => 'normal',
            'is_system_default' => 1
        ]);
        $default->tuningCreditTires()->sync($sync);
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
            'group_type' => 'normal'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TuningCreditGroupRequest $request)
    {
        $tuningCreditGroup = TuningCreditGroup::find($request->route('tuning_credit'));
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
        if ($tuningCreditGroup->set_default_tier) {
            $system_default_group = TuningCreditGroup::where('company_id', $this->company->id)
                ->where('is_system_default', 1)->first();
            $system_default_group->update([
                'set_default_tier' => 1
            ]);
        }
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
        return view('pages.tuning-credits.add_tire', ['group_type' => 'normal']);
    }

    public function store_tire(TuningCreditTireRequest $request)
    {
        $request->request->add(['company_id'=> $this->company->id, 'group_type' => 'normal']);
        TuningCreditTire::create($request->all());
        return redirect(route('tuning-credits.index'));
    }
}
