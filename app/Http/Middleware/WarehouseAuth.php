<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WarehouseAuth
{
   
public function handle(Request $request, Closure $next)
{
    if (Auth::check()) {
       
        $requestedWarehouseId =auth()->user()->warehouse_id;

        $sessionWarehouseId = session('warehouse_id');
        if ($sessionWarehouseId && $sessionWarehouseId == $requestedWarehouseId) {
            return $next($request);
        }
        
         return redirect()->route('home')->withErrors(['warehouse' => 'Unauthorized warehouse access.']);
    }

    return redirect()->route('login');
}
 
}
