<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MasterController;
use Illuminate\Http\Request;

class LandingController extends MasterController
{
    //
    public function test() {
        return view('pages.landing.test');
    }
}
