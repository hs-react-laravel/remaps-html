<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

use App\Http\Controllers\MasterController;
use App\Http\Requests\FileServiceRequest;
use App\Mail\FileServiceCreated;
use App\Mail\FileServiceLimited;
use App\Mail\TicketCreated;
use App\Models\FileService;
use App\Models\TuningType;
use App\Models\Transaction;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Timezone;
use App\Models\TuningCreditTire;

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
        try {
            $tuningTypes = TuningType::where('company_id', $this->user->company_id)->orderBy('order_as', 'ASC')->get();
            $tuningOptions = [];
            foreach($tuningTypes as $opt) {
                $tuningOptions[$opt->id] = TuningType::find($opt->id)->tuningTypeOptions->pluck('label', 'id');
            }

            // find minimum tuning credit tire
            $minTuningCreditTire = TuningCreditTire::where('company_id', $this->user->company_id)->orderBy('amount', 'ASC')->first();
            $tcValues = $minTuningCreditTire->tuningCreditGroups()->where('tuning_credit_group_id', $this->user->tuning_credit_group_id)
                ->withPivot('from_credit', 'for_credit')->first();
            $creditPrice = 1;
            if ($minTuningCreditTire->amount == 0) {
                $creditPrice = 0;
            } else {
                $creditPrice = $tcValues->pivot->from_credit / $minTuningCreditTire->amount;
            }

            return view('pages.consumers.fs.create', [
                'tuningTypes' => $tuningTypes,
                'tuningOptions' => $tuningOptions,
                'creditPrice' => $creditPrice
            ]);
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
        return redirect(route('fs.index'));
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
                return redirect(route('fs.index'));
            } else {
                $request->request->add(['status' => 'O']);
            }
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
                if ($open_status != 2) {
                    Mail::to($this->company->owner->email)->send(new FileServiceCreated($fileService));
                }
                if ($open_status == 1) {
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
        $open_status = -1;
        if ($company->open_check) {
            $timezone = $company->timezone;
            $tz = Timezone::find($timezone ?? 1);
            $day = lcfirst(date('l'));
            $daymark_from = substr($day, 0, 3).'_from';
            $daymark_to = substr($day, 0, 3).'_to';

            $day_close = substr($day, 0, 3).'_close';
            if ($company->$day_close) return ($company->notify_check == 0 ? 1 : 2);

            $today_start = date('Y-m-d ').$company->$daymark_from.':00';
            $today_end = date('Y-m-d ').$company->$daymark_to.':00';
            $utc_from = Carbon::parse(new \DateTime($today_start, new \DateTimeZone($tz->name)))->tz('UTC')->format('Hi');
            $utc_to = Carbon::parse(new \DateTime($today_end, new \DateTimeZone($tz->name)))->tz('UTC')->format('Hi');
            if ($company->$daymark_from && $utc_from > date('Hi')
                || $company->$daymark_to && $utc_to < date('Hi')) {
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
        $entry = FileService::find($id);
        return view('pages.consumers.fs.show', [
            'entry' => $entry
        ]);
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
                if ($fileService->user->is_reserve_filename && !empty($fileService->remain_orginal_file)) {
                    $fileName = $fileService->remain_orginal_file;
                }
                return response()->download($file, $fileName);
            } else {
                session()->flash('error', "File not found");
                return redirect(route('fs.index'));
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
                if ($fileService->user->is_reserve_filename && !empty($fileService->remain_modified_file)) {
                    $fileName = $fileService->remain_modified_file;
                }
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
        $ticket->document = $request->document;
        $ticket->remain_file = $request->remain_file;
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

        return redirect(route('fs.index'));
    }

    public function checkOpenStatus(Request $request) {
        $open_status = $this->open_status();
        return $open_status;
    }

    public function getFileServices(Request $request) {
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

        $user = User::find($request->id);
        $query = FileService::where('user_id', $this->user->id);
        $totalRecords = $query->count();
        if($request->staffstatus) {
            $query = $query->where('assign_id', $user->id)->where('status', $request->staffstatus);
        }
        if($request->status) {
            $query = $query->where('status', $request->status);
        }
        if ($request->customer) {
            $query = $query->where('user_id', $request->customer);
        }
        if ($request->start_date && $request->end_date) {
            $query = $query->whereBetween('created_at', [$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);
        }
        $query = $query->where(function($query) use ($searchValue) {
            $query->orWhere('make', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('model', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('generation', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('engine', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('ecu', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('license_plate', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('displayable_id', 'LIKE', '%'.$searchValue.'%');
        });

        $totalRecordswithFilter = $query->count();

        $entries = $query->orderBy($columnName, $columnSortOrder)->skip($start)->take($rowperpage)->get();

        $return_data = [];
        foreach($entries as $entry) {
            array_push($return_data, [
                'displayable_id' => $entry->displayable_id,
                'car' => $entry->car,
                'license_plate' => $entry->license_plate,
                'created_at' => $entry->created_at,
                'actions' => '',
                'route.ticket' => $entry->tickets
                    ? route('tk.edit', ['tk' => $entry->tickets->id])
                    : route('fs.tickets.create', ['id' => $entry->id]), // ticket route
                'route.download.original' => route('fs.download.original', ['id' => $entry->id]), // download origin route
                'route.download.modified' => route('fs.download.modified', ['id' => $entry->id]),
                'route.show' => route('fs.show', ['f' => $entry->id]),
                'modified_available' => $entry->status == 'Completed' && $entry->modified_file
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

    public function uploadFile(Request $request){
        if($request->hasFile('file')){
            if($request->file('file')->isValid()){
                $file = $request->file('file');
                $ext = $file->getClientOriginalExtension();
                if ($ext == 'php' || $ext == 'pht') {
                    return response()->json(['status'=> FALSE], 404);
                }
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $org_filename = $file->getClientOriginalName();
                if($file->move(storage_path('app/public/uploads/file-services/orginal/'), $filename)){
                    return response()->json([
                        'status'=> TRUE,
                        'file' => $filename,
                        'remain' => $org_filename
                    ], 200);
                }else{
                    return response()->json(['status'=> FALSE], 404);
                }
            }else{
                return response()->json(['status'=> FALSE], 404);
            }
        }else{
            return response()->json(['status'=> FALSE], 404);
        }
    }
}
