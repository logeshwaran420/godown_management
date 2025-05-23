@extends('layouts.app')

@section('content')




<div class="container mx-auto px-4 py-6">


    <div class="flex justify-between items-center py-3 px-3">
      <h1 class="text-xl font-semibold">All Items</h1>

      <div class="flex items-center gap-2">
   <button type="button" 
        onclick="window.location='{{ route('inventory.items.create') }}'"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    +New
</button>
  
  
      </div>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr class="sticky top-0 bg-gray-50 dark:bg-gray-700 z-10">
          
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">HSN Code</th>
            <th class="px-6 py-3">Current Stock</th>
            <th class="px-6 py-3">Units</th>
            <th class="px-6 py-3">Rate</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($inventories as $inventory)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer"
                    onclick="window.location='{{ route('inventory.items.show', $inventory->item) }}'">
             
              <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $inventory->item->name }}</td>
              
              <td class="px-6 py-4">{{ $inventory->item->hsn_code }}</td>
              <td class="px-6 py-4">{{ $inventory->current_stock }}</td>
              <td class="px-6 py-4">{{ $inventory->item->unit->abbreviation }}</td>
              <td class="px-6 py-4">{{ $inventory->item->price }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $inventories->links() }}
    </div>
  
</div>


@endsection
