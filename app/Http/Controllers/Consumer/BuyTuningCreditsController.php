<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;

class BuyTuningCreditsController extends Controller
{
    public function index()
    {
        $tuningCreditGroup = $this->user->tuningCreditGroup;
        $groupCreditTires  = $tuningCreditGroup
            ? $this->user->tuningCreditGroup->tuningCreditTires()->withPivot('from_credit', 'for_credit')->wherePivot('from_credit', '!=', 0.00)->orderBy('amount', 'ASC')->get()
            : [];
        // dd($groupCreditTires);
        return view('pages.consumers.bc.index', [
            'groupCreditTires' => $groupCreditTires
        ]);
    }
    public function handlePayment(Request $request)
    {
        $this->user->tuning_credits = $this->user->tuning_credits + $request->amount;
        $this->user->save();
        return redirect(route('consumer.buy-credits'));
    }
}
