<?php

namespace App\Http\Controllers\Remaps;

use App\Helpers\Helper;
use App\Http\Controllers\MasterController;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends MasterController
{
    //
    public function index()
    {
        $messageUserIDs = ChatMessage::where('company_id', $this->company->id)
            ->select('target')
            ->groupBy('target')
            ->pluck('target')
            ->toArray();
        $mUsers = User::whereIn('id', $messageUserIDs)->get();
        $cUsers = User::whereNotIn('id', $messageUserIDs)->get();

        return view('pages.chats.index')->with(compact('mUsers', 'cUsers'));
    }
}
