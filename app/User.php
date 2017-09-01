<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'userId', 'token', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function store($userId, $userName, $usereMail, $token, $avatar){
        $user = new User();
        $user->user_id = $userId;
        $user->name = $userName;
        $user->email = $usereMail;
        $user->avatar = $avatar;
        $user->token = $token;
        if($user->save()){
            return $user;
        }
        return true;
    }

    public function notifications()
    {
        return $this->hasMany('Notification');
    }

    public function newNotification()
    {
        $notification = new Notification;
        $notification->user()->associate($this);

        return $notification;
    }
}
