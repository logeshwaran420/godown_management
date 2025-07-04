@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">
     <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
        <div class="flex-1 min-w-0"> <!-- Added flex-1 and min-w-0 to prevent overflow -->
            <h1 class="text-2xl font-bold text-gray-800 truncate">Ledgers Transactions</h1>
            <p class="text-sm text-gray-500 truncate">Track all ledgers transaction items</p>
        </div>

        <div class="flex-shrink-0"> <!-- Prevents the button from shrinking -->
            <button type="button" 
                onclick="window.location='{{ route('ledgers.show', $ledger) }}'"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition flex items-center justify-center dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back 
            </button>
        </div>
    </div>
    




    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($transactions as $transaction)
                        @php
                            $route = $ledger->type === 'customer'
                                ? route('outwards.show', $transaction)
                                : route('inwards.show', $transaction);
                        @endphp
                        <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="window.location='{{ $route }}'">
                            <!-- Date -->
                            <td class="px-4 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500 sm:hidden">
                                    {{ \Carbon\Carbon::parse($transaction->date)->format('D') }}
                                </div>
                                <div class="text-xs text-gray-500 hidden sm:block">
                                    {{ \Carbon\Carbon::parse($transaction->date)->diffForHumans() }}
                                </div>
                            </td>

                            <!-- Vendor Name -->
                            <td class="px-4 py-4">
                                <div class="text-sm font-medium text-gray-900 truncate max-w-[150px]">
                                    {{ $transaction->ledger->name }}
                                </div>
                                <div class="text-xs text-gray-500 hidden sm:block">
                                    {{ $transaction->ledger->address ?? 'No address' }}
                                </div>
                            </td>

                            <!-- Quantity -->
                            <td class="px-4 py-4">
                                @php
                                    $unitTotals = [];
                                    foreach ($transaction->details as $detail) {
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

                                <div class="flex flex-wrap gap-1">
                                    @foreach ($unitTotals as $unit)
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                            {{ $unit['qty'] }}{{ $unit['name'] }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>

                            <!-- Amount -->
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ₹{{ number_format($transaction->total_amount, 2) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($transactions->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>

@endsection