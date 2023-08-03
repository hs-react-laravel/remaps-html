<?php

namespace App\Http\Controllers\Remaps\Api;
use App\Http\Controllers\MasterController;
use App\Models\Api\ApiPackage;
use Illuminate\Http\Request;

class ApiInterfaceController extends MasterController
{
    //
    public function package_edit() {
        $entry = ApiPackage::first();
        return view('pages.api.edit', compact('entry'));
    }

    public function package_edit_post(Request $request)
    {
        $accessToken = $this->getAccessToken();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.paypal.com/v1/billing/plans/'.$request->pay_plan_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $headers = array(
            'Accept: application/json',
            'Authorization: '."Bearer ". $accessToken,
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $plan_obj = json_decode($result);

        $price = $plan_obj ? $plan_obj->payment_preferences->setup_fee->value : 0;

        $entry = ApiPackage::find($request->pkg_id);

        $entry->update([
            'name' => $request->name,
            'pay_plan_id' => $request->pay_plan_id,
            'description' => $request->description,
            'amount' => $plan_obj->payment_preferences->setup_fee->value
        ]);

        return view('pages.api.edit', compact('entry'));
    }

    public function getAccessToken() {
        $ch = curl_init();

        $company = \App\Models\Company::where('is_default', 1)->first();
        if(!$company) return;

        // $clientId = $company->paypal_client_id;
        // $secret = $company->paypal_secret;

        $clientId = "AdibmcjffSYZR9TSS5DuKIQpnf80KfY-3pBGd30JKz2Ar1xHIipwijo4eZOJvbDCFpfmOBItDqZoiHmM";
        $secret = "EEPRF__DLqvkwnnpi2Hi3paQ-9SZFRqypUH-u0fr4zAzvv7hWtz1bJHF0CEwvrvZpHyLeKSTO_FwAeO_";

        // $api_url = "https://api.paypal.com/v1/oauth2/token";
        $api_url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result);
        return $json->access_token;
    }
}
