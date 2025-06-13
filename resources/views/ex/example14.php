<button class="md:hidden fixed top-4 left-4 z-30 bg-gray-800 p-2 rounded-md text-white shadow-lg" id="mobileToggle">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<aside class="w-64 min-h-screen bg-gray-900 text-white flex flex-col border-r border-[#1e2a3a] shadow-md fixed md:relative md:translate-x-0 transition-all duration-300 transform -translate-x-full md:transform-none z-40" id="sidebar">
    <button class="md:hidden absolute right-0 top-0 m-4 text-gray-400 hover:text-white focus:outline-none" id="sidebarClose">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <div class="p-4 text-lg font-bold border-b border-[#0a1a2f] tracking-wide text-center">
        INVENTORY
    </div>

    <div class="flex-1 overflow-y-auto overflow-x-hidden">
        <nav class="w-full mx-4 bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl"
             x-data="{ inventory: {{ request()->routeIs('inventory.*') ? 'true' : 'false' }} }">

            <x-layout.nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" class="group nav-item mt-3">
                <div class="flex items-center space-x-2 p-2 rounded-lg transition-all duration-200">
                    <div class="icon-container bg-blue-500/10 p-1.5 rounded-md">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span class="text-gray-200">Home</span>
                </div>
            </x-layout.nav-link>
            
            <div>
                <button
                    @click="inventory = !inventory"
                    class="w-full flex justify-between items-center p-2 rounded-lg hover:bg-white/5 transition-all duration-200 nav-item 
                    {{ request()->routeIs('inventory.*') ? 'bg-white/5' : '' }}">
                    <div class="flex items-center space-x-2">
                        <div class="icon-container bg-purple-500/10 p-1.5 rounded-md">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <span class="text-gray-200">Inventory</span>
                    </div>
                    <svg :class="{ 'rotate-180': inventory }"
                         class="w-3.5 h-3.5 text-gray-400 transition-transform"
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="inventory" x-collapse x-cloak class="ml-5 mt-1 space-y-1 border-l border-gray-700 pl-2">
                    <x-layout.nav-link href="{{ route('inventory.items') }}" :active="request()->routeIs('inventory.items*')" class="nav-subitem">
                        <div class="flex items-center space-x-2 p-1.5 rounded-md transition-all duration-200">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                            <span class="text-gray-300">Items</span>
                        </div>
                    </x-layout.nav-link>
                    <x-layout.nav-link href="{{ route('inventory.categories') }}" :active="request()->routeIs('inventory.categories*')" class="nav-subitem">
                        <div class="flex items-center space-x-2 p-1.5 rounded-md transition-all duration-200">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                            <span class="text-gray-300">Categories</span>
                        </div>
                    </x-layout.nav-link>
                </div>
            </div>

            @php
                $navItems = [
                    ['route' => 'inwards', 'label' => 'Inward', 'icon' => 'M19 13l-7 7-7-7m14-8l-7 7-7-7', 'color' => 'green'],
                    ['route' => 'outwards', 'label' => 'Outward', 'icon' => 'M5 11l7-7 7 7M5 19l7-7 7 7', 'color' => 'red'],
                    ['route' => 'ledgers', 'label' => 'Ledgers', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color' => 'yellow'],
                    ['route' => 'movements', 'label' => 'Movement', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4', 'color' => 'cyan'],
                ];
            @endphp

            @foreach ($navItems as $item)
                <x-layout.nav-link href="{{ route($item['route']) }}" :active="request()->routeIs($item['route'] . '*')" class="nav-item">
                    <div class="flex items-center space-x-2 p-2 rounded-lg transition-all duration-200">
                        <div class="icon-container bg-{{ $item['color'] }}-500/10 p-1.5 rounded-md">
                            <svg class="w-4 h-4 text-{{ $item['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                            </svg>
                        </div>
                        <span class="text-gray-200">{{ $item['label'] }}</span>
                    </div>
                </x-layout.nav-link>
            @endforeach
        </nav>
    </div>

    <div class="md:hidden fixed inset-0 bg-black bg-opacity-50 z-30 hidden" id="sidebarOverlay"></div>

    <style>
        .nav-item.active {
            background-color: rgba(255, 255, 255, 0.05);
            box-shadow: inset 3px 0 0 0 #3b82f6;
        }
        .nav-item.active .icon-container {
            background-color: rgba(59, 130, 246, 0.2);
        }
        .nav-subitem.active {
            background-color: rgba(255, 255, 255, 0.03);
        }
        .nav-subitem.active span {
            color: #fff;
            font-weight: 500;
        }
        
        /* Smooth transitions for mobile */
        @media (max-width: 767px) {
            #sidebar {
                transition: transform 0.3s ease-in-out;
            }
            #sidebarOverlay {
                transition: opacity 0.3s ease-in-out;
            }
        }
    </style>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
        });
        
        sidebarClose.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
        
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
    });
