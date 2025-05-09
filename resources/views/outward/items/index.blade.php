@extends('layouts.app')

@section('content')



<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center py-3 px-3">
        <h1 class="text-xl font-semibold">Purchase Receive</h1> 
   
        <button id="open-modal" class="bg-blue-600 text-white px-3 py-1 rounded">+ New</button>
    </div>


    <div class="relative overflow-x-auto">    
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="sticky top-0 bg-gray-50 dark:bg-gray-700 z-10">
                    <th scope="col" class="px-6 py-3">
                       Purchase Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        item
                    </th>
                    <th scope="col" class="px-6 py-3">
                        hsn code
                    </th>
                    <th scope="col" class="px-6 py-3">
                        vendor Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        quantity
                    </th>
                </tr>
            </thead>

            <tbody>
                
                @foreach ($outwards as $outward)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                     {{   $outward->date }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $outward->item->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $outward->item->hsn_code }}
                    </td>
                     <td class="px-6 py-4">
                        {{ $outward->ledger->name }}
                    </td>
                     <td class="px-6 py-4">
                        {{ $outward->quantity }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $outwards->links() }}
        </div>
    </div>















</div>





@endsection