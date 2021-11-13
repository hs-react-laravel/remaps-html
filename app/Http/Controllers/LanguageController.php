<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    //
    public function swap($locale){
         // available language in template array
        $availLocale=[
            'en'=>'en',
            'fr'=>'fr',
            'es'=>'es',
            'pt'=>'pt',
            'it'=>'it',
            'jp'=>'jp',
            'nl'=>'nl',
            'pl'=>'pl',
            'de'=>'de',
            'ru'=>'ru',
            'tr'=>'tr',
            'no'=>'no',
            'se'=>'se',
            'da'=>'da',
        ];
        // check for existing language
        if(array_key_exists($locale,$availLocale)){
            session()->put('locale',$locale);
        }
         return redirect()->back();
    }
}
