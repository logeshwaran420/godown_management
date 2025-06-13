@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex flex-row justify-between items-center mb-6 gap-2 sm:gap-4">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Items Movements</h1>
             <p class="text-xs sm:text-sm text-gray-500">Track all inventory transfers between warehouses</p>
        </div>
        <a href="{{ route('movements.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            <span>Movement</span>
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell">
                            From Warehouse
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell">
                            To Warehouse
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Items
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($movements as $movement)
                    <tr 
                        class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 cursor-pointer"
                        onclick="window.location='{{ route('movements.show', $movement->id) }}'"
                    >
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($movement->date)->format('M d, Y') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 sm:hidden">
                                From: {{ $movement->fromWarehouse->short_name ?? $movement->fromWarehouse->name }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 sm:hidden">
                                To: {{ $movement->toWarehouse->short_name ?? $movement->toWarehouse->name }}
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap hidden sm:table-cell">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-5 w-5 text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-2">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $movement->fromWarehouse->name }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap hidden sm:table-cell">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-2">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $movement->toWarehouse->name }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            @php
                                $unitTotals = [];
                            @endphp
                            @foreach($movement->items as $detail)
                                @php
                                    $unit = $detail->item->unit;
                                    $unitId = $unit->id;
                                    $unitName = $unit->abbreviation;
                                    $quantity = $detail->quantity;

                                    if (!isset($unitTotals[$unitId])) {
                                        $unitTotals[$unitId] = [
                                            'name' => $unitName,
                                            'qty' => 0
                                        ];
                                    }

                                    $unitTotals[$unitId]['qty'] += $quantity;
                                @endphp
                            @endforeach

                            <div class="flex flex-wrap gap-1">
                                @foreach($unitTotals as $unit)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $unit['qty'] }} {{ $unit['name'] }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

         @if($movements->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between px-4 sm:px-6 py-4 border-t border-gray-200 bg-white">
        <div class="flex items-center mb-4 sm:mb-0">
            <span class="text-sm text-gray-700 mr-2">Items per page:</span>
            <select onchange="window.location.href = this.value" 
                    class="text-sm border border-gray-300 rounded-md bg-white text-gray-700 px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach ([5, 10, 25, 50, 100] as $size)
                    <option value="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" 
                            {{ $perPage == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center space-x-1">
            <a href="{{ $movements->url(1) }}" 
               class="px-3 py-1 rounded-md text-sm font-medium {{ $movements->currentPage() == 1 ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                &laquo;
            </a>

            <a href="{{ $movements->previousPageUrl() }}" 
               class="px-3 py-1 rounded-md text-sm font-medium {{ $movements->onFirstPage() ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                &lsaquo;
            </a>

            @foreach ($movements->getUrlRange(max(1, $movements->currentPage() - 2), min($movements->lastPage(), $movements->currentPage() + 2)) as $page => $url)
                <a href="{{ $url }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $page == $movements->currentPage() ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    {{ $page }}
                </a>
            @endforeach

            <a href="{{ $movements->nextPageUrl() }}" 
               class="px-3 py-1 rounded-md text-sm font-medium {{ !$movements->hasMorePages() ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                &rsaquo;
            </a>

            <a href="{{ $movements->url($movements->lastPage()) }}" 
               class="px-3 py-1 rounded-md text-sm font-medium {{ $movements->currentPage() == $movements->lastPage() ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                &raquo;
            </a>
        </div>

        <div class="text-sm text-gray-700 mt-4 sm:mt-0">
            Showing <span class="font-medium">{{ $movements->firstItem() }}</span> to 
            <span class="font-medium">{{ $movements->lastItem() }}</span> of 
            <span class="font-medium">{{ $movements->total() }}</span> results
        </div>
    </div>
    @endif
    </div>
</div>
@endsection