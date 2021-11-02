<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            }
            if($request->reseller_id && $request->reseller_password) {
                $url = "https://evc.de/services/api_resellercredits.asp";
                $dataArray = array(
                    'apiid'=>'j34sbc93hb90',
                    'username'=> $request->reseller_id,
                    'password'=> $request->reseller_password,
                    'verb'=>'getrecentpurchases',
                    'lastndays' => '1'
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
                if (strpos($response, '"status": "OK"') === FALSE) {
                    return redirect()->route('company.setting', ['tab' => $request->tab]);
                }
            }
            if ($request->input('mainLayoutType')) {
                $styling = (array)json_decode($this->user->company->styling->data);
                $styling['mainLayoutType'] = $request->input('mainLayoutType');
                $this->user->company->styling->data = json_encode($styling);
                $this->user->company->styling->save();
            }
            $this->user->company->update($request->all());
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
        return redirect()->route('company.setting', [
            'tab' => $request->tab
        ]);
    }
}
