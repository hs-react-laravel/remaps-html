<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Http\Requests\FileServiceRequest;
use App\Mail\FileServiceCreated;
use App\Mail\FileServiceLimited;
use App\Mail\TicketCreated;
use App\Models\FileService;
use App\Models\TuningType;
use App\Models\Transaction;
use App\Models\Ticket;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class FileServiceController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = FileService::where('user_id', $this->user->id);
        if(request()->query('status')){
            $query = $query->where('status', request()->query('status'));
        }
        $entries = $query->orderBy('id', 'DESC')->paginate(10);
        $tuningTypes = TuningType::where('company_id', $this->user->company_id)->orderBy('order_as', 'ASC')->pluck('label', 'id')->toArray();
        return view('pages.consumers.fs.index', [
            'entries' => $entries,
            'tuningTypes' => $tuningTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tuningTypes = TuningType::where('company_id', $this->user->company_id)->orderBy('order_as', 'ASC')->pluck('label', 'id')->toArray();
        $tuningOptions = [];
        foreach($tuningTypes as $id => $label) {
            $tuningOptions[$id] = TuningType::find($id)->tuningTypeOptions->pluck('label', 'id');
        }
        return view('pages.consumers.fs.create', [
            'tuningTypes' => $tuningTypes,
            'tuningOptions' => $tuningOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileServiceRequest $request)
    {
        try {
            $open_status = $this->open_status();
            if ($open_status == 1) { // allow file service
                session()->flash('warning', __('File Services are closed.'));
                $request->request->add(['status' => 'P']);
            } else if ($open_status == 2) { // deny file service
                session()->flash('warning', __('File Services are closed.'));
                return redirect(url('customer/file-service'));
            } else {
                $request->request->add(['status' => 'O']);
            }
            // upload file
            $file = $request->file('upload_file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/file-services/orginal'), $filename);
            // save once
            $request->request->add([
                'orginal_file' => $filename,
            ]);
            $fileService = FileService::create($request->all());
            $fileService->save();
            // save tuning options and sum credits
            $tuningTypeCredits = $fileService->tuningType->credits;
            if($request->has('tuning_type_options')){
                $fileService->tuningTypeOptions()->sync($request->tuning_type_options);
                $tuningTypeOptionsCredits = $fileService->tuningTypeOptions()->sum('credits');
                $tuningTypeCredits = ($tuningTypeCredits + $tuningTypeOptionsCredits);
            }
            /* save user credits */
            $user = $fileService->user;
            $totalCredits = ($user->tuning_credits - $tuningTypeCredits);
            $user->tuning_credits = $totalCredits;
            $user->save();
            /* save file service displayable id */
            $displableId = FileService::wherehas('user', function($query) use($user){
                $query->where('company_id', $user->company_id);
            })->max('displayable_id');
            $displableId++;
            $fileService->displayable_id = $displableId;
            $fileService->save();
            /* save transaction */
            $transaction = new Transaction();
            $transaction->user_id       =   $user->id;
            $transaction->credits       =   $tuningTypeCredits;
            $transaction->description   =   "File Service: " . $fileService->car;
            $transaction->status        =   config('constants.transaction_status.completed');
            $transaction->type          =   'S';
            $transaction->save();
            try{
                if ($open_status == -1) {
                    Mail::to($this->company->owner->email)->send(new FileServiceCreated($fileService));
                } else if ($open_status == 1) {
                    Mail::to($user->email)->send(new FileServiceLimited($fileService));
                }
            }catch(\Exception $ex){
                session()->flash('error', $ex->getMessage());
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
        return redirect(route('fs.index'));
    }

    public function open_status() {
        $user = $this->user;
        $company = $user->company;
        $day = lcfirst(date('l'));
        $daymark_from = substr($day, 0, 3).'_from';
        $daymark_to = substr($day, 0, 3).'_to';

        $open_status = -1;
        if ($company->open_check) {
            if ($company->$daymark_from && str_replace(':', '', $company->$daymark_from) > date('Hi')
                || $company->$daymark_to && str_replace(':', '', $company->$daymark_to) < date('Hi')) {
                $open_status = $company->notify_check == 0 ? 1 : 2;
            }
        }
        return $open_status;
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
        $entry = FileService::find($id);
        return view('pages.consumers.fs.edit', [
            'entry' => $entry
        ]);
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
        FileService::find($id)->update($request->all());
        return redirect(route('fs.index'));
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

    public function download_original($id) {
        try {
            $fileService = FileService::find($id);
            $file = storage_path('app/public/uploads/file-services/orginal/').$fileService->orginal_file;
            if (File::exists($file)) {
                $fileExt = File::extension($file);
                $fileName = $fileService->displayable_id.'-orginal.'.$fileExt;
                return response()->download($file, $fileName);
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
            return redirect(route('fs.index'));
        }
    }

    public function download_modified($id) {
        try {
            $fileService = FileService::find($id);
            $file = storage_path('app/public/uploads/file-services/modified/').$fileService->modified_file;
            if (File::exists($file)) {
                $fileExt = File::extension($file);
                $fileName = $fileService->displayable_id.'-modified.'.$fileExt;
                return response()->download($file, $fileName);
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
            return redirect(route('fs.index'));
        }
    }

    public function delete_modified_file($id) {
        try {
            $fileService = FileService::find($id);
            $file = storage_path('app/public/uploads/file-services/modified/').$fileService->modified_file;
            if (File::exists($file)) {
                File::delete($file);
                $fileService->modified_file = "";
                $fileService->save();
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
        return redirect(route('fileservices.edit', ['fileservice' => $id]));
    }

    public function create_ticket($id) {
        $fileService = FileService::find($id);
        return view('pages.consumers.fs.create_ticket', ['fileService' => $fileService]);
    }

    public function store_ticket(Request $request, $id) {
        $ticket = new Ticket();
        $ticket->sender_id = $this->user->id;
        $ticket->receiver_id = $this->user->company->owner->id;
        $ticket->file_servcie_id = $id;
        $ticket->message = $request->message;
        if ($request->file('upload_file')) {
            $file = $request->file('upload_file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/tickets'), $filename);
            $ticket->document = $filename;
        }
        $ticket->is_closed = 0;
        $fileService = FileService::find($id);
        $jobDetails = $fileService->make.' '.$fileService->model.' '.$fileService->generation;
        if($ticket->save()){
            try{
            	Mail::to($this->user->company->owner->email)->send(new TicketCreated($this->user, $jobDetails));
			}catch(\Exception $e){
				session()->flash('message', 'Error in SMTP: '.__('admin.opps'));
			}
            session()->flash('message', __('admin.ticket_saved'));
        }else{
            session()->flash('error', __('admin.opps'));
            return redirect()->back()->withInput($request->all());
        }

        return redirect(route('tickets.index'));
    }
}
