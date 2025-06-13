@extends('layouts.app')

@section('content')
<x-layout.topbar />





<div class="p-6 min-h-screen bg-gray-50">

    

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <div class="flex items-center">
                <h1 class="text-3xl font-bold text-gray-800">{{ $warehouse->name }} Dashboard</h1>
                <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">{{ $warehouse->id }}</span>
            </div>
            <div class="text-sm text-gray-500 mt-2">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $warehouse->address_line1 }}, {{ $warehouse->city }}, {{ $warehouse->state }},{{ $warehouse->country }}
                </div>
            </div>
        </div>
        
        
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Items Card -->
        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Items</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">{{ number_format($items->sum(fn($item) => $item->current_stock)) }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $items->count() }} different products</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>



        <!-- Inventory Value Card -->
        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">In Inventory </p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">
                        {{number_format( $inventories->sum(fn($inv) => $inv->current_stock))}}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">{{ $inventories->count() }} inventory items</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

  @php
    $capacity = $items->sum(fn($item) => $item->current_stock);
    $usedStock = $inventories->sum(fn($inventory) => $inventory->current_stock);

    if ($capacity > 0) {
        $percentage = min(100, ($usedStock / $capacity) * 100);
    } else {
        $percentage = 0;
    }
@endphp



<div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-purple-500 hover:shadow-md transition">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">Inventory Capacity</p>
            <div class="mt-2">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-purple-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $capacity > 0 ? number_format($percentage, 1) . '% used' : 'Capacity not set' }}
                </p> 
            </div>
        </div>
        <div class="bg-purple-100 p-3 rounded-full">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
</svg>
        </div>
    </div>
</div>



