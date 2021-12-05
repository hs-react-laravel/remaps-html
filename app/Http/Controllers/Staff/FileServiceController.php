<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Http\Requests\AdminFileServiceRequest;
use App\Models\FileService;
use App\Models\Ticket;
use App\Models\User;
use App\Mail\FileServiceModified;
use App\Mail\FileServiceProcessed;
use App\Mail\TicketFileCreated;
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
        $user = $this->user;

        $entries = [];
        $query = FileService::whereHas('user', function($query) use($user){
            $query->where('company_id', $user->company_id);
        });
        if(request()->query('status')) {
            $query = $query->where('status', request()->query('status'));
        }
        $entries = $query->orderBy('id', 'DESC')->paginate(10);
        return view('pages.staffpage.fileservice.index', [
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
        $fs = FileService::find($id);
        return view('pages.staffpage.fileservice.edit', ['fileService' => $fs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminFileServiceRequest $request, $id)
    {
        $fs = FileService::find($id);
        // upload file
        $file = $request->file('upload_file');
        if ($file) {
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/file-services/modified'), $filename);
            $request->request->add(['modified_file' => $filename]);
            if ($fs->status != 'C') {
                $request->request->add(['status' => 'W']);
            } else {
                try{
					Mail::to($fs->user->email)->send(new FileServiceModified($fs));
				}catch(\Exception $e){
					session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
				}
            }
        }
        //assign to staff
        if ($request->assign) {
            $request->request->add(['assign_id' => $request->assign]);
        } else {
            $request->request->add(['assign_id' => $this->user->id]);
        }
        if ($this->user->is_staff) {
            $request->request->add(['assign_id' => $this->user->id]);
        }
        // save model
        $fs->update($request->all());
        // relation with staff

        return redirect(route('stafffs.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fileService = FileService::find($id);
        $fileServiceUser = $fileService->user;
        if ($fileService->status != 'Completed') {
            $tuningTypeCredits = $fileService->tuningType->credits;
            $tuningTypeOptionsCredits = $fileService->tuningTypeOptions()->sum('credits');
            $fileServicecredits = $tuningTypeCredits + $tuningTypeOptionsCredits;
            $usersCredits = $fileServiceUser->tuning_credits + $fileServicecredits;
        } else {
            $usersCredits = $fileServiceUser->tuning_credits;
        }
        $fileService->delete();

        $fileServiceUser->tuning_credits = $usersCredits;
        $fileServiceUser->save();

        return redirect(route('stafffs.index'));
    }

    public function download_original($id) {
        try {
            $fileService = FileService::find($id);
            $file = storage_path('app/public/uploads/file-services/orginal/').$fileService->orginal_file;
            if (File::exists($file)) {
                $fileExt = File::extension($file);
                $fileName = $fileService->displayable_id.'-orginal.'.$fileExt;
                try{
                    Mail::to($fileService->user->email)->send(new FileServiceProcessed($fileService));
                }catch(\Exception $e){
                    session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
                }
                return response()->download($file, $fileName);
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
            return redirect(route('stafffs.index'));
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
            return redirect(route('stafffs.index'));
        }
    }

    public function delete_modified_file($id) {
        try {
            $fileService = FileService::find($id);
            $file = storage_path('app/public/uploads/file-services/modified/').$fileService->modified_file;
            if (File::exists($file)) {
                File::delete($file);
                $fileService->modified_file = "";
                if ($this->user->is_staff) {
                    $fileService->assign_id = $this->user->id;
                }
                $fileService->save();
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
        }
        return redirect(route('stafffs.edit', ['fileservice' => $id]));
    }

    public function create_ticket($id) {
        $fileService = FileService::find($id);
        return view('pages.staffpage.fileservice.create_ticket', ['fileService' => $fileService]);
    }

    public function store_ticket(Request $request, $id) {
        $fileService = FileService::find($id);

        $ticket = new Ticket();
        $ticket->sender_id = $this->user->id;
        $ticket->receiver_id = $fileService->user->id;
        $ticket->file_servcie_id = $id;
        $ticket->message = $request->message;
        if ($request->file('upload_file')) {
            $file = $request->file('upload_file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/tickets'), $filename);
            $ticket->document = $filename;
        }
        $ticket->is_closed = 0;
        $jobDetails = $fileService->make.' '.$fileService->model.' '.$fileService->generation;
        $user = User::find($ticket->receiver_id);
        if ($ticket->save()) {
            try{
            	Mail::to($user->email)->send(new TicketFileCreated($user, $jobDetails));
			}catch(\Exception $e){
				session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
			}
            session()->flash('message', __('admin.ticket_saved'));
        } else {
            session()->flash('error', __('admin.opps'));
        }

        return redirect(route('stafftk.index'));
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
        $query = FileService::whereHas('user', function($query) use($user) {
            $query->where('company_id', $user->company_id);
        });
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
            $query->where('make', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('model', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('generation', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('engine', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('ecu', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('license_plate', 'LIKE', '%'.$searchValue.'%');
        });

        $totalRecordswithFilter = $query->count();

        $entries = $query->orderBy($columnName, $columnSortOrder)->skip($start)->take($rowperpage)->get();

        $return_data = [];
        foreach($entries as $entry) {
            array_push($return_data, [
                'displayable_id' => $entry->displayable_id,
                'car' => $entry->car,
                'license_plate' => $entry->license_plate,
                'staff' => $entry->staff ? $entry->staff->fullname : '',
                'created_at' => $entry->created_at,
                'actions' => '',
                'route.edit' => route('fileservices.edit', ['fileservice' => $entry->id]), // edit route
                'route.ticket' => $entry->tickets
                    ? route('tickets.edit', ['ticket' => $entry->tickets->id])
                    : route('fileservice.tickets.create', ['id' => $entry->id]), // ticket route
                'route.destroy' => route('fileservices.destroy', $entry->id), // destroy route
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
