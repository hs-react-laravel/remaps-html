<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TuningTypeRequest;
use App\Models\TuningType;

class TuningTypeController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $entries = TuningType::where('company_id', $this->user->company_id)->orderBy('order_as', 'ASC')->paginate(20);
        return view('pages.tuning-types.index', [
            'entries' => $entries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.tuning-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TuningTypeRequest $request)
    {
        $request->request->add(['company_id'=> $this->company->id]);
        TuningType::create($request->all());
        return redirect(route('tuning-types.index'));
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
        $entry = TuningType::find($id);
        return view('pages.tuning-types.edit', ['entry' => $entry]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TuningTypeRequest $request)
    {
        $entry = TuningType::find($request->route('tuning_type'));
        $entry->update($request->all());
        return redirect(route('tuning-types.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TuningType::find($id)->delete();
        return redirect(route('tuning-types.index'));
    }

    public function upSort($id)
    {
        $current = TuningType::find($id);
        $upOne = TuningType::where('company_id', $this->company->id)->where('order_as', '<', $current->order_as)->orderBy('order_as', 'DESC')->first();
        if ($upOne) {
            $currentOrder = $current->order_as;
            $current->order_as = $upOne->order_as;
            $upOne->order_as = $currentOrder;
            $current->save();
            $upOne->save();
        }
        return redirect(route('tuning-types.index'));
    }
    public function downSort($id)
    {
        $current = TuningType::find($id);
        $upOne = TuningType::where('company_id', $this->company->id)->where('order_as', '>', $current->order_as)->orderBy('order_as', 'ASC')->first();
        if ($upOne) {
            $currentOrder = $current->order_as;
            $current->order_as = $upOne->order_as;
            $upOne->order_as = $currentOrder;
            $current->save();
            $upOne->save();
        }
        return redirect(route('tuning-types.index'));
    }
}