<!-- Stock Movement Card -->
{{-- <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-amber-500 hover:shadow-md transition group">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">Stock Movement</p>
            <div class="flex items-end space-x-2">
                 <p class="text-2xl font-semibold text-gray-800 mt-1">
                    {{ $movementPercentage = min(100, max(-100, ($monthlyMovement / ($items->sum('current_stock') ?: 1)) }} 
                </p>
                <span class="flex items-center text-sm ">
                        {{-- @if($monthlyMovement >= 0)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-bounce" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1v-5a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                        </svg>
                        @endif 
                   unit
                </span>
            </div>
            <p class="text-xs text-gray-400 mt-1">Last 30 days</p>
        </div>
        <div class="bg-amber-100 p-3 rounded-full group-hover:rotate-12 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
        </div>
    </div>
</div> --}}
        



<div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-amber-500 hover:shadow-md transition group">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">Item Outwards</p>
            <div class="flex items-end space-x-2">
                <p class="text-2xl font-semibold text-gray-800 mt-1">
                  
                    @php
                        // Calculate total movement (positive for incoming, negative for outgoing)
                        // $totalMovement = $inwards->sum('total_quantity') - $outwards->sum('total_quantity');
                        // $totalMovement = $items->sum('current_stock');
                        $totalMovement = $outwards->sum('total_quantity');

                    $percentageChange = ($totalMovement / max(1, $inventories->sum('current_stock') ) * 100);
                        // $percentageChange = ($totalMovement / max(1, $items->sum('current_stock'))) * 100;

                        
                        $formattedPercentage = number_format(abs($percentageChange), 1);
                   
                    @endphp



                    
                    @if($totalMovement > 0)
                        +{{ $formattedPercentage }}%
                    @elseif($totalMovement < 0)
                        -{{ $formattedPercentage }}%
                    @else
                        0%
                    @endif
                </p>
                <span class="flex items-center text-sm {{ $totalMovement >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    @if($totalMovement > 0)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-bounce" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                        </svg>
                        {{ $totalMovement }} in
                    @elseif($totalMovement < 0)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1v-5a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                        </svg>
                        {{ abs($totalMovement) }} out
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        No change
                    @endif
                </span>
            </div>
            {{-- <p class="text-xs text-gray-400 mt-1">Net change last 30 days</p> --}}
        </div>
        <div class="bg-amber-100 p-3 rounded-full group-hover:rotate-12 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
        </div>
    </div>
</div>

















    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 space-y-6">

       


            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Transactions</h3>
               
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ledger Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th> --}}
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 ">
                         @forelse ($recentActivities->take(5) as $activity)



                                @php          
    $route = '';
    if ($activity->type === 'inward') {
        $route = route('inwards.show', $activity);
    } elseif ($activity->type === 'outward') {
        $route = route('outwards.show', $activity);
    } 
@endphp
       <tr class="hover:bg-gray-50 transition cursor-pointer"               
       onclick="window.location='{{ $route }}'">

   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          {{ \Carbon\Carbon::parse($activity->created_at)->format('M d, Y') }}
                        </td>
        <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $activity->type === 'inward' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($activity->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                              {{ $activity->ledger->name }}

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $unitTotals = [];
                                    foreach ($activity->details as $detail) {
                                        $unit = $detail->item->unit;
                                        $unitId = $unit->id;
                                        $unitName = $unit->abbreviation;
                                        $quantity = $detail->quantity;

                                        if (!isset($unitTotals[$unitId])) {
                                            $unitTotals[$unitId] = ['name' => $unitName, 'qty' => 0];
                                        }

                                        $unitTotals[$unitId]['qty'] += $quantity;
                                    }
                                @endphp

                                @foreach ($unitTotals as $unit)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ $unit['qty'] }}{{ $unit['name'] }}
                                    </span>
                                @endforeach
                            </td>

                                {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Completed
                                    </span>
                                </td> --}}
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No recent activities found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

         <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Inventory Overview</h3>
                    <div class="flex space-x-2">
                         <button id="dayBtn" class="px-3 py-1 text-xs bg-blue-100 text-blue-800 rounded-md">Day</button>
            <button id="monthBtn" class="px-3 py-1 text-xs bg-gray-100 text-gray-800 rounded-md">Monthly</button>
            <button id="allBtn" class="px-3 py-1 text-xs bg-gray-100 text-gray-800 rounded-md">All</button>
                    </div>
                </div>
                <div class="h-64">
                    <div class="flex items-center justify-center h-full bg-gray-50 rounded-lg border border-gray-200">
                       <canvas id="inventoryChart"></canvas>
                    </div>
                </div>
            </div> 
        </div>






<div class="space-y-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 gap-3">
        
    <button id="openItem"  class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
    <div class="bg-blue-100 p-3 rounded-full mb-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
    </div>
    <span class="text-sm font-medium text-gray-700">Item</span>
</button>

   

 <button type="button" id="open-modal" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 transition-colors bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 active:bg-green-100">
       <div class="bg-green-100 p-3 rounded-full mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700">Category</span>
    </button>

        <!-- Ledger -->
    <button  type="button" id="ledgeropenModalBtn"   class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 transition-colors bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 active:bg-purple-100">
    <div class="bg-purple-100 p-3 rounded-full mb-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
    </div>
    <span class="text-sm font-medium text-gray-700">Ledger</span>
</button>

        <!-- Inward -->
        <a href="{{ route('inwards.create') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-yellow-50 transition">
            <div class="bg-yellow-100 p-3 rounded-full mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Inward</span>
        </a>

        <!-- Outward -->
        <a href="{{ route('outwards.create') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-red-50 transition">
            <div class="bg-red-100 p-3 rounded-full mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2m-4-4l-4 4m0 0l-4-4m4 4V3" />
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Outward</span>
        </a>

        <!-- Movement -->
        <a href="{{ route('movements.create') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-indigo-50 transition">
            <div class="bg-indigo-100 p-3 rounded-full mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Movement</span>
        </a>
    </div>
