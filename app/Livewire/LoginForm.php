<?php

namespace App\Livewire;

use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginForm extends Component
{
    public $email;
    public $password;
    public $warehouse_id;
    public $warehouses;

    public function mount()
    {
        $this->warehouses = Warehouse::all();
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);
        
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
           session(['warehouse_id' => $this->warehouse_id]); 

                   $user = Auth::user();

       $token = $user->createToken('warehouse-app')->plainTextToken;

       session(['api_token' => $token]);

         
           return redirect()->route('home');
}
}

       
    public function render()
    {
        return view('livewire.login-form');
    }

}
