@extends('layouts.app')

@section('content')


<x-layout.topbar />

     
<div class="p-6 space-y-6  min-h-screen">

  <h1 class="text-2xl font-bold text-gray-800">{{ $warehouse->name }} Dashboard</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-green-100 p-4 rounded shadow">
      <div class="text-sm text-gray-600">Total Items</div>
      <div class="text-2xl font-bold text-gray-800">{{ $items->sum(fn($item) => $item->current_stock) }}</div>
    </div>
    <div class="bg-red-100 p-4 rounded shadow">
      <div class="text-sm text-gray-600">In Inventory</div>
      <div class="text-2xl font-bold text-gray-800">{{ $inventories->sum(fn($inventory) => $inventory->current_stock) }}</div>
    </div>
    
    <div class="bg-blue-100 p-4 rounded shadow">
      <div class="text-sm text-gray-600">Total Inwards</div>
      <div class="text-2xl font-bold text-gray-800">    {{ $inwards->sum(fn($inward) => $inward->total_quantity) }}</div>
    </div>
    <div class="bg-yellow-100 p-4 rounded shadow">
      <div class="text-sm text-gray-600">Total Outwards</div>
      <div class="text-2xl font-bold text-gray-800"> 
         {{ $outwards->sum(fn($outward) => $outward->total_quantity) }}   
        </div>
    </div>
  </div>

 
 







     <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Today Activities</h3>
                <div class="grid grid-cols-2 gap-4 text-center text-sm">
                    <div>
                        <p class="text-blue-600 text-2xl font-bold">
                            {{ $inwards->filter(fn($inward) => \Carbon\Carbon::parse($inward->date)->isToday())->sum(fn($inward) => $inward->total_quantity) }}
                       </p>
                        <p class="text-gray-500">Inwards</p>
                    </div>
                    <div>
                        <p class="text-red-500 text-2xl font-bold">
                            {{ $outwards->filter(fn($outward) => \Carbon\Carbon::parse($outward->date)->isToday())->sum(fn($outward) => $outward->total_quantity) }}
                        </p>
                        <p class="text-gray-500">Outwards</p>
                    </div>
                </div>
            </div>
            
           <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Movements</h3>
                <div class="grid grid-cols-2 gap-4 text-center text-sm">
                    <div>
                        <p class="text-blue-600 text-2xl font-bold">
                              {{ $movements->sum(fn($movement) => $movement->total_quantity) }}
                        </p>
                        <p class="text-gray-500">Moved items</p>
                    </div>
                    <div>
                        <p class="text-red-500 text-2xl font-bold">
                       
                             {{ $movements->filter(fn($movement) => \Carbon\Carbon::parse($movement->date)->isToday())->sum(fn($movement) => $movement->total_quantity) }}
                         </p>
                        <p class="text-gray-500">Today Movements</p>
                    </div>
                </div>
            </div>


<div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
  <p class="font-semibold text-green-800 mb-2">Top Inventory Items</p>
  <ul class="list-disc ml-5 text-sm text-gray-700">
    @foreach ($inventories->sortByDesc('current_stock')->take(3) as $inventory)
      <li>{{ $inventory->item->name }} - Quantity: {{ $inventory->current_stock }}</li>
    @endforeach
  </ul>
</div>
<div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
  <p class="font-semibold text-yellow-800 mb-2">Low Inventory Items</p>
  <ul class="list-disc ml-5 text-sm text-gray-700">
    @foreach ($inventories->filter(fn($inv) => $inv->current_stock > 0)->sortBy('current_stock')->take(3) as $inventory)
      <li>{{ $inventory->item->name }} - Quantity: {{ $inventory->current_stock }}</li>
    @endforeach
  </ul>
</div>
     </div>
</div>

   
@endsection
