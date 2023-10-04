<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\MasterController;
use App\Mail\NewNotificationEmail;
use App\Models\Notification;
use App\Models\NotificationRead;
use App\Models\User;

class NotificationController extends MasterController
{
    private function users() {
        $users = User::where('company_id', $this->user->company_id)
            ->where('is_admin', 0)
            ->whereNull('is_staff')
            ->orderBy('id', 'DESC')
            ->get();
        return $users;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.notification.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = $this->users();
        return view('pages.notification.create', [
            'users' => $users
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
        try {
            $request->request->add(['company_id'=> $this->company->id]);
            $notify = Notification::create($request->all());
            if ($request->to_all) {
                $users = $this->users();
                foreach($users as $u) {
                    NotificationRead::create([
                        'notification_id' => $notify->id,
                        'user_id' => $u->id,
                        'is_read' => 0
                    ]);

                    // try{
                    //     Mail::to($u->email)->send(new NewNotificationEmail($this->company, $u));
                    // }catch(\Exception $ex){
                    //     session()->flash('error', $ex->getMessage());
                    // }
                }
            } else {
                $userIDs = $request->to;
                foreach($userIDs as $uID) {
                    NotificationRead::create([
                        'notification_id' => $notify->id,
                        'user_id' => $uID,
                        'is_read' => 0
                    ]);
                    $u = User::find($uID);
                    // try{
                    //     Mail::to($u->email)->send(new NewNotificationEmail($this->company, $u));
                    // }catch(\Exception $ex){
                    //     session()->flash('error', $ex->getMessage());
                    // }
                }
            }
            return redirect(route('notifications.index'));
        } catch(\Exception $e){
            session()->flash('error', $e->getMessage());
            return redirect(route('notifications.index'));
        }
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
        $notification = Notification::find($id);
        $receivers = NotificationRead::where('notification_id', $notification->id)->pluck('user_id')->toArray();
        $users = $this->users();
        $is_sent_all = count($users) == count($receivers);
        // dd(0 == false_;
        return view('pages.notification.edit', [
            'data' => $notification,
            'receivers' => $receivers,
            'users' => $users,
            'is_sent_all' => $is_sent_all
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
        try {
            $request->request->add(['company_id'=> $this->company->id]);
            $notify = Notification::find($id);
            $notify->update($request->all());
            NotificationRead::where('notification_id', $id)->delete();
            if ($request->to_all) {
                $users = $this->users();
                foreach($users as $u) {
                    NotificationRead::create([
                        'notification_id' => $notify->id,
                        'user_id' => $u->id,
                        'is_read' => 0
                    ]);
                }
            } else {
                $userIDs = $request->to;
                foreach($userIDs as $uID) {
                    NotificationRead::create([
                        'notification_id' => $notify->id,
                        'user_id' => $uID,
                        'is_read' => 0
                    ]);
                }
            }
            return redirect(route('notifications.index'));
        } catch(\Exception $e){
            session()->flash('error', $e->getMessage());
            return redirect(route('notifications.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        NotificationRead::where('notification_id', $id)->delete();
        Notification::find($id)->delete();
        return redirect(route('notifications.index'));
    }

    public function api(Request $request)
    {
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
        $query = Notification::where('company_id', $user->company_id);

        $totalRecords = $query->count();
        $query = $query->where(function($query) use ($searchValue) {
            $query->where('subject', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('body', 'LIKE', '%'.$searchValue.'%');
        });
        $totalRecordswithFilter = $query->count();
        $entries = $query->orderBy($columnName, $columnSortOrder)->skip($start)->take($rowperpage)->get();
        $return_data = [];

        $allCustomers = $this->users();

        foreach($entries as $entry) {
            $types = ['Important News', 'Updates', 'News', 'General Info'];
            $customerIDs = NotificationRead::where('notification_id', $entry->id)->pluck('user_id');
            $customers = User::whereIn('id', $customerIDs)->get();
            $name_array = [];
            foreach($customers as $c) {
                array_push($name_array, $c->full_name);
            }
            array_push($return_data, [
                'subject' => $entry->subject,
                'body' => $entry->body,
                'to' => count($allCustomers) == count($customers) ? 'ALL' : implode(', ', $name_array),
                'type' => $types[$entry->icon],
                'actions' => '',
                'route.edit' => route('notifications.edit', ['notification' => $entry->id]), // edit route
                'route.destroy' => route('notifications.destroy', $entry->id) // destroy route
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
