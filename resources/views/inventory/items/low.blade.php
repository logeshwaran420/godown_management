@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">Inventory Management</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Track and manage your product inventory</p>
            </div>
            {{-- <div class="flex gap-3">
                <a href="{{ route('inventory.items.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Inward Items
                </a>
                <a href="{{ route('inventory.items.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white">
                    Add New Product
                </a>
            </div> --}}
        </div>
    </div>

    <!-- Low Stock Alert Section -->
    @if($inventories  ->count() > 0)
    <div class="mb-8">
        <div class="bg-red-50 border-l-4 border-red-400 p-4 dark:bg-red-900/20 dark:border-red-500 rounded-md mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Low Stock Alert</h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                        <p>
                            You have {{ $inventories  ->count() }} product(s) below their low stock threshold.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Items Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Low Stock Items</h3>
            </div>
        <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                <th scope="col" class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($inventories as $inventory)
              @php
                $item = $inventory->item;
              @endphp
            <tr>
                <td class="px-4 sm:px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-md overflow-hidden bg-gray-200">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="Product" class="h-full w-full object-cover">
                            @else
                                <svg class="h-full w-full text-gray-400 p-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-[150px]">{{ $item->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $item->category->name ?? 'Uncategorized' }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 sm:px-6 py-4 text-sm font-medium text-red-600 dark:text-red-400">
                    {{ $inventory->current_stock }} {{ $item->unit->name }}
                </td>
                <td class="px-4 sm:px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                    {{ $item->price ? '₹' . number_format($item->price, 2) : 'N/A' }}
                </td>
                <td class="px-4 sm:px-6 py-4 text-center text-sm font-medium">
                    <div class="flex justify-center space-x-1 sm:space-x-2">
                        <!-- Inward Button -->
                        <a href="{{ route('inwards.create', ['item' => $item]) }}" 
                           class="inline-flex items-center px-2 sm:px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-0 sm:mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="hidden sm:inline">Inward</span>
                        </a>
                        
                        <!-- Details Button -->
                        <a href="{{ route('inventory.items.show', $inventory) }}" 
                           class="inline-flex items-center px-2 sm:px-3 py-1 border border-gray-300 dark:border-gray-600 text-xs font-medium rounded shadow-sm bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-0 sm:mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="hidden sm:inline">Details</span>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>



              <!-- Pagination -->
            @if($inventories->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <!-- Items per page selector -->
            <div class="flex items-center mb-4 sm:mb-0">
                <span class="text-sm text-gray-700 dark:text-gray-300 mr-2">Items per page:</span>
                <select onchange="window.location.href = this.value" 
                        class="text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ([5, 10, 25, 50, 100] as $size)
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" 
                                {{ $perPage == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pagination links -->
            <div class="flex items-center space-x-1">
                <a href="{{ $inventories->url(1) }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $inventories->currentPage() == 1 ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &laquo;
                </a>

                <a href="{{ $inventories->previousPageUrl() }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $inventories->onFirstPage() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &lsaquo;
                </a>

                @foreach ($inventories->getUrlRange(max(1, $inventories->currentPage() - 2), min($inventories->lastPage(), $inventories->currentPage() + 2)) as $page => $url)
                    <a href="{{ $url }}" 
                       class="px-3 py-1 rounded-md text-sm font-medium {{ $page == $inventories->currentPage() ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                        {{ $page }}
                    </a>
                @endforeach

                <a href="{{ $inventories->nextPageUrl() }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ !$inventories->hasMorePages() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &rsaquo;
                </a>

                <a href="{{ $inventories->url($inventories->lastPage()) }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $inventories->currentPage() == $inventories->lastPage() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &raquo;
                </a>
            </div>

            <!-- Showing results info -->
            <div class="text-sm text-gray-700 dark:text-gray-300 mt-4 sm:mt-0">
                Showing <span class="font-medium">{{ $inventories->firstItem() }}</span> to 
                <span class="font-medium">{{ $inventories->lastItem() }}</span> of 
                <span class="font-medium">{{ $inventories->total() }}</span> results
            </div>
        </div>
@endif


        </div>
    </div>
    @endif

{{-- <!-- Full Inventory Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">All Inventory Items</h3>
            <div class="relative">
                <input type="text" placeholder="Search inventory..." class="pl-8 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600">
                <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">HSN Code</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Unit</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rate</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Value</th>
                    </tr>
                </thead>
               
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($inventories as $items)
                    @php
                        $inventory = $items->item;
                    @endphp

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer" onclick="window.location='{{ route('inventory.items.show', $inventory) }}'">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-md overflow-hidden bg-gray-200">
                                    @if($inventory->image)
                                        <img src="{{ asset('storage/' . $inventory->image) }}" alt="Product" class="h-full w-full object-cover">
                                    @else
                                        <svg class="h-full w-full text-gray-400 p-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $inventory->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $inventory->category->name ?? 'Uncategorized' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $inventory->hsn_code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex flex-col items-end">
                                <span class="text-sm font-medium {{ $inventory->current_stock <= $inventory->low_stock_threshold ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                                    {{ $inventory->current_stock }}
                                </span>
                                @if($inventory->current_stock <= $inventory->low_stock_threshold)
                                    <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Low stock
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $inventory->unit->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-400">
                            ₹{{ number_format($inventory->price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">
                            ₹{{ number_format($inventory->current_stock * $inventory->price, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <!-- Items per page selector -->
            <div class="flex items-center mb-4 sm:mb-0">
                <span class="text-sm text-gray-700 dark:text-gray-300 mr-2">Items per page:</span>
                <select onchange="window.location.href = this.value" 
                        class="text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ([5, 10, 25, 50, 100] as $size)
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" 
                                {{ $perPage == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pagination links -->
            <div class="flex items-center space-x-1">
                <a href="{{ $inventories->url(1) }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $inventories->currentPage() == 1 ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &laquo;
                </a>

                <a href="{{ $inventories->previousPageUrl() }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $inventories->onFirstPage() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &lsaquo;
                </a>

                @foreach ($inventories->getUrlRange(max(1, $inventories->currentPage() - 2), min($inventories->lastPage(), $inventories->currentPage() + 2)) as $page => $url)
                    <a href="{{ $url }}" 
                       class="px-3 py-1 rounded-md text-sm font-medium {{ $page == $inventories->currentPage() ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                        {{ $page }}
                    </a>
                @endforeach

                <a href="{{ $inventories->nextPageUrl() }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ !$inventories->hasMorePages() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &rsaquo;
                </a>

                <a href="{{ $inventories->url($inventories->lastPage()) }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $inventories->currentPage() == $inventories->lastPage() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &raquo;
                </a>
            </div>

            <!-- Showing results info -->
            <div class="text-sm text-gray-700 dark:text-gray-300 mt-4 sm:mt-0">
                Showing <span class="font-medium">{{ $inventories->firstItem() }}</span> to 
                <span class="font-medium">{{ $inventories->lastItem() }}</span> of 
                <span class="font-medium">{{ $inventories->total() }}</span> results
            </div>
        </div>
    </div> --}}
</div>



  
@endsection



