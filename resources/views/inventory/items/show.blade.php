@extends('layouts.app')

@section('content')

<div class="px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white">
        {{-- Header with Title and Actions --}}
        <div class="bg-gradient-to-r from-blue-50 to-gray-50 px-6 py-5 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    {{ $item->name }}
                </h1>
                <div class="flex flex-wrap items-center gap-2 mt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $item->category->name }}
                    </span>
                    @if($item->barcode)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Barcode: {{ $item->barcode }}
                    </span>
                    @endif
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <button 
                    onclick="window.location='{{ route('inventory.items.edit', $item) }}'"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit 
                </button>

                <form action="{{ route('inventory.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="divide-y divide-gray-200">
            {{-- Basic Info Section --}}
            <div class="px-6 py-5">
                <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Basic Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Item Name</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $item->name }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Category</p>
                        <p class="mt-1 text-lg text-gray-900">{{ $item->category->name }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Unit</p>
                        <p class="mt-1 text-lg text-gray-900">{{ $item->unit->name }} ({{ $item->unit->abbreviation }})</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Barcode</p>
                        <p class="mt-1 text-lg font-mono text-gray-900">{{ $item->barcode ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">HSN Code</p>
                        <p class="mt-1 text-lg text-gray-900">{{ $item->hsn_code ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Price</p>
                        <p class="mt-1 text-lg text-gray-900">₹{{ number_format($item->price, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- Stock Summary Section --}}
            <div class="px-6 py-5">
                <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Stock Summary
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <p class="text-sm font-medium text-blue-800">Total Quantity</p>
                        <div class="mt-2 flex items-baseline">
                            <p class="text-3xl font-bold text-blue-900">{{ $item->current_stock }}</p>
                            <p class="ml-2 text-sm font-medium text-blue-700">{{ $item->unit->abbreviation }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                        <p class="text-sm font-medium text-green-800">Unit Price</p>
                        <div class="mt-2 flex items-baseline">
                            <p class="text-3xl font-bold text-green-900">₹{{ number_format($item->price, 2) }}</p>
                        </div>
                    </div>
                    
                    {{-- <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                        <p class="text-sm font-medium text-purple-800">Total Inventory Value</p>
                        <div class="mt-2 flex items-baseline">
                            <p class="text-3xl font-bold text-purple-900">₹{{ number_format($item->current_stock * $item->price, 2) }}</p>
                        </div>
                    </div> --}}
                </div>
            </div>

            {{-- Warehouse Inventory Section --}}
            <div class="px-6 py-5">
                <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                    Warehouse Inventory
                </h2>
                
                @if($item->inventories->isEmpty())
                    <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No inventory data</h3>
                        <p class="mt-1 text-sm text-gray-500">This item hasn't been added to any warehouses yet.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($item->inventories as $inventory)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                                <div class="px-4 py-3 bg-gray-50 border-b flex justify-between items-center">
                                    <h4 class="font-medium text-gray-800 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        {{ $inventory->warehouse->name }}
                                    </h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $inventory->warehouse->code }}
                                    </span>
                                </div>
                                <div class="p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center">
                                            <p class="text-sm font-medium text-gray-500">Current Stock</p>
                                            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $inventory->current_stock }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->unit->abbreviation }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-sm font-medium text-gray-500">Inventory Value</p>
                                            <p class="mt-1 text-2xl font-bold text-green-600">₹{{ number_format($inventory->current_stock * $item->price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection