<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\User;

class HomeController extends Controller
{
    public function  __construct()
    {
        //Se valida que no este logueado
        if(!Auth::check()){
            $this->middleware('auth');
        }
    }

    public function index(){
        //$usuario = User::findOrFail(Auth::user()->id);
        
        return view('app', ['user_id' => Auth::user()->id]);
    }
}
