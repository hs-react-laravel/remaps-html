<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\FileService;

use File;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->user;
        $entries = Ticket::where('parent_chat_id', 0)->where(function($query) use($user){
            return $query->where('receiver_id', $user->id)->orWhere('sender_id', $user->id);
        })->orderBy('id', 'DESC')->paginate(10);
        return view('pages.consumers.tk.index', [
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
        return view('pages.consumers.tk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // create ticket
        $request->request->add([
            'sender_id'=> $this->user->id,
            'receiver_id'=> $this->user->company->owner->id
        ]);
        if ($request->file('upload_file')) {
            // upload file
            $file = $request->file('upload_file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/tickets'), $filename);
            $request->request->add([
                'document' => $filename
            ]);
        }
        Ticket::create($request->all());
        return redirect(route('tk.index'));
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
        $messages = Ticket::where('parent_chat_id', $entry->id)->get();

        $fileService = null;
        if($entry->file_servcie_id != 0){
            $fileService = FileService::where('id', $entry->file_servcie_id)->first();
        }
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
    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $new_ticket = new Ticket();
        $new_ticket->parent_chat_id = $ticket->id;
        $new_ticket->sender_id = $this->user->id;
        $new_ticket->receiver_id = $this->company->owner->id;
        $new_ticket->message = $request->message;
        $new_ticket->subject = $ticket->subject;
        if ($request->file('upload_file')) {
            $file = $request->file('upload_file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/tickets'), $filename);
            $new_ticket->document = $filename;
        }
        $new_ticket->save();

        $ticket->is_closed = 0;
        $ticket->save();

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
        $ticket = Ticket::find($id);
        $file = storage_path('app/public/uploads/tickets/').$ticket->document;
        if ($ticket->document && File::exists($file)) {
            $fileExt = File::extension($file);
            $fileName = $ticket->id.'-document.'.$fileExt;
            return response()->download($file, $fileName);
        }
        return redirect(route('tickets.index'));
    }
}
