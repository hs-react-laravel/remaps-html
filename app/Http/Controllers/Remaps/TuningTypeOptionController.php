<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TuningTypeOptionRequest;
use App\Models\TuningTypeOption;
use App\Models\TuningTypeGroup;

class TuningTypeOptionController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tuningTypeId)
    {
        $user = $this->user;
        $entries = TuningTypeOption::where('tuning_type_id', $tuningTypeId)
            ->whereHas('tuningType', function($query) use($user){
                return $query->where('company_id', $user->company_id);
            })->orderBy('order_as', 'ASC')->paginate(20);
        return view('pages.tuning-types.options.index', [
            'entries' => $entries,
            'typeId' => $tuningTypeId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tuningTypeId)
    {
        return view('pages.tuning-types.options.create', [
            'typeId' => $tuningTypeId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TuningTypeOptionRequest $request)
    {
        $tuningTypeId = $request->route('id');
        $request->request->add([
            'tuning_type_id'=> $tuningTypeId,
            'order_as' => TuningTypeOption::where('tuning_type_id',$tuningTypeId)->count()
        ]);
        $new_option = TuningTypeOption::create($request->all());
        $system_default_group = TuningTypeGroup::where('company_id', $this->company->id)->where('is_system_default', 1)->first();
        $system_default_group->tuningTypeOptions()->attach($new_option->id, ['for_credit' => $new_option->credits]);
        if ($this->user->is_semi_admin) {
            return redirect(route('staff.options.index', ['id' => $tuningTypeId]));
        }
        return redirect(route('options.index', ['id' => $tuningTypeId]));
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
    public function edit($tuningTypeId, $optionId)
    {
        $entry = TuningTypeOption::find($optionId);
        return view('pages.tuning-types.options.edit', [
            'typeId' => $tuningTypeId,
            'entry' => $entry,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TuningTypeOptionRequest $request, $tuningTypeId, $optionId)
    {
        $entry = TuningTypeOption::find($optionId);
        $entry->update($request->all());
        $system_default_group = TuningTypeGroup::where('company_id', $this->company->id)->where('is_system_default', 1)->first();
        $system_default_group->tuningTypeOptions()->detach($entry->id);
        $system_default_group->tuningTypeOptions()->attach($entry->id, ['for_credit' => $entry->credits]);
        if ($this->user->is_semi_admin) {
            return redirect(route('staff.options.index', ['id' => $tuningTypeId]));
        }
        return redirect(route('options.index', ['id' => $tuningTypeId]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tuningTypeId, $optionId)
    {
        $entry = TuningTypeOption::find($optionId);
        $system_default_group = TuningTypeGroup::where('company_id', $this->company->id)->where('is_system_default', 1)->first();
        $system_default_group->tuningTypeOptions()->detach($entry->id);
        $entry->delete();
        if ($this->user->is_semi_admin) {
            return redirect(route('staff.options.index', ['id' => $tuningTypeId]));
        }
        return redirect(route('options.index', ['id' => $tuningTypeId]));
    }

    public function upSort($tuningTypeId, $optionId)
    {
        $current = TuningTypeOption::find($optionId);
        $upOne = TuningTypeOption::where('tuning_type_id', $tuningTypeId)->where('order_as', '<', $current->order_as)->orderBy('order_as', 'DESC')->first();
        if ($upOne) {
            $currentOrder = $current->order_as;
            $current->order_as = $upOne->order_as;
            $upOne->order_as = $currentOrder;
            $current->save();
            $upOne->save();
        }
        if ($this->user->is_semi_admin) {
            return redirect(route('staff.options.index', ['id' => $tuningTypeId]));
        }
        return redirect(route('options.index', ['id' => $tuningTypeId]));
    }
    public function downSort($tuningTypeId, $optionId)
    {
        $current = TuningTypeOption::find($optionId);
        $upOne = TuningTypeOption::where('tuning_type_id', $tuningTypeId)->where('order_as', '>', $current->order_as)->orderBy('order_as', 'ASC')->first();
        if ($upOne) {
            $currentOrder = $current->order_as;
            $current->order_as = $upOne->order_as;
            $upOne->order_as = $currentOrder;
            $current->save();
            $upOne->save();
        }
        if ($this->user->is_semi_admin) {
            return redirect(route('staff.options.index', ['id' => $tuningTypeId]));
        }
        return redirect(route('options.index', ['id' => $tuningTypeId]));
    }
}
