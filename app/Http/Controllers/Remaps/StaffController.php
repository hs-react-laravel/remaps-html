<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\WelcomeCustomer;
use App\Models\User;

use Mail;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $entries = User::where('company_id', $this->user->company_id)
            ->where('is_admin', 0)
            ->where('is_staff', 1)
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('pages.staff.index', [
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
        $user = $this->user;
        $langs = config('constants.langs');
        return view('pages.staff.create', compact('langs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->request->add([
                'company_id'=> $this->company->id,
                'is_staff' => 1,
                'business_name' => '',
                'address_line_1' => '',
                'county' => '',
                'town' => '',
            ]);
            $user = User::create($request->all());
            $token = app('auth.password.broker')->createToken($user);
			try{
                Mail::to($user->email)->send(new WelcomeCustomer($user, $token));
			}catch(\Exception $e) {
                session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
			}
            return redirect(route('staffs.index'));
        } catch(\Exception $e){
            session()->flash('error',$e->getMessage());
            return redirect(route('staffs.index'));
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
        $entry = User::find($id);
        $langs = config('constants.langs');
        return view('pages.staff.edit', compact('entry', 'langs'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect(route('staffs.index'));
    }
}
