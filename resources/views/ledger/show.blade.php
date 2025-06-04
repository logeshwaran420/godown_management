@extends('layouts.app')

@section('content')
<div class="w-full container max-w-7xl mx-auto bg-white dark:bg-gray-800 ">

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 flex flex-col sm:flex-row justify-between items-start sm:items-center">
        <div class="mb-4 sm:mb-0">
            <div class="flex items-center flex-wrap gap-2">
                <h2 class="text-2xl font-bold text-black-600">Ledger Details</h2>
               
            </div>
            <div class="flex flex-wrap items-center mt-2 gap-2">
                <span class="ml-2 px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full"">
                    {{ ucfirst($ledger->type) }}
                </span>
               
            </div>
        </div>
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
         
            <button type="button" 
                onclick="window.location='{{ route('ledgers')}}'"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition flex items-center justify-center dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to List
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="p-6">
        <!-- Account Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Account Type -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-900/50 p-4 rounded-lg border border-blue-100 dark:border-blue-900 shadow-sm">
                <h3 class="text-xs font-semibold text-blue-600 dark:text-blue-300 uppercase tracking-wider mb-1">Account Type</h3>
                <p class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                    @if($ledger->type === 'customer')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                    </svg>
                    Customer
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    Supplier
                    @endif
                </p>
            </div>
              <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 p-4 rounded-lg border border-gray-100 dark:border-gray-600 shadow-sm">
                <h3 class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-1">Ledger Name</h3>
                <div class="space-y-1">
                

 <p class="text-lg text-gray-800 dark:text-gray-200 flex items-center mt-2 font-semibold">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                    </svg>
                              <span>   {{ $ledger->name }}</span>
                    </p>
                
                </div>
            </div>
          
            
            <!-- Contact Info -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 p-4 rounded-lg border border-gray-100 dark:border-gray-600 shadow-sm">
                <h3 class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-1">Primary Contact</h3>
                <div class="space-y-1">
                    <p class="text-sm text-gray-800 dark:text-gray-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        {{ $ledger->email ?? 'No email' }}
                    </p>
                    <p class="text-sm text-gray-800 dark:text-gray-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                        {{ $ledger->phone ?? 'No phone' }}
                    </p>
                </div>
            </div>
            
            <!-- Address -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 p-4 rounded-lg border border-gray-100 dark:border-gray-600 shadow-sm">
                <h3 class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-1">Address</h3>
                <p class="text-sm text-gray-800 dark:text-gray-200">
                    @if($ledger->address)
                        {{ $ledger->address }}
                    @else
                        <span class="text-gray-500 italic">No address provided</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
      
        </div>

        <!-- Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Recent Transactions -->

             @php
                    $transactions = null;
                    if ($ledger->inwards->count() > 0) {
                        $transactions = $ledger->inwards->sortByDesc('created_at')->take(5);
                    } elseif ($ledger->outwards->count() > 0) {
                        $transactions = $ledger->outwards->sortByDesc('created_at')->take(5);
                    }
                @endphp
                
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-5 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Transactions</h3>
                     @if($transactions && $transactions->count() > 0)
        <a href="{{ route('ledgers.transaction', $ledger) }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            View all
        </a>
    @endif
                </div>

               

                @if($transactions && $transactions->count() > 0)
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($transactions as $transaction)
                            <div class="py-3 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/30 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800 dark:text-white">
                                            Transaction #{{ $transaction->id }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $transaction->created_at->format('M d, Y • h:i A') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium {{ $transaction->total_amount >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $transaction->total_amount >= 0 ? '+' : '' }}₹{{ number_format($transaction->total_amount, 2) }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $transaction->total_quantity ?? 'N/A' }} items
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No transactions found</p>
                        {{-- <button type="button" class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create New Transaction
                        </button> --}}
                    </div>
                @endif
            </div>

           
        </div>

       
    </div>
</div>
@endsection