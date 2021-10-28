<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use Dompdf\Dompdf;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Subscription::where('user_id', $this->user->id);
        $company = $request->input('company');
        if($this->user->is_master){
            if($company){
                $query = Subscription::whereHas('user', function($query) use($company){
                    $query->where('company_id', $company);
                });
            }
        }
        $entries = $query->orderBy('id', 'DESC')->get();
        return view('pages.subscription.index', compact('entries'));
    }

    public function payments($id)
    {
        $subscription = Subscription::find($id);
        $entries = $subscription->subscriptionPayments;
        return view('pages.subscription.payments', compact('entries'));
    }

    public function invoice($id)
    {
        $subscription_payment = SubscriptionPayment::find($id);
        $pdf = new Dompdf;
        $invoiceName = 'invoice_'.$subscription_payment->id.'.pdf';
        $pdf->loadHtml(
            view('pdf.subscription_invoice')->with(['subscription_payment'=>$subscription_payment, 'company'=>$this->company, 'user'=>$this->user])->render()
        );
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        return $pdf->stream($invoiceName);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }
}
