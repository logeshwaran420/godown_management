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
    $user = Auth::user();

    $user->warehouse_id = $this->warehouse_id;
    $user->save();

   session(['warehouse_id' => $this->warehouse_id]);

    return redirect()->route('home');
}
    }

        // $this->addError('email', 'Invalid credentials');

        
    // if (Auth::attempt($credentials)) {
    //     return redirect()->route('home');
    // }

// 
    // $this->addError('email', 'Invalid credentials or warehouse');
//     // }
// public function login()
// {
//     $this->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//         'warehouse_id' => 'required|exists:warehouses,id',
//     ]);

   
//         if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
//             session(['warehouse_id' => $this->warehouse_id]);
//             return redirect()->route('home');
//         }

//     $this->addError('email', 'Invalid credentials');
// }
    public function render()
    {
        return view('livewire.login-form');
    }

}