</div>
            <!-- Inventory Alerts -->
            <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-red-500">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800">Critical Alerts</h3>
                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">{{ $lowInventory->count() }} alerts</span>
                </div>
                <ul class="divide-y divide-gray-100">
            @forelse ($lowInventory->take(3) as $inventory)
            <li class="py-3 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-md overflow-hidden bg-gray-200 mr-3">
                        @if($inventory->item->image)
                            <img src="{{ asset('storage/' . $inventory->item->image) }}" alt="{{ $inventory->item->name }}" class="h-full w-full object-cover">
                        @else
                            <svg class="h-full w-full text-gray-400 p-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">{{ $inventory->item->name }}</p>
                        <p class="text-xs text-gray-500">{{ $inventory->item->category->name ?? 'Uncategorized' }}</p>
                    </div>
                </div>
                        <span class="text-sm font-semibold text-red-600">{{ $inventory->current_stock }} / {{ $inventory->item->current_stock }}</span>
            </li>
            @empty
            <li class="py-3 text-center text-sm text-gray-500">
                No critical alerts at this time
            </li>
            @endforelse
        </ul>
    @if($lowInventory->count() > 1)
            <div class="mt-4 text-center">
                <a href="{{ route('inventory.items.low') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all alerts</a>
            </div>
       
               @endif

            </div>





       
        </div>
      






        <!-- Right Sidebar -->
     <div class="space-y-6">
   
    <!-- Inventory Alerts -->
   
</div>
    </div>
