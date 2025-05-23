<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function login(){
        return view("auth.login");  
    }

    public function store(request $request){
         $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            session(['warehouse_id' => $request->warehouse_id]);

            $token = Auth::user()->createToken('warehouse-app')->plainTextToken;
            session(['api_token' => $token]);

            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }



    public function destroy(){
        Auth::logout();
        return redirect('login');
    }
}
