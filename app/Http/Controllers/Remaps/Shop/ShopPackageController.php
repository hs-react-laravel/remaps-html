<?php

namespace App\Http\Controllers\Remaps\Shop;

use App\Http\Controllers\MasterController;
use App\Models\Shop\ShopPackage;
use Illuminate\Http\Request;

class ShopPackageController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->check_master();
        $entries = ShopPackage::orderBy('id', 'DESC')->get();
        return view('pages.ecommerce.package.index', [
            'entries' => $entries
        ]);
    }

    public function getAccessToken() {
        $ch = curl_init();
        $company = \App\Models\Company::where('is_default', 1)->first();
        if(!$company) return '';

        $clientId = $company->paypal_client_id;
        $secret = $company->paypal_secret;
        // $clientId = 'AdibmcjffSYZR9TSS5DuKIQpnf80KfY-3pBGd30JKz2Ar1xHIipwijo4eZOJvbDCFpfmOBItDqZoiHmM';
        // $secret = 'EEPRF__DLqvkwnnpi2Hi3paQ-9SZFRqypUH-u0fr4zAzvv7hWtz1bJHF0CEwvrvZpHyLeKSTO_FwAeO_';

        $api_url = "https://api.paypal.com/v1/oauth2/token";
        // $api_url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";

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

    public function create()
    {
        $this->check_master();
        return view('pages.ecommerce.package.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = "PROD-01890818FL1494411";
        $accessToken = $this->getAccessToken();

        $data = [
            'product_id' => $product,
            'name' => $request->name,
            'description' => $request->name,
            'status' => 'ACTIVE',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => $request->billing_interval,
                        'interval_count' => 1
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => 1,
                    'total_cycles' => 0,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => $request->amount,
                            'currency_code' => $this->company->paypal_currency_code
                        ]
                    ]
                ]
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'setup_fee' => [
                    'value' => $request->amount,
                    'currency_code' => $this->company->paypal_currency_code
                ],
                'setup_fee_failure_action' => 'CANCEL',
                'payment_failure_threshold' => 1
            ]
        ];

        $url = "https://api.paypal.com/v1/billing/plans";
        // $url = "https://api-m.sandbox.paypal.com/v1/billing/plans";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);;
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            'Accept: application/json',
            'Authorization: '."Bearer ". $accessToken,
            'Prefer: return=representation',
            'Content-Type: application/json',
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        // dd($resp);

        $request->request->add(['pay_plan_id'=> json_decode($resp)->id]);
        ShopPackage::create($request->all());

        return redirect(route('shoppackages.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->check_master();
        $entry = ShopPackage::find($id);
        return view('pages.ecommerce.package.edit', compact('entry'));
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
        ShopPackage::find($id)->update($request->all());

        return redirect(route('shoppackages.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = ShopPackage::find($id)->delete();
        return redirect(route('shoppackages.index'));
    }
}
