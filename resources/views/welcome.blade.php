@extends('layouts.app')

@section('content')
<x-layout.topbar />

<div class="p-6 min-h-screen bg-gray-50">
    <!-- Header Section with Address and Actions -->
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
                    <p class="text-sm font-medium text-gray-500">Inventory Value</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">
                        {{-- ${{ number_format($inventories->sum(fn($inv) => $inv->current_stock * $inv->item->unit_price), 2 }} --}}
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

        {{-- <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-purple-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Recent Activity</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">
               
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Last 7 days</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
        </div> --}}

{{--    
        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Warehouse Capacity</p>
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                        @php
    $capacity = $warehouse->capacity ?: 1; 
    $percentage = min(100, ($items->sum(fn($item) => $item->current_stock) / $capacity) * 100);
@endphp

<div class="bg-yellow-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>

                        </div>
                       <p class="text-xs text-gray-500 mt-1">
    {{ $warehouse->capacity > 0 
        ? number_format(($items->sum(fn($item) => $item->current_stock) / $warehouse->capacity) * 100, 1) . '% used'
        : 'Capacity not set' }}
</p>

                    </div>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div> --}}



        
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Activity Section -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Today's Activities -->
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th> --}}
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                         @forelse ($recentActivities->take(5) as $activity)
                            <tr>
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
                              {{ $activity->details->first()?->item->name ?? 'Unknown Item' }}

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $activity->total_quantity }}
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















        <!-- Right Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 gap-3">
        <!-- Item -->
        <a href="{{ route('inventory.items.create') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition">
            <div class="bg-blue-100 p-3 rounded-full mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Item</span>
        </a>

     
        <!-- Ledger -->
        <a href="{{ route('ledgers.create') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 transition">
            <div class="bg-purple-100 p-3 rounded-full mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Ledger</span>
        </a>

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
                            <div class="bg-red-100 p-2 rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $inventory->item->name }}</p>
                                <p class="text-xs text-gray-500">Below safety stock</p>
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
               
            </div>
        </div>
    </div>
</div>


















{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart data
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

    // Initialize chart
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



@endsection