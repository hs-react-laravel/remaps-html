<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FileService;
use App\Models\TuningCreditGroup;
use App\Models\Transaction;
use App\Http\Controllers\MasterController;
use App\Http\Requests\CustomerRequest;
use App\Mail\WelcomeCustomer;
use App\Models\TuningType;
use Illuminate\Support\Facades\Mail;

class CustomerController extends MasterController
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
            ->whereNull('is_staff')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('pages.customer.index', [
            'users' => $users
        ]);
    }

    public function api(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length');

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        if ($columnName == 'name') $columnName = 'last_login';
        if ($columnName == 'company') $columnName = 'business_name';
        if ($columnName == 'tuning_price_group') $columnName = 'tuning_credit_group_id';
        if ($columnName == 'evc_tuning_price_group') $columnName = 'tuning_evc_credit_group_id';

        $user = User::find($request->id);
        $query = User::where('company_id', $user->company_id)
            ->where('is_admin', 0)
            ->whereNull('is_staff');

        $totalRecords = $query->count();
        $query = $query->where(function($query) use ($searchValue) {
            $query->where('first_name', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('last_name', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('business_name', 'LIKE', '%'.$searchValue.'%');
        });
        $totalRecordswithFilter = $query->count();
        $entries = $query->orderBy($columnName, $columnSortOrder)->skip($start)->take($rowperpage)->get();
        $return_data = [];
        foreach($entries as $entry) {
            array_push($return_data, [
                'name' => $entry->fullName,
                'email' => $entry->email,
                'company' => $entry->business_name,
                'tuning_credits' => number_format($entry->tuning_credits, 2),
                'tuning_price_group' => $entry->tuningPriceGroup,
                'evc_tuning_price_group' => $entry->tuning_evc_price_group,
                'fileservice_ct' => $entry->fileServicesCount,
                'last_login' => $entry->lastLoginDiff,
                'is_verified' => $entry->is_verified,
                'is_blocked' => $entry->is_blocked,
                'actions' => '',
                'route.edit' => route('customers.edit', ['customer' => $entry->id]), // edit route
                'route.fs' => route('customer.fs', ['id' => $entry->id]), // file service route
                'route.sa' => route('customer.sa', ['id' => $entry->id]), // switch account route
                'route.tr' => route('customer.tr', ['id' => $entry->id]), // transaction route
                'route.rp' => route('customer.rp', ['id' => $entry->id]), // transaction route
                'route.destroy' => route('customers.destroy', $entry->id), // destroy route
                'route.block' => route('customer.block', $entry->id), // destroy route
                'route.allow' => route('customer.allow', $entry->id), // destroy route
            ]);
        }
        $json_data = array(
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordswithFilter,
            'data' => $return_data
        );

        return response()->json($json_data);
    }

    public function resetPasswordLink($id) {
        try{
            $user = User::find($id);
            $token = app('auth.password.broker')->createToken($user);
            Mail::to($user->email)->send(new WelcomeCustomer($user, $token));
        }catch(\Exception $e){
            session()->flash('error', __('admin.opps'));
        }
        return redirect()->back();
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
        $defaultGroup = TuningCreditGroup::where('company_id', $this->company->id)
            ->where('group_type', 'normal')
            ->where('set_default_tier', 1)->first();
        $evcTuningGroups = TuningCreditGroup::where('company_id', $user->company_id)
            ->where('group_type', 'evc')
            ->orderBy('is_default', 'DESC')
            ->pluck('name', 'id');
        $evcdefaultGroup = TuningCreditGroup::where('company_id', $this->company->id)
            ->where('group_type', 'evc')
            ->where('set_default_tier', 1)->first();
        $tuningTypes = TuningType::where('company_id', $this->user->company_id)
            ->orderBy('order_as', 'ASC')
            ->pluck('label', 'id');
        $langs = config('constants.langs');
        return view('pages.customer.create', compact('tuningGroups', 'langs', 'evcTuningGroups', 'defaultGroup', 'evcdefaultGroup', 'tuningTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        try {
            $request->request->add(['company_id'=> $this->company->id]);
            $user = User::create($request->all());
            $token = app('auth.password.broker')->createToken($user);
			try{
                Mail::to($user->email)->send(new WelcomeCustomer($user, $token));
			}catch(\Exception $e) {
                session()->flash('error', $e->getMessage());
			}
            return redirect(route('customers.index'));
        } catch(\Exception $e){
            session()->flash('error', $e->getMessage());
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
        $evcTuningGroups = TuningCreditGroup::where('company_id', $this->user->company_id)
            ->where('group_type', 'evc')
            ->orderBy('is_default', 'DESC')
            ->pluck('name', 'id');
        $langs = config('constants.langs');
        return view('pages.customer.edit', compact('customer', 'langs', 'tuningGroups', 'evcTuningGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request)
    {
        $id = $request->route('customer');
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
        $customer = User::find($id);
        $customer->delete();
        return redirect(route('customers.index'));
    }

    public function fileServices($id)
    {
        try{
            $user = User::find($id);
            if($this->company->id != $user->company->id){
                abort(403, __('admin.no_permission'));
            }

            $customers = $this->company->users;
            $customer_id = $id;
            return view('pages.fileservice.index', compact('customers', 'customer_id'));
        }catch(\Exception $e){
            session()->flash('error', __('admin.opps'));
            return redirect(route('customers.index'));
        }
    }

    public function switchAccount($id)
    {
        try{
            $user = User::find($id);
            if ($user->is_staff) {
                Auth::guard('staff')->login($user);
                return redirect()->away(url('staff/dashboard'));
            } else {
                Auth::guard('customer')->login($user);
                return redirect()->away(url('customer/dashboard'));
            }
        }catch(\Exception $e){
            session()->flash('error', __('admin.opps'));
            return redirect(url('admin/customer'));
        }
    }

    public function transactions($id) {
        try{
            $user = User::find($id);
            if($this->company->id != $user->company->id){
                abort(403, __('admin.no_permission'));
            }
            $entries = $user->transactions()->orderBy('id', 'DESC')->paginate(20);
            return view('pages.customer.transaction', compact('id', 'entries'));
        }catch(\Exception $e){
            session()->flash('error', __('admin.opps'));
            return redirect(route('customers.index'));
        }
    }

    public function transactions_post(Request $request, $id) {
        try{
            $request->request->add(['status'=>'Completed']);
            $transaction = new Transaction($request->all());
            $user = $transaction->user;
            if($transaction->save()){
                if($transaction->type == 'A'){
                    $totalCredits = ($user->tuning_credits + $transaction->credits);
                }else{
                   $totalCredits = ($user->tuning_credits - $transaction->credits);
                }
                $user->tuning_credits = $totalCredits;
                $user->save();
                session()->flash('message', __('admin.transaction_saved'));
            }else{
                session()->flash('error', __('admin.opps'));
            }
            return redirect(route('customer.tr', ['id' => $id]));
        }catch(\Exception $e){
            session()->flash('error', __('admin.opps'));
        }
        return redirect(route('customers.index'));
    }

    public function transactions_post_evc(Request $request, $id) {
        try{
            $request->request->add(['status'=>'Completed']);
            $transaction = new \App\Models\Transaction($request->all());
            $user = $transaction->user;

            $url = "https://evc.de/services/api_resellercredits.asp";
            $dataArray = array(
                'apiid'=>'j34sbc93hb90',
                'username'=> $user->company->reseller_id,
                'password'=> $user->company->reseller_password,
                'verb'=>'addcustomeraccount',
                'customer' => $user->reseller_id,
                'credits' => $transaction->credits
            );
            $ch = curl_init();
            $data = http_build_query($dataArray);
            $getUrl = $url."?".$data;
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $getUrl);
            curl_setopt($ch, CURLOPT_TIMEOUT, 500);

            $response = curl_exec($ch);
            if (strpos($response, 'ok') !== FALSE) {
                $transaction->save();
            }
            return redirect(route('customer.tr', ['id' => $id]));
        }catch(\Exception $e){
            session()->flash('error', __('admin.opps'));
        }
        return redirect(route('customers.index'));
    }

    public function block(Request $request, $id) {
        $customer = User::find($id);
        if ($customer) {
            $customer->is_blocked = 1;
            $customer->save();
            $customer->delete();
        }
        return redirect()->back();
    }

    public function allow(Request $request, $id) {
        $customer = User::find($id);
        if ($customer) {
            $customer->is_verified = 1;
            $customer->save();
            $token = app('auth.password.broker')->createToken($customer);
            Mail::to($customer->email)->send(new WelcomeCustomer($customer, $token));
        }
        return redirect()->back();
    }

    public function unblock(Request $request, $id) {
        $customer = User::find($id);
        if ($customer) {
            $customer->is_blocked = 0;
            $customer->save();
        }
        return redirect()->back();
    }
}
