<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function user_who_sent(){
        return $this->belongsTo(User::class,'user_send_id');
    }

    public function user_who_received(){
        return $this->belongsTo(User::class,'user_receive_id');
    }
}
