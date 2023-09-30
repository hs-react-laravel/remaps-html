<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Models\FileService;
use App\Models\User;
use App\Mail\TicketFileCreated;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
class TicketController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.tickets.index');
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
        $entry = Ticket::find($id);
        $messages = Ticket::where('parent_chat_id', $entry->id)->orderBy("id","ASC")->get();

        $fileService = null;
        if($entry->file_servcie_id != 0){
            $fileService = FileService::where('id', $entry->file_servcie_id)->first();
        }

        $receiverIDs = $this->user->company->staffs->pluck('id')->toArray();
        array_push($receiverIDs, $this->user->id);

        Ticket::whereIn('receiver_id', $receiverIDs)->where(function($query) use($entry){
            return $query->where('parent_chat_id',$entry->id)->orWhere('id', $entry->id);
        })->update(['is_read' => 1]);

        return view('pages.tickets.edit', [
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
    public function update(TicketRequest $request, $id)
    {
        $ticket = Ticket::find($id);

        if ($request->document || $request->message) {
            $new_ticket = new Ticket();
            $new_ticket->parent_chat_id = $ticket->id;
            $new_ticket->sender_id = $this->user->id;
            if($this->user->id == $ticket->sender_id){
                $new_ticket->receiver_id = $ticket->receiver_id;
            }else{
                $new_ticket->receiver_id = $ticket->sender_id;
            }
            $new_ticket->message = $request->message;
            $new_ticket->subject = $ticket->subject;
            $new_ticket->document = $request->document;
            $new_ticket->remain_file = $request->remain_file;
            $new_ticket->save();
            $ticket->is_closed = 0;
            $ticket->assign_id = $request->assign;
            $ticket->save();

            $user = User::find($new_ticket->receiver_id);
            try{
                Mail::to($user->email)->send(new TicketFileCreated($user,$ticket->subject));
            }catch(\Exception $e){
                session()->flash('message', __('admin.ticket_saved'));
            }
        } else {
            $ticket->assign_id = $request->assign;
            $ticket->save();
        }

        return redirect(route('tickets.edit', ['ticket' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $init_path = storage_path('app/public/uploads/tickets/');
        $children = Ticket::where('parent_chat_id',$id)->get();
        foreach ($children as $child) {
            if ($child->document && File::exists($init_path.$child->document)) {
                File::delete($init_path.$child->document);
            }
            $child->delete();
        }
        $ticket = Ticket::find($id);
        if ($ticket->document && File::exists($init_path.$ticket->document)) {
            File::delete($init_path.$ticket->document);
        }
        Ticket::find($id)->delete();

        return redirect(route('tickets.index'));
    }

    public function download_document($id)
    {
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
        return redirect(route('tickets.index'));
    }

    public function close_ticket($id)
    {
        $ticket = Ticket::find($id);
        $ticket->is_closed = 1;
        $ticket->save();
        return redirect(route('tickets.index'));
    }

    public function close_old_tickets($days)
    {
        Ticket::where('created_at', '<=', Carbon::now()->subDays($days)->toDateTimeString())
            ->update([
                'is_closed' => 1
            ]);
        return redirect(route('tickets.index'));
    }

    public function read_all()
    {
        $user = $this->user;
        $parent_ids = Ticket::where(function($query) use($user){
            return $query->where('receiver_id', $user->id)->orWhere('sender_id', $user->id);
        })->where('parent_chat_id', 0)->whereNull('assign_id')->pluck('id');
        Ticket::whereIn('id', $parent_ids)->where('receiver_id', $user->id)->update(['is_read' => 1]);
        Ticket::whereIn('parent_chat_id', $parent_ids)->where('receiver_id', $user->id)->update(['is_read' => 1]);
        return redirect(route('tickets.index'));
    }

    public function delete_closed()
    {
        $closed_tickets = $this->user->company->tickets()->where('is_closed', 1);
        $closed_tickets->delete();
        return redirect(route('tickets.index'));
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
        $receiverIDs = $user->company->staffs->pluck('id')->toArray();
        array_push($receiverIDs, $user->id);
        $query = $user->company->tickets();
        $totalRecords = $query->count();

        $unread_ids = $user->unread_tickets;
        if ($request->unread == "true") {
            $query = $query->whereIn('id', $unread_ids);
        }

        if ($request->open == "true") {
            $query = $query->where('is_closed', 0);
        }

        if ($searchValue) {
            $tids = $this->company->tickets()->where('parent_chat_id', '0')
                    ->where('message', 'like', '%'.$searchValue.'%')->pluck('id')->toArray();
            $ctids = $this->company->tickets()->whereHas('childrens', function($query) use($searchValue) {
                $query->where('message', 'like', '%'.$searchValue.'%');
            })->pluck('id')->toArray();
            $searchIDs = array_unique(array_merge($tids, $ctids));
            $query = $query->whereIn('id', $searchIDs);
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
                'route.edit' => route('tickets.edit', ['ticket' => $entry->id]), // edit route
                'route.destroy' => route('tickets.destroy', $entry->id), // destroy route
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
