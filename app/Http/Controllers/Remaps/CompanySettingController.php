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
        try {
            // upload file
            if ($request->file('upload_file')) {
                $file = $request->file('upload_file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/uploads/logo'), $filename);
                $request->request->add(['logo' => $filename]);
            }
            if ($request->file('style_background_file')) {
                $file = $request->file('style_background_file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/uploads/styling'), $filename);
                $request->request->add(['style_background' => $filename]);
                // dd($request);
            }
            // dd($request->all());
            $this->user->company->update($request->all());
            return redirect()->route('company.setting', [
                'tab' => $request->tab
            ]);
        } catch (\Exception $ex) {
            dd($ex);
        }
    }
}
