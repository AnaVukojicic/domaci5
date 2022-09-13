<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const DEFAULT_PHOTO='default-photo.jpg';

    public function requested_users(){
        return $this->belongsToMany(User::class,'friendship','user_id_1','user_id_2');
    }

    public function requesting_users(){
        return $this->belongsToMany(User::class,'friendship','user_id_2','user_id_1');
    }

    public function sent_requests(){
        return $this->hasMany(Request::class,'user_send_id','id');
    }

    public function received_requests(){
        return $this->hasMany(Request::class,'user_receive_id','id');
    }

    public function sent_messages(){
        return $this->hasMany(Message::class,'user_send_id','id');
    }

    public function received_messages(){
        return $this->hasMany(Message::class,'user_receive_id','id');
    }

    public function friends(){
        $friends1=$this->requested_users()->where('accepted','=',1)->get();
        $friends2=$this->requesting_users()->where('accepted','=',1)->get();
        return $friends1->merge($friends2);
    }

    public function notFriends(){
        $friends=$this->friends();
        $requested=$this->sent_requests()->get()->merge($this->received_requests()->get());
        $friendshipAndRequestedIds=[$this->id];
        foreach($friends as $friend){
            $friendshipAndRequestedIds[]=$friend->id;
        }
        foreach($requested as $r){
            $friendshipAndRequestedIds[]=$r->user_send_id;
            $friendshipAndRequestedIds[]=$r->user_receive_id;
        }
        $not_friends=User::query()->whereNotIn('id',$friendshipAndRequestedIds)->get();
        return $not_friends;
    }

    public function isFriend($user){
        return $this->friends()->where('id','=',$user->id)->count()>0;
    }

    public function addFriendToTable($user){
        return $this->requesting_users()->attach($user->id,['accepted'=>true]);
    }



}
