<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TicketRequest;
use App\Models\User;
use App\Models\Ticket;
use App\Models\FileService;
use App\Mail\TicketCreated;
use App\Mail\TicketReply;
use App\Jobs\SendMail;

class TicketController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.consumers.tk.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.consumers.tk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
        // create ticket
        $request->request->add([
            'sender_id'=> $this->user->id,
            'receiver_id'=> $this->user->company->owner->id
        ]);
        $ticket = Ticket::create($request->all());
        try{
            SendMail::dispatch($this->user->company->owner->email, new TicketCreated($this->user,$request->all()['subject']), $this->company, 'Create Ticket');
            // Mail::to($this->user->company->owner->email)->send(new TicketCreated($this->user,$request->all()['subject']));
            foreach($this->user->company->semiadmins as $sa) {
                SendMail::dispatch($sa->email, new TicketCreated($this->user,$request->all()['subject']), $this->company, 'Create Ticket');
                // Mail::to($sa->email)->send(new TicketCreated($this->user,$request->all()['subject']));
            }
		}catch(\Exception $e){
			session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
		}
        return redirect(route('tk.edit', ['tk' => $ticket->id]));
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
        $entry = Ticket::find($id);
        $messages = Ticket::where('parent_chat_id', $entry->id)->orderBy("id","ASC")->get();

        $fileService = null;
        if($entry->file_servcie_id != 0){
            $fileService = FileService::where('id', $entry->file_servcie_id)->first();
        }

        Ticket::where('receiver_id', $this->user->id)->where(function($query) use($entry){
            return $query->where('parent_chat_id', $entry->id)->orWhere('id', $entry->id);
        })->update(['is_read' => 1]);

        return view('pages.consumers.tk.edit', [
            'entry' => $entry,
            'messages' => $messages,
            'fileService' => $fileService,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TicketRequest $request)
    {
        $id = $request->route('tk');
        $ticket = Ticket::find($id);
        $new_ticket = new Ticket();
        $new_ticket->parent_chat_id = $ticket->id;
        $new_ticket->sender_id = $this->user->id;
        $new_ticket->receiver_id = $ticket->assign_id ?? $this->company->owner->id;
        $new_ticket->message = $request->message;
        $new_ticket->subject = $ticket->subject;
        $new_ticket->document = $request->document;
        $new_ticket->remain_file = $request->remain_file;
        $new_ticket->save();

        $ticket->is_closed = 0;
        $ticket->save();

        $mailing = $this->user->company->owner->email;
        if ($ticket->assign_id) {
            $mailing = User::find($ticket->assign_id)->email;
        }

        try{
            SendMail::dispatch($mailing, new TicketReply($this->user,$ticket->subject), $this->company, 'Update Ticket');
            // Mail::to($mailing)->send(new TicketReply($this->user,$ticket->subject));
        }catch(\Exception $e){
            session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
        }

        return redirect(route('tk.edit', ['tk' => $id]));
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

    public function download_document($id)
    {
        try {
            $ticket = Ticket::find($id);
            $file = storage_path('app/public/uploads/tickets/').$ticket->document;
            if ($ticket->document && File::exists($file)) {
                $fileExt = File::extension($file);
                $fileName = $ticket->id.'-document.'.$fileExt;
                if ($ticket->sender->is_reserve_filename && !empty($ticket->remain_file)) {
                    $fileName = $ticket->remain_file;
                }
                return response()->download($file, $fileName);
            }
        } catch (\Exception $ex) {
            session()->flash('error', $ex->getMessage());
            return redirect(route('tk.index'));
        }
    }

    public function close_ticket($id)
    {
        $ticket = Ticket::find($id);
        $ticket->is_closed = 1;
        $ticket->save();
        return redirect(route('tk.index'));
    }

    public function read_all()
    {
        $user = $this->user;
        Ticket::where('receiver_id', $user->id)->update(['is_read' => 1]);
        return redirect(route('tk.index'));
    }

    public function getTickets(Request $request) {
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
        $query = Ticket::where('parent_chat_id', 0)->where(function($query) use($user){
            return $query->where('receiver_id', $user->id)->orWhere('sender_id', $user->id);
        });
        $totalRecords = $query->count();

        $unread_ids = $user->unread_tickets;
        if ($request->unread == "true") {
            $query = $query->whereIn('id', $unread_ids);
        }

        if ($request->open == "true") {
            $query = $query->where('is_closed', 0);
        }

        $totalRecordswithFilter = $query->count();
        $entries = $query->orderBy($columnName, $columnSortOrder)->skip($start)->take($rowperpage)->get();

        $return_data = [];
        foreach($entries as $entry) {
            array_push($return_data, [
                'client' => $entry->client,
                'file_service' => $entry->file_service_name,
                'is_closed' => $entry->is_closed ? 'Closed' : 'Open',
                'staff' => $entry->staff ? $entry->staff->fullname : '',
                'created_at' => $entry->created_at,
                'actions' => '',
                'route.edit' => route('tk.edit', ['tk' => $entry->id]), // edit route
                'unread_message' => in_array($entry->id, $unread_ids) ? 0 : 1,
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

    public function uploadTicketFile(Request $request){
        if($request->hasFile('file')){
            if($request->file('file')->isValid()){
                $file = $request->file('file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $org_filename = $file->getClientOriginalName();
                if($file->move(storage_path('app/public/uploads/tickets/'), $filename)){
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
