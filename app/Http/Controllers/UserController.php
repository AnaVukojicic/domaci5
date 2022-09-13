<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Request;
use App\Models\User;

class UserController extends Controller
{
    public function showFriends(){
        $currentUser=auth()->user();
        $friends=$currentUser->friends();
        return view('user.friends',[
            'friends'=>$friends
        ]);
    }

    public function showSuggestions(){
        $currentUser=auth()->user();
        $not_friends=$currentUser->notFriends();
        return view('user.suggestions',[
            'not_friends'=>$not_friends
        ]);
    }

    public function sendRequest(User $user){
        $user_send_id=auth()->user()->id;
        $user_receive_id=$user->id;
        Request::query()->create([
            'user_send_id'=>$user_send_id,
            'user_receive_id'=>$user_receive_id
        ]);
        return redirect()->route('user.suggestions');
    }

    public function showRequests(){
        $requests=auth()->user()->received_requests()->where('answered','=',0)->get();
        return view('user.requests',[
            'requests'=>$requests
        ]);
    }

}
