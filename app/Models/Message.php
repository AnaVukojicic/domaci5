<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function user_who_sent(){
        return $this->belongsTo(User::class,'user_send_id');
    }

    public function user_who_received(){
        return $this->belongsTo(User::class,'user_receive_id');
    }

    public function changeDisplayed($value){
        return $this->update(['displayed'=>$value]);
    }

    public function changeDisplayedReceived($value){
        return $this->update(['displayed_received'=>$value]);
    }


}