</script>











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
                <span class="hidden sm:inline">New Inward</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                Date
                            </div>
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                Ledger
                            </div>
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                            Quantity
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                Amount
                            </div>
                        </th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($inwards as $inward)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Date -->
                            <td class="px-4 py-4 whitespace-nowrap cursor-pointer" onclick="window.location='{{ route('inwards.show', $inward) }}'">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($inward->date)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500 sm:hidden">
                                    {{ $inward->ledger->name }}
                                </div>
                            </td>

                            <!-- Vendor Name -->
                            <td class="px-4 py-4 whitespace-nowrap cursor-pointer hidden sm:table-cell" onclick="window.location='{{ route('inwards.show', $inward) }}'">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $inward->ledger->name }}
                                </div>
                                <div class="text-xs text-gray-500 truncate" style="max-width: 150px;">
                                    {{ $inward->ledger->address ?? 'No address' }}
                                </div>
                            </td>

                            <!-- Quantity -->
                            <td class="px-4 py-4 whitespace-nowrap cursor-pointer hidden sm:table-cell" onclick="window.location='{{ route('inwards.show', $inward) }}'">
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
                            <td class="px-4 py-4 whitespace-nowrap cursor-pointer" onclick="window.location='{{ route('inwards.show', $inward) }}'">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ₹{{ number_format($inward->total_amount, 2) }}
                                </span>
                            </td>
                            
                            <!-- Actions (hidden on mobile) -->
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium hidden md:table-cell">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('inwards.show', $inward) }}" class="text-blue-600 hover:text-blue-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('inwards.edit', $inward) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($inwards->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between px-4 py-3 border-t border-gray-200 bg-white">
            <!-- Mobile: Simple pagination -->
            <div class="flex-1 flex justify-between sm:hidden">
                @if ($inwards->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <a href="{{ $inwards->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                @endif

                @if ($inwards->hasMorePages())
                    <a href="{{ $inwards->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </a>
                @else
                    <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white cursor-not-allowed">
                        Next
                    </span>
                @endif
            </div>

            <!-- Desktop: Full pagination -->
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-700">Show</span>
                    <select onchange="window.location.href = this.value" 
                            class="text-sm border border-gray-300 rounded-md bg-white text-gray-700 px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ([5, 10, 25, 50, 100] as $size)
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" 
                                    {{ $perPage == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-sm text-gray-700">per page</span>
                </div>
                
                <div>
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $inwards->firstItem() }}</span> to 
                        <span class="font-medium">{{ $inwards->lastItem() }}</span> of 
                        <span class="font-medium">{{ $inwards->total() }}</span> results
                    </p>
                </div>
                
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <!-- First Page Link -->
                        <a href="{{ $inwards->url(1) }}" 
                           class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 {{ $inwards->currentPage() == 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <span class="sr-only">First</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M8.707 5.293a1 1 0 010 1.414L5.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        
                        <!-- Previous Page Link -->
                        <a href="{{ $inwards->previousPageUrl() }}" 
                           class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 {{ $inwards->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>

                        <!-- Page Numbers -->
                        @foreach ($inwards->getUrlRange(max(1, $inwards->currentPage() - 2), min($inwards->lastPage(), $inwards->currentPage() + 2)) as $page => $url)
                            <a href="{{ $url }}" 
                               class="{{ $page == $inwards->currentPage() ? 'z-10 bg-blue-50 border-blue-500 text-blue-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' }} relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                {{ $page }}
                            </a>
                        @endforeach

                        <!-- Next Page Link -->
                        <a href="{{ $inwards->nextPageUrl() }}" 
                           class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 {{ !$inwards->hasMorePages() ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        
                        <!-- Last Page Link -->
                        <a href="{{ $inwards->url($inwards->lastPage()) }}" 
                           class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 {{ $inwards->currentPage() == $inwards->lastPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <span class="sr-only">Last</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M11.293 14.707a1 1 0 010-1.414L14.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
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

    // Responsive table actions
    function toggleRowActions(row) {
        const actions = row.querySelector('.row-actions');
        if (actions) {
            actions.classList.toggle('hidden');
        }
    }
</script>

<style>
    @media (max-width: 640px) {
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table-responsive table {
            min-width: 600px;
        }
    }
    
    /* Better hover effects */
    tr:hover {
        background-color: #f9fafb;
    }
    
    /* Improved focus states for accessibility */
    a:focus, button:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }
</style>
@endsection