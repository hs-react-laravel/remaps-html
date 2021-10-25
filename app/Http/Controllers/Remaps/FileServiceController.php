<?php

namespace App\Http\Controllers\Remaps;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\FileService;
use App\Models\Ticket;
use App\Models\StaffWork;
use File;

class FileServiceController extends Controller
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
        $entries = $query->orderBy('id', 'DESC')->paginate(10);
        return view('pages.fileservice.index', [
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
        return view('pages.fileservice.edit', ['fileService' => $fs]);
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
        $fs = FileService::find($id);
        // upload file
        $file = $request->file('upload_file');
        if ($file) {
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/file-services/modified'), $filename);
            $request->request->add(['modified_file' => $filename]);
            if ($fs->status != 'C') {
                $request->request->add(['status' => 'W']);
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

        return redirect(route('fileservices.index'));
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

        return redirect(route('fileservices.index'));
    }

    public function download_original($id) {
        $fileService = FileService::find($id);
        $file = storage_path('app/public/uploads/file-services/orginal/').$fileService->orginal_file;
        if (File::exists($file)) {
            $fileExt = File::extension($file);
            $fileName = $fileService->displayable_id.'-orginal.'.$fileExt;
            return response()->download($file, $fileName);
        }
    }

    public function download_modified($id) {
        $fileService = FileService::find($id);
        $file = storage_path('app/public/uploads/file-services/modified/').$fileService->modified_file;
        if (File::exists($file)) {
            $fileExt = File::extension($file);
            $fileName = $fileService->displayable_id.'-modified.'.$fileExt;
            return response()->download($file, $fileName);
        }
    }

    public function delete_modified_file($id) {
        $fileService = FileService::find($id);
        $file = storage_path('app/public/uploads/file-services/modified/').$fileService->modified_file;
        if (File::exists($file)) {
            File::delete($file);
            $fileService->modified_file = "";
            $fileService->save();
        }
        return redirect(route('fileservices.edit', ['fileservice' => $id]));
    }

    public function create_ticket($id) {
        $fileService = FileService::find($id);
        return view('pages.fileservice.create_ticket', ['fileService' => $fileService]);
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
        $ticket->save();

        return redirect(route('tickets.index'));
    }
}
