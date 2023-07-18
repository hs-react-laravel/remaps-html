<?php

namespace App\Http\Controllers\Remaps\Api;
use App\Http\Controllers\MasterController;
use App\Models\Api\ApiUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiUserController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = ApiUser::orderBy('id', 'DESC')->paginate(10);

        return view('pages.api.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.api.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add(['api_token'=> Str::random(50)]);
        $user = ApiUser::create($request->all());
        return redirect(route('apiusers.index'));
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
        $entry = ApiUser::find($id);
        return view('pages.api.users.edit', compact('entry'));
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
        $apiuser = ApiUser::find($id);
        $apiuser->update($request->all());
        return redirect(route('apiusers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = ApiUser::find($id);
        $customer->delete();
        return redirect(route('apiusers.index'));
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

        if ($columnName == 'name') $columnName = 'first_name';
        if ($columnName == 'email') $columnName = 'email';
        if ($columnName == 'phone') $columnName = 'phone';

        $user = User::find($request->id);

        $totalRecords = ApiUser::count();
        $query = ApiUser::where(function($query) use ($searchValue) {
            $query->where('first_name', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('last_name', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('email', 'LIKE', '%'.$searchValue.'%');
            $query->orWhere('phone', 'LIKE', '%'.$searchValue.'%');
        });
        $totalRecordswithFilter = $query->count();
        $entries = $query->orderBy($columnName, $columnSortOrder)->skip($start)->take($rowperpage)->get();
        $return_data = [];
        foreach($entries as $entry) {
            array_push($return_data, [
                'name' => $entry->fullName,
                'email' => $entry->email,
                'phone' => $entry->phone,
                'actions' => '',
                'route.edit' => route('apiusers.edit', ['apiuser' => $entry->id]), // edit route
                'route.destroy' => route('apiusers.destroy', ['apiuser' => $entry->id]), // edit route
                'route.subscription' => route('api.subscription.index', ['user_id' => $entry->id])
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

    public function generateToken() {
        return Str::random(60);
    }
}
