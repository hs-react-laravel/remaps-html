<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Models\Order;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;

class OrderController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->user;
        $entries = Order::where('user_id', $this->user->id)->orderBy('id', 'DESC')->paginate(10);
        return view('pages.consumers.od.index', [
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
            return redirect(url('customer/od'));
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
            return redirect(url('customer/od'));
        }
    }
}