</div>








     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>


 <script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('inventoryChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: { labels: [], datasets: [] },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { boxWidth: 12, padding: 20 }
                },
                title: {
                    display: true,
                    text: 'Loading data...',
                    font: { size: 16 }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    bodyFont: { size: 14 },
                    titleFont: { size: 16 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Quantity',
                        font: { weight: 'bold' }
                    },
                    grid: { drawBorder: false, color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Time Period',
                        font: { weight: 'bold' }
                    },
                    grid: { display: false }
                }
            },
            elements: {
                point: { radius: 4, hoverRadius: 6 }
            }
        }
    });

    fetch("{{ route('graph') }}")
        .then(res => res.json())
        .then(serverData => {
            const chartData = {
                day: {
                    labels: serverData.day_labels,
                    datasets: [
                        {
                            label: 'Inward Stock',
                            data: serverData.inwards_day,
                            backgroundColor: 'rgba(74, 222, 128, 0.2)',
                            borderColor: 'rgba(74, 222, 128, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Outward Stock',
                            data: serverData.outwards_day,
                            backgroundColor: 'rgba(248, 113, 113, 0.2)',
                            borderColor: 'rgba(248, 113, 113, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                month: {
                    labels: serverData.weekLabels,
                    datasets: [
                        {
                            label: 'Inward Stock',
                            data: serverData.inwardsWeek,
                            backgroundColor: 'rgba(74, 222, 128, 0.2)',
                            borderColor: 'rgba(74, 222, 128, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Outward Stock',
                            data: serverData.outwardsWeek,
                            backgroundColor: 'rgba(248, 113, 113, 0.2)',
                            borderColor: 'rgba(248, 113, 113, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                all: {
                    labels: serverData.all_labels,
                    datasets: [
                        {
                            label: 'Inward Stock',
                            data: serverData.inwards_all,
                            backgroundColor: 'rgba(74, 222, 128, 0.2)',
                            borderColor: 'rgba(74, 222, 128, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Outward Stock',
                            data: serverData.outwards_all,
                            backgroundColor: 'rgba(248, 113, 113, 0.2)',
                            borderColor: 'rgba(248, 113, 113, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }
                    ]
                }
            };

            // Initial chart setup
            chart.data = chartData.day;
            chart.options.plugins.title.text = 'Daily Stock Movement';
            chart.update();
            updateActiveButton('dayBtn');

            // Event Listeners
            document.getElementById('dayBtn').addEventListener('click', () => {
                chart.data = chartData.day;
                chart.options.plugins.title.text = 'Daily Stock Movement';
                chart.update();
                updateActiveButton('dayBtn');
            });

            document.getElementById('monthBtn').addEventListener('click', () => {
                chart.data = chartData.month;
                chart.options.plugins.title.text = 'Monthly Stock Movement';
                chart.update();
                updateActiveButton('monthBtn');
            });

            document.getElementById('allBtn').addEventListener('click', () => {
                chart.data = chartData.all;
                chart.options.plugins.title.text = 'Overall Stock Trend';
                chart.update();
                updateActiveButton('allBtn');
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            chart.options.plugins.title.text = 'Error loading data';
            chart.update();
        });

    function updateActiveButton(activeId) {
        const buttons = ['dayBtn', 'monthBtn', 'allBtn'];
        buttons.forEach(id => {
            const btn = document.getElementById(id);
            if (btn) {
                if (id === activeId) {
                    btn.classList.remove('bg-gray-100', 'text-gray-800');
                    btn.classList.add('bg-blue-100', 'text-blue-800');
                } else {
                    btn.classList.remove('bg-blue-100', 'text-blue-800');
                    btn.classList.add('bg-gray-100', 'text-gray-800');
                }
            }
        });
    }
});
</script>









{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch("{{ route('graph') }}")
        .then(res => res.json())
        .then(data => {
            // Prepare labels (dates)
            const inwards = data.inwards;
            const outwards = data.outwards;

            // Get all unique dates from both datasets
            const allDates = Array.from(new Set([
                ...inwards.map(i => i.date),
                ...outwards.map(o => o.date)
            ])).sort();

            // Map totals to dates (fill 0 if missing)
            const inwardsMap = Object.fromEntries(inwards.map(i => [i.date, i.total_qty]));
            const outwardsMap = Object.fromEntries(outwards.map(o => [o.date, o.total_qty]));

            const inwardsData = allDates.map(date => Number(inwardsMap[date] || 0));
            const outwardsData = allDates.map(date => Number(outwardsMap[date] || 0));

            // Chart.js
            const ctx = document.getElementById('inventoryChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: allDates,
                    datasets: [
                        {
                            label: 'Inwards',
                            data: inwardsData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Outwards',
                            data: outwardsData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Inwards vs Outwards (Qty by Date)' }
                    },
                    scales: {
                        x: { title: { display: true, text: 'Date' } },
                        y: { title: { display: true, text: 'Total Quantity' }, beginAtZero: true }
                    }
                }
            });

            // Optional: Button handlers for different views (if you want to filter by day/month/all)
            document.getElementById('dayBtn').addEventListener('click', () => {
                // Implement your own filtering logic for "day" view if needed
                chart.data.labels = allDates;
                chart.data.datasets[0].data = inwardsData;
                chart.data.datasets[1].data = outwardsData;
                chart.update();
                updateActiveButton('dayBtn');
            });
            document.getElementById('monthBtn').addEventListener('click', () => {
                // Implement your own filtering logic for "month" view if needed
                chart.data.labels = allDates;
                chart.data.datasets[0].data = inwardsData;
                chart.data.datasets[1].data = outwardsData;
                chart.update();
                updateActiveButton('monthBtn');
            });
            document.getElementById('allBtn').addEventListener('click', () => {
                chart.data.labels = allDates;
                chart.data.datasets[0].data = inwardsData;
                chart.data.datasets[1].data = outwardsData;
                chart.update();
                updateActiveButton('allBtn');
            });

            function updateActiveButton(activeId) {
                const buttons = ['dayBtn', 'monthBtn', 'allBtn'];
                buttons.forEach(id => {
                    const btn = document.getElementById(id);
                    if (btn) {
                        if (id === activeId) {
                            btn.classList.remove('bg-gray-100', 'text-gray-800');
                            btn.classList.add('bg-blue-100', 'text-blue-800');
                        } else {
                            btn.classList.remove('bg-blue-100', 'text-blue-800');
                            btn.classList.add('bg-gray-100', 'text-gray-800');
                        }
                    }
                });
            }
        });
});
</script> --}}


 {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   
    const chartData = {
        day: {
            labels: ['8AM', '10AM', '12PM', '2PM', '4PM', '6PM'],
            datasets: [
                {
                    label: 'Inward Stock',
                    data: [12, 19, 15, 27, 22, 18],
                    backgroundColor: 'rgba(74, 222, 128, 0.2)',
                    borderColor: 'rgba(74, 222, 128, 1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Outward Stock',
                    data: [8, 12, 6, 14, 10, 9],
                    backgroundColor: 'rgba(248, 113, 113, 0.2)',
                    borderColor: 'rgba(248, 113, 113, 1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        month: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [
                {
                    label: 'Inward Stock',
                    data: [120, 190, 150, 220],
                    backgroundColor: 'rgba(74, 222, 128, 0.2)',
                    borderColor: 'rgba(74, 222, 128, 1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Outward Stock',
                    data: [80, 120, 90, 140],
                    backgroundColor: 'rgba(248, 113, 113, 0.2)',
                    borderColor: 'rgba(248, 113, 113, 1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        all: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Inward Stock',
                    data: [450, 520, 480, 600, 550, 580],
                    backgroundColor: 'rgba(74, 222, 128, 0.2)',
                    borderColor: 'rgba(74, 222, 128, 1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Outward Stock',
                    data: [380, 420, 400, 480, 450, 430],
                    backgroundColor: 'rgba(248, 113, 113, 0.2)',
                    borderColor: 'rgba(248, 113, 113, 1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        }
    };

   
    const ctx = document.getElementById('inventoryChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: chartData.day,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Button event handlers
    document.getElementById('dayBtn').addEventListener('click', () => {
        chart.data = chartData.day;
        chart.update();
        updateActiveButton('dayBtn');
    });

    document.getElementById('monthBtn').addEventListener('click', () => {
        chart.data = chartData.month;
        chart.update();
        updateActiveButton('monthBtn');
    });

    document.getElementById('allBtn').addEventListener('click', () => {
        chart.data = chartData.all;
        chart.update();
        updateActiveButton('allBtn');
    });

    // Update active button style
    function updateActiveButton(activeId) {
        const buttons = ['dayBtn', 'monthBtn', 'allBtn'];
        buttons.forEach(id => {
            const btn = document.getElementById(id);
            if (id === activeId) {
                btn.classList.remove('bg-gray-100', 'text-gray-800');
                btn.classList.add('bg-blue-100', 'text-blue-800');
            } else {
                btn.classList.remove('bg-blue-100', 'text-blue-800');
                btn.classList.add('bg-gray-100', 'text-gray-800');
            }
        });
    }
</script> --}}


 <x-item.create-model :categories="$categories" :units="$units" />
<x-category.create-model/>
<x-category.edit-model :categories="$categories" />




   




<x-ledger.create-model />




<script>
document.addEventListener('DOMContentLoaded', function () {

    const ledgeropenModalBtn = document.getElementById('ledgeropenModalBtn');
    const ledgermodalOverlay = document.getElementById('ledgermodalOverlay');
    const ledgercloseModalBtn = document.getElementById('ledgercloseModalBtn');
    const ledgercancelBtn = document.getElementById('ledgercancelBtn');
    const form = document.getElementById('create-ledger-form');

    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const spinner = document.getElementById('spinner');

    // Open/Close modal
    function openModal() {
        ledgermodalOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        ledgermodalOverlay.style.display = 'none';
        document.body.style.overflow = 'auto';
        resetForm();
    }

    function resetForm() {
        form.reset();
        imagePreview.src = '';
        imagePreview.style.display = 'none';
        imagePlaceholder.style.display = 'block';
        removeImageBtn.style.display = 'none';
        
        // Clear all error messages
        document.querySelectorAll('[id^="error_"]').forEach(el => {
            el.textContent = '';
        });
    }

    ledgeropenModalBtn.addEventListener('click', openModal);
    ledgercloseModalBtn.addEventListener('click', closeModal);
    ledgercancelBtn.addEventListener('click', closeModal);
  
    // Generate random barcode
    generateBarcodeBtn.addEventListener('click', function () {
        const randomBarcode = 'BC' + Math.floor(100000000 + Math.random() * 900000000);
        barcodeInput.value = randomBarcode;
    });


    form.addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Clear previous errors
        document.querySelectorAll('[id^="error_"]').forEach(el => {
            el.textContent = '';
        });
        
        // Show loading state
        submitText.textContent = 'Saving...';
        spinner.classList.remove('hidden');
        submitBtn.disabled = true;
        
        // Prepare form data
        const formData = new FormData(form);
        
        // Submit via fetch API
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                

                
            // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
        })
        .then(response => {
    if (!response.ok) {
        return response.json().then(err => { throw err; });
    }
    return response.json();
})

        .then(data => {
           
            resetForm();
            closeModal();
            alert('Item added successfully!');
            
        })
        .catch(error => {
            if (error.errors) {
                Object.entries(error.errors).forEach(([field, messages]) => {
                    const errorElement = document.getElementById(`error_${field}`);
                    if (errorElement) {
                        errorElement.textContent = messages.join(' ');
                    }
                });
            } else {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        })
        .finally(() => {
            // Reset button state
            submitText.textContent = 'Save Item';
            spinner.classList.add('hidden');
            submitBtn.disabled = false;
        });
    });

   ledgermodalOverlay.addEventListener('click', function (e) {
        if (e.target === ledgermodalOverlay) {
            closeModal();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const countryDropdown = document.getElementById('country');
    const stateDropdown = document.getElementById('state');
    const cityDropdown = document.getElementById('city');

    const defaultCountry = 'India';
   const defaultstate = 'Tamil Nadu'; 



    fetch('https://countriesnow.space/api/v0.1/countries/positions')
        .then(res => res.json())
        .then(data => {
            data.data.forEach(country => {
                const option = document.createElement('option');
                option.value = country.name;
                option.textContent = country.name;
                if (country.name === defaultCountry) {
                    option.selected = true;
                }
                countryDropdown.appendChild(option);
            });

            const event = new Event('change');
            countryDropdown.dispatchEvent(event);
        });

    // Country change → load states
    countryDropdown.addEventListener('change', function () {
        const selectedCountry = this.value;
        // stateDropdown.innerHTML = '<option value="">Loading...</option>';
        // stateDropdown.disabled = true;
        cityDropdown.innerHTML = '<option value="">Select City</option>';
        cityDropdown.disabled = true;

        fetch('https://countriesnow.space/api/v0.1/countries/states', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ country: selectedCountry })
        })
        .then(res => res.json())
        .then(data => {
        
        stateDropdown.innerHTML = '<option value="">Select State</option>';
        data.data.states.forEach(state => {
                const option = document.createElement('option');
                option.value = state.name;
                option.textContent = state.name;
                stateDropdown.appendChild(option);
            });
            stateDropdown.disabled = false;
        });
    });

    // State change → load cities
    stateDropdown.addEventListener('change', function () {
        const selectedCountry = countryDropdown.value;
        const selectedState = this.value;
        // cityDropdown.innerHTML = '<option value="">Loading...</option>';
        // cityDropdown.disabled = true;

        fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ country: selectedCountry, state: selectedState })
        })
        .then(res => res.json())
        .then(data => {
            cityDropdown.innerHTML = '<option value="">Select City</option>';
            data.data.forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                cityDropdown.appendChild(option);
            });
            cityDropdown.disabled = false;
        });
    });
});
</script>




















