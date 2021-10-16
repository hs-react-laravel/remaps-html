<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TuningCreditGroup;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::where('company_id', $this->user->company_id)
            ->where('is_admin', 0)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('pages.customer.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = $this->user;
        $tuningGroups = TuningCreditGroup::where('company_id', $user->company_id)
            ->where('group_type', 'normal')
            ->orderBy('is_default', 'DESC')
            ->pluck('name', 'id');
        $langs = config('constants.langs');
        return view('pages.customer.create', [
            'tuningGroups' => $tuningGroups,
            'langs' => $langs,
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
        try{
            $request->request->add(['company_id'=> $this->company->id]);
            $user = User::create($request->all());
            $token = app('auth.password.broker')->createToken($user);
            // Log::create([
            //     'staff_id' => $user->id,
            //     'table' => 'Customer',
            //     'action' => 'CREATE',
            //     'id' => $this->crud->entry->id,
            // ]);
			// try{
            // 	Mail::to($user->email)->send(new WelcomeCustomer($user, $token));
			// }catch(\Exception $e){
			// 	Alert::error('Error in SMTP: '.__('admin.opps'))->flash();
			// }
            return redirect(route('customers.index'));
        }catch(\Exception $e){
            // Alert::error(__('admin.opps'))->flash();
            return redirect(route('customers.index'));
        }
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
        $customer = User::find($id);
        $tuningGroups = TuningCreditGroup::where('company_id', $this->user->company_id)
            ->where('group_type', 'normal')
            ->orderBy('is_default', 'DESC')
            ->pluck('name', 'id');
        $langs = config('constants.langs');
        return view('pages.customer.edit', [
            'customer' => $customer,
            'tuningGroups' => $tuningGroups,
            'langs' => $langs
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
        User::find($id)->update($request->all());
        return redirect(route('customers.index'));
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
        $customer = User::find($id);
        $customer->delete();
        return redirect(route('customers.index'));
    }
}
