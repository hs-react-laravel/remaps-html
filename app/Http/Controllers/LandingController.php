<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MasterController;
use App\Models\SliderManager;
use App\Models\Package;
use App\Models\Api\ApiPackage;
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
        $packages = [];
		$packages = Package::all()->toArray();
		$slider = SliderManager::all()->toArray();
        $apiPackage = ApiPackage::first();
        return view('pages.landing.'.$link, compact('slider','packages'));
    }
}
