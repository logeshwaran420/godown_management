<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function login(){
        return view("auth.login");  
    }
    public function destroy(){
        Auth::logout();
        return redirect('login');
    }
}
