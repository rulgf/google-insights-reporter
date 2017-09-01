<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function getUser(){
        //dd(Auth::user()->name);
        //dd(Session::get('user')->name);
        return [Session::get('user')->name, Session::get('user')->avatar];
    }
}
