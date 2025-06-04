@extends('layouts.app')

@section('content')
@php
    $totalAmount = $movement->items->reduce(function($carry, $detail) {
        return $carry + ($detail->quantity * $detail->item->price);
    }, 0);
@endphp

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="bg-white">

        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 border-b border-blue-700">
            <div class="mb-4 sm:mb-0">
                <div class="flex items-center">
                    <h2 class="text-2xl font-bold text-white">Movement Details</h2>
                    <span class="ml-2 px-2 py-1 text-xs font-semibold bg-white text-blue-800 rounded-full">
                        #{{ $movement->id }}
                    </span>
                </div>
                <p class="text-sm text-blue-100 mt-1">
                    Created on {{ \Carbon\Carbon::parse($movement->created_at)->format('d M, Y h:i A') }}
                </p>
            </div>
            <div class="flex space-x-3">
                <button type="button" 
                        onclick="window.location='{{ route('movements.edit', $movement) }}'"
                        class="flex items-center justify-center space-x-2 bg-white hover:bg-gray-50 text-blue-600 border border-blue-200 px-4 py-2 rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                    </svg>
                    <span>Edit</span>
                </button>
                <button onclick="window.location='{{ route('movements') }}'"
                        class="px-4 py-2 border border-gray-200 rounded-lg text-gray-600 bg-white hover:bg-gray-50 transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                    Back to List
                </button>
            </div>
        </div>

        <!-- Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6 border-b border-gray-200">
            <div class="bg-gray-50 p-4 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">Movement Date</label>
                <div class="text-lg font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($movement->date)->format('d M, Y') }}
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">From Warehouse</label>
                <div class="text-lg font-semibold text-gray-800">
                    {{ $movement->fromWarehouse->name ?? '-' }}
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">To Warehouse</label>
                <div class="text-lg font-semibold text-gray-800">
                    {{ $movement->toWarehouse->name ?? '-' }}
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">Total Items</label>
                <div class="text-lg font-semibold text-gray-800">
                    {{ $movement->items->count() }}
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="px-6 py-5">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Moved Items</h3>
                <div class="text-sm text-gray-500">
                    Showing {{ $movement->items->count() }} items
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barcode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">HSN</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Unit</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rate</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($movement->items as $detail)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm font-mono text-gray-700">
                                    {{ $detail->item->barcode }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="font-semibold text-gray-800">{{ $detail->item->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $detail->item->category->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $detail->item->hsn_code }}</td>
                                <td class="px-6 py-4 text-sm text-right text-gray-700">{{ $detail->quantity }}</td>
                                <td class="px-6 py-4 text-sm text-right text-gray-500">{{ $detail->item->unit->abbreviation }}</td>
                                <td class="px-6 py-4 text-sm text-right text-gray-500">₹{{ number_format($detail->item->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary -->
        <div class="bg-gray-50 px-6 py-5 border-t border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Summary</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl ml-auto">
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <div class="text-sm font-medium text-gray-500 mb-2">Total Quantity</div>
                    <div class="flex items-end">
                        <div class="text-3xl font-bold text-gray-800">{{ $movement->items->sum('quantity') }}</div>
                        <span class="ml-2 text-sm text-gray-500 mb-1">units</span>
                    </div>
                </div>
                <div class="bg-green-50 p-5 rounded-xl border border-green-100 shadow-sm">
                    <div class="text-sm font-medium text-green-600 mb-2">Total Value</div>
                    <div class="text-3xl font-bold text-green-700">₹{{ number_format($totalAmount, 2) }}</div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection









@extends('layouts.app')

@section('content')
@php
   $totalAmount = $movement->items->reduce(function($carry, $detail) {
        return $carry + ($detail->quantity * $detail->item->price);
    }, 0);
@endphp

<div class="w-full max-w-7xl mx-auto bg-white rounded-lg shadow-sm overflow-hidden">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Movement Details</h2>
            <p class="text-sm text-blue-100 mt-1">Movement #{{ $movement->id }}</p>
        </div>
        <div class="flex space-x-3">
            <button type="button" 
                onclick="window.location='{{ route('movements') }}'"
                class="px-4 py-2 bg-white/10 text-white rounded-md hover:bg-white/20 transition backdrop-blur-sm border border-white/20 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </button>
            <button type="button" 
                onclick="window.location='{{ route('movements.edit', $movement) }}'"
                class="px-4 py-2 bg-white text-blue-700 rounded-md hover:bg-blue-50 transition flex items-center font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Edit Movement
            </button>
        </div>
    </div>

    <!-- Basic Information Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6 border-b">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
            <h3 class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">Movement Date</h3>
            <p class="text-lg font-semibold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                {{ \Carbon\Carbon::parse($movement->date)->format('M d, Y') }}
            </p>
        </div>
        
        <div class="bg-orange-50 p-4 rounded-lg border border-orange-100">
            <h3 class="text-xs font-semibold text-orange-600 uppercase tracking-wider mb-1">From Warehouse</h3>
            <p class="text-lg font-semibold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.496 2.132a1 1 0 00-.992 0l-7 4A1 1 0 003 8v7a1 1 0 100 2h14a1 1 0 100-2V8a1 1 0 00.496-1.868l-7-4zM6 9a1 1 0 00-1 1v3a1 1 0 102 0v-3a1 1 0 00-1-1zm3 1a1 1 0 012 0v3a1 1 0 11-2 0v-3zm5-1a1 1 0 00-1 1v3a1 1 0 102 0v-3a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $movement->fromWarehouse->name }}
            </p>
        </div>
        
        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
            <h3 class="text-xs font-semibold text-green-600 uppercase tracking-wider mb-1">To Warehouse</h3>
            <p class="text-lg font-semibold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                </svg>
                {{ $movement->toWarehouse->name }}
            </p>
        </div>
    </div>

    <!-- Items Table Section -->
    <div class="px-6 py-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Movement Items</h3>
            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                {{ count($movement->items) }} items
            </span>
        </div>
        
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barcode</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HSN</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($movement->items as $index => $detail)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-md flex items-center justify-center mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div>
                                    {{ $detail->item->name }}
                                    <div class="text-xs text-gray-500 mt-1">SKU: {{ $detail->item->sku ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ $detail->item->category->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $detail->item->barcode }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail->item->hsn_code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right font-medium">{{ $detail->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ $detail->item->unit->abbreviation }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">₹{{ number_format($detail->item->price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                            ₹{{ number_format($detail->quantity * $detail->item->price, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="px-6 py-4 bg-gray-50 border-t">
        <div class="flex justify-end">
            <div class="w-full md:w-1/3 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Movement Summary</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Items:</span>
                        <span class="font-medium">{{ count($movement->items) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Quantity:</span>
                        <span class="font-medium">{{ $movement->total_quantity }}</span>
                    </div>
                    <div class="pt-2 mt-2 border-t">
                        <div class="flex justify-between text-base">
                            <span class="text-gray-700 font-semibold">Total Amount:</span>
                            <span class="font-bold text-blue-600">₹{{ number_format($totalAmount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Actions -->
    <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
        <div class="text-sm text-gray-500">
            Created on {{ \Carbon\Carbon::parse($movement->created_at)->format('M d, Y \a\t h:i A') }}
            @if($movement->created_at != $movement->updated_at)
                <br>Last updated on {{ \Carbon\Carbon::parse($movement->updated_at)->format('M d, Y \a\t h:i A') }}
            @endif
        </div>
        <div>
            <button type="button" 
                onclick="window.print()"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                Print
            </button>
        </div>
    </div>
</div>
@endsection