<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Auth;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function login(){
        $warehouses = Warehouse::all();
        return view("auth.login",compact('warehouses'));  
    }

    public function store(request $request){
       // dd($request->all());
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
