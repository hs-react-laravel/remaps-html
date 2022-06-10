<?php

namespace App\Http\Controllers\Remaps;

use App\Http\Controllers\MasterController;
use Illuminate\Http\Request;

class ChatController extends MasterController
{
    //
    public function index()
    {
        return view('pages.chats.index');
    }
}
