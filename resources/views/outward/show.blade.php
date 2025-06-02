@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="bg-white ">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gradient-to-r from-blue-50 to-gray-50 px-6 py-5 border-b border-gray-200">
            <div class="mb-4 sm:mb-0">
                <div class="flex items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Outward Details</h2>
                    <span class="ml-2 px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                        #{{ $outward->id }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">Created on {{ \Carbon\Carbon::parse($outward->created_at)->format('d M, Y h:i A') }}</p>
            </div>
            <div class="flex space-x-3">
                <button type="button" 
                        onclick="window.location='{{ route('outwards.edit',$outward) }}'"
                        class="flex items-center justify-center space-x-2 bg-white hover:bg-gray-50 text-blue-600 border border-blue-200 px-4 py-2 rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    <span>Edit</span>
                </button>
                <button onclick="window.location='{{ route('outwards') }}'" 
                        class="px-4 py-2 border border-gray-200 rounded-lg text-gray-600 bg-white hover:bg-gray-50 transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                    Back to List
                </button>
            </div>
        </div>

        <!-- Basic Information Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6 border-b border-gray-200">
            <div class="bg-gray-50 p-4 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">Date</label>
                <div class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    {{ \Carbon\Carbon::parse($outward->date)->format('d M, Y') }}
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">Customer</label>
                <div class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                    </svg>
                    {{ $outward->ledger->name }}
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">Total Items</label>
                <div class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                    </svg>
                    {{ count($outward->details) }}
                </div>
            </div>

           
            </div>
        </div>

        <!-- Items Table Section -->
        <div class="px-6 py-5">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                    </svg>
                    Outward Items
                </h3>
                <div class="text-sm text-gray-500">
                    Showing {{ count($outward->details) }} items
                </div>
            </div>
            
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barcode</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Details</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HSN</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($outward->details as $detail)
                        <tr class="hover:bg-blue-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-gray-100 text-gray-800">
                                    {{ $detail->item->barcode }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $detail->item->name }}</div>
                                <div class="text-xs text-gray-500">{{ $detail->item->category->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail->item->hsn_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                {{ $detail->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                {{ $detail->item->unit->abbreviation }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                ₹{{ number_format($detail->item->price, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="bg-gray-50 px-6 py-5 border-t border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Summary
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl ml-auto">
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <div class="text-sm font-medium text-gray-500 mb-2">Total Quantity</div>
                    <div class="flex items-end">
                        <div class="text-3xl font-bold text-gray-800">{{ $outward->total_quantity }}</div>
                        <span class="ml-2 text-sm text-gray-500 mb-1">items</span>
                    </div>
                </div>
                
             
                
                <div class="bg-green-50 p-5 rounded-xl border border-green-100 shadow-sm">
                    <div class="text-sm font-medium text-green-600 mb-2">Total Amount</div>
                    <div class="text-3xl font-bold text-green-700">₹{{ number_format($outward->total_amount, 2) }}</div>
                </div>
            </div>
        </div>

    
    </div>
</div>
@endsection