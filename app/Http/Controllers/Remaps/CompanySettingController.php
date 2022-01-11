<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Http\Requests\CompanySettingRequest;
use App\Models\Timezone;
use App\Helpers\Helper;

class CompanySettingController extends MasterController
{
    //
    public function company_setting() {
        $company = $this->user->company;
        $timezones = Timezone::get();
        return view('pages.company-setting.settings', compact('company', 'timezones'));
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

            // $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
            // foreach($days as $day) {
            //     $daymark_from = $day.'_from';
            //     $daymark_to = $day.'_to';
            //     if ($request->$daymark_from) {
            //         $timezone = Helper::companyTimeZone();
            //         $tz = Timezone::find($timezone ?? 1);
            //         $utc_from = \Carbon\Carbon::parse(new \DateTime($request->$daymark_from, new \DateTimeZone($tz->name)))->tz('UTC')->format('H:i');
            //         $request->merge([$daymark_from => $utc_from]);
            //     }
            //     if ($request->$daymark_to) {
            //         $timezone = Helper::companyTimeZone();
            //         $tz = Timezone::find($timezone ?? 1);
            //         $utc_to = \Carbon\Carbon::parse(new \DateTime($request->$daymark_to, new \DateTimeZone($tz->name)))->tz('UTC')->format('H:i');
            //         $request->merge([$daymark_to => $utc_to]);
            //     }
            // }

            $this->user->company->update($request->all());
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
        return redirect()->route('company.setting', [
            'tab' => $request->tab
        ]);
    }
}
