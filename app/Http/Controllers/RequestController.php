<?php

namespace App\Http\Controllers;


use App\Models\Request;

class RequestController extends Controller
{
    public function acceptRequest(Request $request){
        $request->update(['answered'=>1]);
        auth()->user()->addFriendToTable($request->user_who_sent);
        return redirect()->route('user.requests');
    }

    public function declineRequest(Request $request){
        $request->delete();
        return redirect()->route('user.requests');
    }
}
