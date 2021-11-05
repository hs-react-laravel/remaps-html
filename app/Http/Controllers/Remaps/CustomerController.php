<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\TuningCreditGroup;
use App\Models\Transaction;
use App\Http\Controllers\MasterController;
use App\Http\Requests\CustomerRequest;
use App\Mail\WelcomeCustomer;
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
        $evcTuningGroups = TuningCreditGroup::where('company_id', $user->company_id)
            ->where('group_type', 'evc')
            ->orderBy('is_default', 'DESC')
            ->pluck('name', 'id');
        $langs = config('constants.langs');
        return view('pages.customer.create', compact('tuningGroups', 'langs', 'evcTuningGroups'));
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
                session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
			}
            return redirect(route('customers.index'));
        } catch(\Exception $e){
            session()->flash('error', __('admin.opps'));
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
    public function update(CustomerRequest $request, $id)
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
            $entries = $user->fileServices()->orderBy('id', 'DESC')->paginate(20);
            return view('pages.fileservice.index', ['entries' => $entries]);
        }catch(\Exception $e){
            session()->flash('error', __('admin.opps'));
            return redirect(route('customers.index'));
        }
    }

    public function switchAccount($id)
    {
        try{
            $user = User::find($id);
            Auth::guard('customer')->login($user);
            return redirect()->away(url('customer/dashboard'));
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
}
