@extends('layouts.app')

@section('content')


{{-- {{ $inwards->filter(fn($inward) => \Carbon\Carbon::parse($inward->date)->isToday())->sum(fn($inward) => $inward->total_quantity) }} --}}
    <x-layout.topbar />

    <div class="container mx-auto px-4 py-6 space-y-8">
       
<div class="p-6 space-y-6  min-h-screen">
  <!-- Heading -->
  <h1 class="text-2xl font-bold text-gray-800">{{ $warehouse->name }} Dashboard</h1>

  <!-- Summary Cards -->
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

 
 

  <!-- Low Stock Alerts -->
  {{-- <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
    <p class="font-semibold text-yellow-800 mb-2">Low Stock Alerts:</p>
    <ul class="list-disc ml-5 text-sm text-gray-700">
      <li>Item A - Stock: 3</li>
      <li>Item B - Stock: 7</li>
      <li>Item C - Stock: 2</li>
    </ul>
  </div> --}}

  {{-- <!-- Recent Movements Table -->
  <div class="bg-white shadow rounded">
    <div class="p-4 border-b">
      <h2 class="font-semibold text-lg text-gray-800">Recent Movements</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 font-medium text-gray-600">Date</th>
            <th class="px-4 py-2 font-medium text-gray-600">Type</th>
            <th class="px-4 py-2 font-medium text-gray-600">Item</th>
            <th class="px-4 py-2 font-medium text-gray-600">Qty</th>
            <th class="px-4 py-2 font-medium text-gray-600">Warehouse</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr>
            <td class="px-4 py-2">2025-05-23</td>
            <td class="px-4 py-2">Inward</td>
            <td class="px-4 py-2">Item A</td>
            <td class="px-4 py-2">    {{ $inwards->filter(fn($inward) => \Carbon\Carbon::parse($inward->date)->isToday())->sum(fn($inward) => $inward->total_quantity) }}
                </td>
            <td class="px-4 py-2">Main Warehouse</td>
          </tr>
          <tr>
            <td class="px-4 py-2">2025-05-22</td>
            <td class="px-4 py-2">Outward</td>
            <td class="px-4 py-2">Item B</td>
            <td class="px-4 py-2">20</td>
            <td class="px-4 py-2">Branch 1</td>
          </tr>
          <!-- More rows as needed -->
        </tbody>
      </table>
    </div>
  </div> --}}






     <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Today Activities</h3>
                <div class="grid grid-cols-2 gap-4 text-center text-sm">
                    <div>
                        <p class="text-blue-600 text-2xl font-bold">
                            {{ $inwards->filter(fn($inward) => \Carbon\Carbon::parse($inward->date)->isToday())->sum(fn($inward) => $inward->total_quantity) }}
                       </p>
                        <p class="text-gray-500">Total Inwards</p>
                    </div>
                    <div>
                        <p class="text-red-500 text-2xl font-bold">
                            {{ $outwards->filter(fn($outward) => \Carbon\Carbon::parse($outward->date)->isToday())->sum(fn($outward) => $outward->total_quantity) }}
                        </p>
                        <p class="text-gray-500">Today Outwards</p>
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





@endsection
