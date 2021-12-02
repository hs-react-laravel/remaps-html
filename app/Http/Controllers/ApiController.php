<?php

namespace App\Http\Controllers;

use App\Models\TuningType;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Company;
use App\Models\Styling;
use App\Models\User;
use App\Models\FileService;

class ApiController extends Controller
{
    //
    public function tuning_type_options($id) {
        return TuningType::find($id)->tuningTypeOptions;
    }

    public function car_query(Request $request)
    {
        if ($request->model == '') {
            $models = Car::where('brand', $request->make)
                ->groupBy('model')
                ->pluck('model');
            return $models;
        }
        if ($request->generation == '') {
            $generations = Car::where('brand', $request->make)
                ->where('model', $request->model)
                ->groupBy('year')
                ->pluck('year');
            return $generations;
        }
        if ($request->engine == '') {
            $engines = Car::where('brand', $request->make)
                ->where('model', $request->model)
                ->where('year', $request->generation)
                ->get();
            return $engines;
        }
    }

    public function car_id(Request $request)
    {
        $id = Car::where('brand', $request->make)
            ->where('model', $request->model)
            ->where('year', $request->generation)
            ->where('engine_type', $request->engine)
            ->first()->id;
        return $id;
    }

    public function change_style(Request $request)
    {
        $company = Company::find($request->input('company'));
        $styling = Styling::where('company_id', $company->id)->first();
        $styleObj = (array)json_decode($styling->data);
        if ($request->input('type') == 'theme') {
            switch($request->input('value')) {
                case '':
                    $styleObj['theme'] = 'light';
                    break;
                case 'dark-layout':
                    $styleObj['theme'] = 'dark';
                    break;
                case 'semi-dark-layout':
                    $styleObj['theme'] = 'semi-dark';
                    break;
                case 'bordered-layout':
                    $styleObj['theme'] = 'bordered';
                    break;
            }
        } else if ($request->input('type') == 'layoutWidth') {
            $styleObj['layoutWidth'] = $request->input('value');
        } else if ($request->input('type') == 'navbarColor') {
            $styleObj['navbarColor'] = $request->input('value');
        } else if ($request->input('type') == 'navbarType') {
            if ($styleObj['mainLayoutType'] == 'vertical') {
                $styleObj['verticalMenuNavbarType'] = $request->input('value');
            } else if ($styleObj['mainLayoutType'] == 'horizontal') {
                $styleObj['horizontalMenuType'] = $request->input('value');
            }
        } else if ($request->input('type') == 'footerType') {
            $styleObj['footerType'] = $request->input('value');
        }
        $styling->data = json_encode($styleObj);
        $styling->save();
        return $request->input('value');
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
        if($request->status) {
            $query = $query->where('status', $request->status);
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
