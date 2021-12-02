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
        $user = User::find($request->id);
        $query = FileService::whereHas('user', function($query) use($user){
            $query->where('company_id', $user->company_id);
        });
        if($request->status) {
            $query = $query->where('status', $request->status);
        }
        $entries = $query->orderBy('id', 'DESC')->get();

        $return_data = [];
        foreach($entries as $entry) {
            array_push($return_data, [
                $entry->displayable_id,
                $entry->car,
                $entry->license_plate,
                $entry->staff ? $entry->staff->fullname : '',
                $entry->created_at,
                '',
                route('fileservices.edit', ['fileservice' => $entry->id]), // edit route
                $entry->tickets
                    ? route('tickets.edit', ['ticket' => $entry->tickets->id])
                    : route('fileservice.tickets.create', ['id' => $entry->id]), // ticket route
                route('fileservices.destroy', $entry->id), // destroy route
                $entry->id,
            ]);
        }
        $json_data = array(
            "data" => $return_data
        );

        return response()->json($json_data);
    }

    public function removeFileServices($id) {
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
    }
}
