@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
   <div class="flex flex-row justify-between items-center mb-6 gap-2 sm:gap-4">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Outward Transactions</h1>
        <p class="text-xs sm:text-sm text-gray-500">Track all outgoing inventory items</p>
    </div>
    <div>
        <a href="{{ route('outwards.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2 rounded-lg shadow-md transition duration-200 flex items-center justify-center space-x-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            <span >New Outward</span>
        </a>
    </div>
</div>
    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4">
        @foreach ($outwards as $outward)
        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100" onclick="window.location='{{ route('outwards.show', $outward) }}'">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <h3 class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($outward->date)->format('d M Y') }}</h3>
                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($outward->date)->diffForHumans() }}</p>
                </div>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    ₹{{ number_format($outward->total_amount, 2) }}
                </span>
            </div>
            
            <div class="mb-2">
                <p class="text-sm font-medium">{{ $outward->ledger->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ $outward->ledger->address ?? 'No address' }}</p>
            </div>
            
            <div class="flex flex-wrap gap-1">
                @php
                    $unitTotals = [];
                    foreach ($outward->details as $detail) {
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
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                        {{ $unit['qty'] }}{{ $unit['name'] }}
                    </span>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ledger Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($outwards as $outward)
                        <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="window.location='{{ route('outwards.show', $outward) }}'">
                            <!-- Date -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($outward->date)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($outward->date)->diffForHumans() }}
                                </div>
                            </td>

                            <!-- Ledger Name -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $outward->ledger->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $outward->ledger->address ?? 'No address' }}
                                </div>
                            </td>

                            <!-- Quantity -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $unitTotals = [];
                                    foreach ($outward->details as $detail) {
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
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1">
                                        {{ $unit['qty'] }}{{ $unit['name'] }}
                                    </span>
                                @endforeach
                            </td>

                            <!-- Amount -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ₹{{ number_format($outward->total_amount, 2) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($outwards->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between px-4 sm:px-6 py-4 border-t border-gray-200 bg-white">
            <!-- Items per page selector -->
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

            <!-- Pagination links -->
            <div class="flex items-center space-x-1">
                <a href="{{ $outwards->url(1) }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $outwards->currentPage() == 1 ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    &laquo;
                </a>

                <a href="{{ $outwards->previousPageUrl() }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $outwards->onFirstPage() ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    &lsaquo;
                </a>

                @foreach ($outwards->getUrlRange(max(1, $outwards->currentPage() - 2), min($outwards->lastPage(), $outwards->currentPage() + 2)) as $page => $url)
                    <a href="{{ $url }}" 
                       class="px-3 py-1 rounded-md text-sm font-medium {{ $page == $outwards->currentPage() ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                        {{ $page }}
                    </a>
                @endforeach

                <!-- Next Page Link -->
                <a href="{{ $outwards->nextPageUrl() }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ !$outwards->hasMorePages() ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    &rsaquo;
                </a>

                <!-- Last Page Link -->
                <a href="{{ $outwards->url($outwards->lastPage()) }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $outwards->currentPage() == $outwards->lastPage() ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    &raquo;
                </a>
            </div>

            <!-- Showing results info -->
            <div class="text-sm text-gray-700 mt-4 sm:mt-0">
                Showing <span class="font-medium">{{ $outwards->firstItem() }}</span> to 
                <span class="font-medium">{{ $outwards->lastItem() }}</span> of 
                <span class="font-medium">{{ $outwards->total() }}</span> results
            </div>
        </div>
        @endif
    </div>
</div>
@endsection