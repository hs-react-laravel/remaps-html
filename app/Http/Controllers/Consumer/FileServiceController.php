<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Http\Request;
use App\Models\FileService;
use App\Models\TuningType;
use App\Models\Transaction;
use Storage;
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
        $entries = FileService::where('user_id', $this->user->id)->orderBy('id', 'DESC')->paginate(10);
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
    public function store(Request $request)
    {
        // upload file
        $file = $request->file('upload_file');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('app/public/uploads/file-services/orginal'), $filename);
        // save once
        $request->request->add([
            'user_id' => $this->user->id,
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
        $transaction->credits       =   number_format($tuningTypeCredits, 2);
        $transaction->description   =   "File Service: " . $fileService->car;
        $transaction->status        =   config('constants.transaction_status.completed');
        $transaction->type          =   'S';
        $transaction->save();

        return redirect(route('fs.index'));
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
        $fileService = FileService::find($id);
        $file = storage_path('app/public/uploads/file-services/orginal').$fileService->orginal_file;
        if (File::exists($file)) {
            $fileExt = File::extension($file);
            $fileName = $fileService->displayable_id.'-orginal.'.$fileExt;
            return response()->download($file, $fileName);
        }
    }

    public function download_modified($id) {

    }
}
