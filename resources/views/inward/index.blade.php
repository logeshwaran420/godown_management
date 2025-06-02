@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Inward Transactions</h1>
            <p class="text-sm text-gray-500">Track all incoming inventory items</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('inwards.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition duration-200 flex items-center justify-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>New Inward</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
            <div class="text-gray-500 text-sm font-medium">Total Transactions</div>
            <div class="text-2xl font-bold text-gray-800">{{ $inwards->total() }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
            <div class="text-gray-500 text-sm font-medium">This Month</div>
            <div class="text-2xl font-bold text-gray-800">{{ $monthCount ?? '0' }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-purple-500">
            <div class="text-gray-500 text-sm font-medium">Total Amount</div>
            <div class="text-2xl font-bold text-gray-800">₹{{ number_format($totalAmount ?? 0, 2) }}</div>
        </div>
    </div>

    <!-- Table Section -->
    

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable('date')">
                            <div class="flex items-center">
                                Date
                             
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable('vendor')">
                            <div class="flex items-center">
                                Vendor Name
                             
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable('amount')">
                            <div class="flex items-center">
                                Amount
                              
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($inwards as $inward)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Date -->
                            <td class="px-6 py-4 whitespace-nowrap cursor-pointer" onclick="window.location='{{ route('inwards.show', $inward) }}'">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($inward->date)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($inward->date)->diffForHumans() }}
                                </div>
                            </td>

                            <!-- Vendor Name -->
                            <td class="px-6 py-4 whitespace-nowrap cursor-pointer" onclick="window.location='{{ route('inwards.show', $inward) }}'">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $inward->ledger->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $inward->ledger->address ?? 'No address' }}
                                </div>
                            </td>

                            <!-- Quantity -->
                            <td class="px-6 py-4 whitespace-nowrap cursor-pointer" onclick="window.location='{{ route('inwards.show', $inward) }}'">
                                @php
                                    $unitTotals = [];
                                    foreach ($inward->details as $detail) {
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
                            <td class="px-6 py-4 whitespace-nowrap cursor-pointer" onclick="window.location='{{ route('inwards.show', $inward) }}'">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ₹{{ number_format($inward->total_amount, 2) }}
                                </span>
                            </td>
                            
                          
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $inwards->links() }}
        </div>
    </div>
</div>

<style>
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }
    
    .pagination li {
        margin: 0 4px;
    }
    
    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .pagination li a:hover {
        background-color: #f3f4f6;
        color: #1f2937;
    }
    
    .pagination li.active span {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    
    .pagination li.disabled span {
        color: #9ca3af;
        cursor: not-allowed;
    }
</style>

<script>
    // Toggle filter dropdown
    document.getElementById('filter-btn').addEventListener('click', function() {
        document.getElementById('filter-dropdown').classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const filterBtn = document.getElementById('filter-btn');
        const filterDropdown = document.getElementById('filter-dropdown');
        if (!filterBtn.contains(event.target) {
            filterDropdown.classList.add('hidden');
        }
    });

    // Print functionality
    document.getElementById('print-btn').addEventListener('click', function() {
        window.print();
    });

    // Simple client-side search
    document.getElementById('search-input').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const vendorName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (vendorName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Simple client-side date filter
    document.getElementById('apply-filter').addEventListener('click', function() {
        const startDate = new Date(document.getElementById('start-date').value);
        const endDate = new Date(document.getElementById('end-date').value);
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const dateText = row.querySelector('td:first-child').textContent.trim();
            const rowDate = new Date(dateText);
            
            if ((!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        document.getElementById('filter-dropdown').classList.add('hidden');
    });

    // Simple client-side sorting
    function sortTable(column) {
        // This is a basic implementation - for real apps, consider server-side sorting
        alert('Sorting by ' + column + ' would be implemented here');
    }
</script>
@endsection