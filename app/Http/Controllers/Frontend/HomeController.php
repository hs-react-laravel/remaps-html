<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\SliderManager;
use App\Models\Package;
use App\Models\Api\ApiPackage;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function innerhome(){
		$packages = [];
		$packages = Package::all()->toArray();
		$slider = SliderManager::all()->toArray();
		return view('Frontend.inner_home',compact('slider','packages'));
	}
	public function index() {
        $packages = [];
		$packages = Package::all()->toArray();
		$slider = SliderManager::all()->toArray();
        $apiPackage = ApiPackage::first();
		return view('Frontend.home',compact('slider','packages', 'apiPackage'));
	}

}
