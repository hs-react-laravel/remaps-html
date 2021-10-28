<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->user;
        $entries = Company::where('id', '!=', $user->company->id)->orderBy('id', 'DESC')->paginate(20);
        return view('pages.company.index', [
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
        $entry = new Company;
        return view('pages.company.edit', [
            'entry' => $entry
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
        $company = Company::create($request->all());
        return redirect(route('companies.edit', ['company'=> $company->id]));
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
        $entry = Company::find($id);
        return view('pages.company.edit', [
            'entry' => $entry
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
        $entry = Company::find($id);
        $entry->update($request->all());
        return redirect(route('companies.edit', ['company' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::find($id)->delete();
        return redirect(route('companies.index'));
    }

    public function activate($id)
    {
        $company = Company::find($id);
		$companyUser = $company->owner;
        if($companyUser->is_active ==1){
			$companyUser->is_active = 0;
			$companyUser->save();
		}else{
			$companyUser->is_active = 1;
			$companyUser->save();
			$token = app('auth.password.broker')->createToken($companyUser);
		}
        return redirect(route('companies.index'));
    }

    public function public($id)
    {
        $company = Company::find($id);
		if($company->is_public == 1){
			$company->is_public = 0;
		} else {
			$company->is_public = 1;
		}
		$company->Save();
        return redirect(route('companies.index'));
    }

    public function switchAsCompany($id){
        $company = Company::find($id);
        $user = $company->users()->where('is_master', 0)->where('is_admin', 1)->first();
        if($user){
            Auth::login($user);
            // return redirect()->away($user->company->domain_link);
            return redirect(route('dashboard'));
        }
    }
}
