<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function showMessages(User $user){
        $messages=Message::query()->where(['user_send_id'=>auth()->user()->id,'user_receive_id'=>$user->id])->
                orWhere(function($query) use($user)
                {
                    $query->where('user_send_id', '=', $user->id)
                        ->where('user_receive_id', '=', auth()->user()->id);
                })->orderBy('created_at','asc')->get();

        foreach($messages->where('user_receive_id','=',auth()->user()->id) as $message){
            $message->changeDisplayed(1);
            $message->changeDisplayedReceived(1);
        }

        return view('message.index',[
            'messages'=>$messages,
            'user'=>$user
        ]);
    }

    public function saveMessage(MessageRequest $request,User $user){
        Message::query()->create([
            'user_send_id'=>auth()->user()->id,
            'user_receive_id'=>$user->id,
            'message_content'=>$request->message_content
        ]);
    }

    public function getNewMessages(User $user){
        $messages1= auth()->user()->received_messages()->where('user_send_id','=',$user->id)->
                where('displayed_received','=',0)->get();
        $messages2=auth()->user()->sent_messages()->where('user_receive_id','=',$user->id)->
                where('displayed','=',0)->get();

        $messages=$messages1->merge($messages2);

        foreach($messages as $message){
            if($message->user_send_id==auth()->user()->id)
                $message->changeDisplayed(1);
            else
                $message->changeDisplayedReceived(1);
        }

        return $messages;
    }
}
