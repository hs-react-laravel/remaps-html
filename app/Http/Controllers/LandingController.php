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

    public function team_grid() {
        return view('pages.landing.grid');
    }

    public function page_link(Request $request, $link) {
        return view('pages.landing.'.$link);
    }
}
