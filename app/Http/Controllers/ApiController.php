<?php

namespace App\Http\Controllers;

use App\Models\TuningType;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function tuning_type_options($id) {
        return TuningType::find($id)->tuningTypeOptions;
    }
}
