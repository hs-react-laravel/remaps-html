<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Models\FileService;
use App\Models\User;
use App\Mail\TicketFileCreated;
use App\Jobs\SendMail;

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
        return view('pages.staffpage.tickets.index');
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

        if ($this->user->is_semi_admin) {
            $user = $this->user;
            Ticket::where(function($query) use($user) {
                return $query->where('receiver_id', $user->id)->orWhere('receiver_id', $user->company->owner->id);
            })->where(function($query) use($entry){
                return $query->where('parent_chat_id',$entry->id)->orWhere('id', $entry->id);
            })->update(['is_read'=> 1]);
        } else {
            Ticket::where('receiver_id', $this->user->id)->where(function($query) use($entry){
                return $query->where('parent_chat_id',$entry->id)->orWhere('id', $entry->id);
            })->update(['is_read'=> 1]);
        }

        return view('pages.staffpage.tickets.edit', [
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
            $new_ticket->receiver_id = $this->user->company->owner->id;
            $new_ticket->message = $request->message;
            $new_ticket->subject = $ticket->subject;
            $new_ticket->document = $request->document;
            $new_ticket->remain_file = $request->remain_file;
            $new_ticket->save();
            $ticket->is_closed = 0;
            $ticket->save();

            $user = User::find($new_ticket->receiver_id);
            try{
                // SendMail::dispatch($user->email, new TicketFileCreated($user,$ticket->subject), $this->company, 'Update ticket');
                Mail::to($user->email)->send(new TicketFileCreated($user,$ticket->subject));
            }catch(\Exception $e){
                session()->flash('message', __('admin.ticket_saved'));
            }
        }
        if ($request->assign){
            $ticket->assign_id = $request->assign;
            $ticket->save();
        }

        return redirect(route('stafftk.edit', ['stafftk' => $id]));
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

        return redirect(route('stafftk.index'));
    }

    public function download_document($id)
    {
        $ticket = Ticket::find($id);
        $file = storage_path('app/public/uploads/tickets/').$ticket->document;
        if ($ticket->document && File::exists($file)) {
            $fileExt = File::extension($file);
            $fileName = $ticket->id.'-document.'.$fileExt;
            return response()->download($file, $fileName);
        }
        return redirect(route('stafftk.index'));
    }

    public function close_ticket($id)
    {
        $ticket = Ticket::find($id);
        $ticket->is_closed = 1;
        $ticket->save();
        return redirect(route('stafftk.index'));
    }

    public function read_all()
    {
        $user = $this->user;
        $parent_ids = Ticket::where(function($query) use($user){
            return $query->where('receiver_id', $user->company->owner->id)->orWhere('sender_id', $user->company->owner->id);
        })->where('parent_chat_id', 0)->where('assign_id', $user->id)->pluck('id');
        Ticket::whereIn('id', $parent_ids)->where('receiver_id', $user->company->owner->id)->update(['is_read' => 1]);
        Ticket::whereIn('parent_chat_id', $parent_ids)->where('receiver_id', $user->company->owner->id)->update(['is_read' => 1]);
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
        $query = Ticket::where('parent_chat_id', 0)->where(function($query) use($user){
            return $query->where('receiver_id', $user->company->owner->id)->orWhere('sender_id', $user->company->owner->id);
        });
        $unread_ids = $user->unread_tickets;
        if (!$user->is_semi_admin) {
            $query = $query->where('assign_id', $user->id);
        } else {
            $unread_ids = $user->company->owner->unread_tickets;
        }
        $totalRecords = $query->count();

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
                'route.edit' => route('stafftk.edit', ['stafftk' => $entry->id]), // edit route
                'route.destroy' => route('stafftk.destroy', $entry->id), // destroy route
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
}
