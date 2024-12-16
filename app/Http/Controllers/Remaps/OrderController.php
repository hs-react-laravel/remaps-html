<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Models\User;
use App\Models\Order;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\BankTransferComplete;

class OrderController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = $this->user;
        $entries = Order::whereHas('user', function($query) use($user){
            return $query->where('company_id', $user->company_id);
        })->orderBy('id', 'DESC')->paginate(10);
        return view('pages.orders.index', [
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
    public function invoice($id){
        try{
            $order = Order::find($id);
            $pdf = new Dompdf;
            $invoiceName = 'invoice_'.$order->displayable_id.'.pdf';
            $options = $pdf->getOptions();
            $options->setIsRemoteEnabled(true);
            $pdf->setOptions($options);

            $pdf->loadHtml(
                view('pdf.invoice')->with(['order'=>$order, 'company'=>$this->company])->render()
            );
            $pdf->setPaper('A4', 'landscape');
            $pdf->render();
            return $pdf->stream($invoiceName);
        }catch(\Exception $e){
            return redirect(url('admin/order'));
        }
    }
    public function download($id) {
        try {
            $order = Order::find($id);
            $file = storage_path('app/public/uploads/invoice/').$order->document;
            if (File::exists($file)) {
                $fileName = 'invoice_'.$order->displayable_id.'.pdf';
                return response()->download($file, $fileName);
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
            return redirect(url('admin/orders'));
        }
    }
    public function complete($id) {
        try {
            $order = Order::find($id);
            $user = $order->user;

            $tuningCreditGroup = \App\Models\TuningCreditGroup::find($order->transaction_id);
            $groupCreditTires  = $user->tuningCreditGroup->tuningCreditTires()->withPivot('from_credit', 'for_credit')->wherePivot('from_credit', '!=', 0.00);
            if (!$groupCreditTires) {
                $groupCreditTires  = $user->tuningEVCCreditGroup->tuningCreditTires()->withPivot('from_credit', 'for_credit')->wherePivot('from_credit', '!=', 0.00);
            }
            $tire = $groupCreditTires->where('id', $order->invoice_id)->first();

            $totalCredits = ($user->tuning_credits + $tire->amount);
            $user->tuning_credits = $totalCredits;
            $user->save();

            $transaction = new \App\Models\Transaction();
            $transaction->user_id = $user->id;
            $transaction->credits = number_format($tire->amount, 2);
            $transaction->description = "Tuning credits purchase";
            $transaction->status = config('constants.transaction_status.completed');
            $transaction->save();

            $order->status = config('constants.order_status.completed');
            $order->save();

            try{
                Mail::to($user->email)->send(new BankTransferComplete($order, $tire->amount));
            }catch(\Exception $e){
                session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
        return redirect(url('admin/orders'));
    }

    public function api(Request $request) {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length');

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $company = $this->company;
        $user = $this->user;
        $query = Order::whereHas('user', function($query) use($user) {
            $query->where('company_id', $user->company_id);
        });
        $totalRecords = $query->count();

        if ($request->start_date && $request->end_date) {
            $query = $query->whereBetween('created_at', [$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);
        }
        $query = $query->where(function($query) use ($searchValue) {
            $query->where('transaction_id', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('invoice_id', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('description', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('payment_gateway', 'LIKE', '%'.$searchValue.'%');
        });

        $totalRecordswithFilter = $query->count();

        $entries = $query->orderBy($columnName, $columnSortOrder)->skip($start)->take($rowperpage)->get();

        $return_data = [];
        foreach($entries as $entry) {
            array_push($return_data, [
                'id' => $entry->id,
                'created_at' => $entry->created_at,
                'customer_company' => $entry->customer_company,
                'amount' => config('constants.currency_signs')[$company->paypal_currency_code].' '.$entry->amount_with_sign,
                'payment_gateway' => $entry->payment_gateway,
                'status' => $entry->status,
                'displayable_id' => $entry->displayable_id,
                'actions' => '',
                'route.invoice' => route('order.invoice', ['id' => $entry->id]),
                'route.complete' => route('order.complete', ['id' => $entry->id]),
                'route.download' => route('order.download', ['id' => $entry->id]),
                'bank_pending' => $company->is_bank_enabled && $entry->payment_gateway == "Bank" && $entry->status == "Pending",
                'invoice_pdf' => $company->is_invoice_pdf,
                'invoice_pdf_exist' => $entry->document
            ]);
        }
        $json_data = array(
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordswithFilter,
            'data' => $return_data
        );

        return response()->json($json_data);
    }
}
