<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanySettingController extends Controller
{
    //
    public function company_setting() {
        $company = $this->user->company;
        return view('pages.company-setting.settings', [
            'company' => $company,
        ]);
    }

    public function store(Request $request) {
        // dd($request);
        try {
            $this->user->company->update($request->all());
            return redirect()->route('company.setting', [
                'tab' => $request->tab
            ]);
        } catch (\Exception $ex) {
            dd($ex);
        }
    }
}