<script>
document.addEventListener('DOMContentLoaded', function () {

    const openItem = document.getElementById('openItem');
    const modalOverlay = document.getElementById('modalOverlay');
    const ledgercloseModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('create-item-form');
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const imagePlaceholder = document.getElementById('imagePlaceholder');
    const removeImageBtn = document.getElementById('removeImageBtn');
    const generateBarcodeBtn = document.getElementById('generateBarcodeBtn');
    const barcodeInput = document.getElementById('barcode');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const spinner = document.getElementById('spinner');

    // Open/Close modal
    function openModal() {
        modalOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modalOverlay.style.display = 'none';
        document.body.style.overflow = 'auto';
        resetForm();
    }

    function resetForm() {
        form.reset();
        imagePreview.src = '';
        imagePreview.style.display = 'none';
        imagePlaceholder.style.display = 'block';
        removeImageBtn.style.display = 'none';
        




        document.querySelectorAll('[id^="error_"]').forEach(el => {
            el.textContent = '';
        });
    }

    openItem.addEventListener('click', openModal);
    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
  
    // Generate random barcode
    generateBarcodeBtn.addEventListener('click', function () {
        const randomBarcode = 'BC' + Math.floor(100000000 + Math.random() * 900000000);
        barcodeInput.value = randomBarcode;
    });

    // Image preview and validation
    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        const errorSpan = document.getElementById('error_image');

        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                errorSpan.textContent = 'Only JPG, PNG or GIF images are allowed';
                imageInput.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                errorSpan.textContent = 'Image size must be less than 2MB';
                imageInput.value = '';
                return;
            }

            errorSpan.textContent = '';

            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                imagePlaceholder.style.display = 'none';
                removeImageBtn.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }
    });

    removeImageBtn.addEventListener('click', function () {
        imageInput.value = '';
        imagePreview.src = '';
        imagePreview.style.display = 'none';
        imagePlaceholder.style.display = 'block';
        removeImageBtn.style.display = 'none';
        document.getElementById('error_image').textContent = '';
    });

    // Form submission
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Clear previous errors
        document.querySelectorAll('[id^="error_"]').forEach(el => {
            el.textContent = '';
        });
        
        // Show loading state
        submitText.textContent = 'Saving...';
        spinner.classList.remove('hidden');
        submitBtn.disabled = true;
        
        // Prepare form data
        const formData = new FormData(form);
        
        // Submit via fetch API
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
            
            // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
        })
        .then(response => {
    if (!response.ok) {
        return response.json().then(err => { throw err; });
    }
    return response.json();
})

        .then(data => {
           
            resetForm();
            closeModal();
            alert('Item added successfully!');
            
        })
        .catch(error => {
            if (error.errors) {
                Object.entries(error.errors).forEach(([field, messages]) => {
                    const errorElement = document.getElementById(`error_${field}`);
                    if (errorElement) {
                        errorElement.textContent = messages.join(' ');
                    }
                });
            } else {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        })
        .finally(() => {
            // Reset button state
            submitText.textContent = 'Save Item';
            spinner.classList.add('hidden');
            submitBtn.disabled = false;
        });
    });

   modalOverlay.addEventListener('click', function (e) {
        if (e.target === modalOverlay) {
            closeModal();
        }
    });
});
</script>




<script>
 document.addEventListener('DOMContentLoaded', function() {
    const createModal = document.getElementById("create-category-modal");
    const openCreateModalButton = document.getElementById("open-modal");
    const closeCreateModalButton = document.getElementById("close-modal");

   
    openCreateModalButton.addEventListener("click", function() {

        document.getElementById("edit-category-form").reset();
        document.getElementById("edit-category-form").action = "{{ route('inventory.categories.store') }}";
        document.getElementById("modal-title").textContent = "Create Category";
        createModal.classList.remove("hidden");
    });

 
    closeCreateModalButton.addEventListener("click", function() {
        createModal.classList.add("hidden");
    });
});
</script>








@endsection