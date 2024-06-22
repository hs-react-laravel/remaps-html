<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TuningTypeRequest;
use App\Models\TuningType;
use App\Models\TuningTypeGroup;
use App\Models\Company;

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
        $request->request->add([
            'company_id'=> $this->company->id,
            'order_as' => TuningType::where('company_id', $this->company->id)->count() + 1,
        ]);
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

    public function group_index()
    {
        $entries = TuningTypeGroup::where('company_id', $this->company->id)->paginate(20);

        return view('pages.tuning-types.groups.index', [
            'entries' => $entries
        ]);
    }

    public function group_create()
    {
        $types = TuningType::where('company_id', $this->company->id)->get();
        return view('pages.tuning-types.groups.create', [
            'types' => $types
        ]);
    }

    public function group_store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'includedTypes' => ['required']
        ]);

        $group = TuningTypeGroup::create([
            'company_id' => $this->company->id,
            'name' => $request->name
        ]);

        $includedTypes = $request->includedTypes;
        $sync_types = array_filter($request->type_credits, function($k) use($includedTypes){
            return in_array($k, $includedTypes);
        }, ARRAY_FILTER_USE_KEY);
        $group->tuningTypes()->sync($sync_types);

        $applied_options = array_filter($request->option_credits, function($k) use($includedTypes){
            return in_array($k, $includedTypes);
        }, ARRAY_FILTER_USE_KEY);
        $sync_options = [];
        foreach ($applied_options as $so) {
            $sync_options = $sync_options + $so;
        }
        $group->tuningTypeOptions()->sync($sync_options);

        return redirect(route('tuning-types.group.index'));
    }

    public function group_edit($id)
    {
        $group = TuningTypeGroup::find($id);
        if (!$group) return redirect(route('tuning-types.group.index'));

        $includedTypeIDs = $group->tuningTypes()->pluck('id')->toArray();
        $types = TuningType::where('company_id', $this->company->id)->get();
        $inTypes = TuningType::where('company_id', $this->company->id)->whereIn('id', $includedTypeIDs)->get();
        $exTypes = TuningType::where('company_id', $this->company->id)->whereNotIn('id', $includedTypeIDs)->get();

        $optionIDs = $group->tuningTypeOptions()->pluck('id')->toArray();
        foreach($types as $t) {
            $t->includedOptions = $t->tuningTypeOptions()->whereIn('id', $optionIDs)->get();
            $t->excludedOptions = $t->tuningTypeOptions()->whereNotIn('id', $optionIDs)->get();
        }

        return view('pages.tuning-types.groups.edit', [
            'types' => $types,
            'inTypes' => $inTypes,
            'exTypes' => $exTypes,
            'group' => $group
        ]);
    }

    public function group_update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'includedTypes' => ['required']
        ]);

        $group = TuningTypeGroup::find($id);
        if (!$group) return redirect(route('tuning-types.group.index'));

        $group->tuningTypes()->sync([]);
        $group->tuningTypeOptions()->sync([]);

        $includedTypes = $request->includedTypes;
        $sync_types = array_filter($request->type_credits, function($k) use($includedTypes){
            return in_array($k, $includedTypes);
        }, ARRAY_FILTER_USE_KEY);
        $group->tuningTypes()->sync($sync_types);

        $applied_options = array_filter($request->option_credits, function($k) use($includedTypes){
            return in_array($k, $includedTypes);
        }, ARRAY_FILTER_USE_KEY);
        $sync_options = [];
        foreach ($applied_options as $so) {
            $sync_options = $sync_options + $so;
        }
        $group->tuningTypeOptions()->sync($sync_options);

        return redirect(route('tuning-types.group.index'));
    }

    public function group_default($id)
    {
        $group = TuningTypeGroup::find($id);
        if (!$group) return redirect(route('tuning-types.group.index'));

        TuningTypeGroup::query()->where('company_id', $this->company->id)->update(['is_default' => 0]);
        $group->update(['is_default' => 1]);

        return redirect(route('tuning-types.group.index'));
    }

    public function group_destroy($id)
    {
        $group = TuningTypeGroup::find($id);
        if (!$group) return redirect(route('tuning-types.group.index'));

        $group->tuningTypes()->sync([]);
        $group->tuningTypeOptions()->sync([]);
        $group->delete();

        return redirect(route('tuning-types.group.index'));
    }

    public function createDefaultGroup($company_id)
    {
        $types = TuningType::where('company_id', $company_id)->get();

        $sync_types = [];
        $sync_options = [];
        foreach ($types as $t) {
            $sync_types[$t->id]['for_credit'] = $t->credits;
            $typeOptions = $t->tuningTypeOptions()->select('id', 'credits')->get();
            foreach ($typeOptions as $to) {
                $sync_options[$to->id] = [
                    'for_credit' => $to->credits
                ];
            }
        }

        $default = TuningTypeGroup::create([
            'company_id' => $company_id,
            'name' => "Default",
            'is_default' => 1
        ]);
        $default->tuningTypes()->sync($sync_types);
        $default->tuningTypeOptions()->sync($sync_options);

        $company = Company::find($company_id);
        $company->users()->update(['tuning_type_group_id' => $default->id]);
    }
}
