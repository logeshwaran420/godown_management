@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6">
  <form id="bulk-form" action="{{ route('inventory.items.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete selected items?')">
    @csrf
    @method('DELETE')

    <div class="flex justify-between items-center py-3 px-3">
      <h1 class="text-xl font-semibold">All Items</h1>

      <div class="flex items-center gap-2">

        <!-- Bulk Delete Button -->
        <button id="bulk-delete-btn" type="submit" class="text-red-600 hover:text-red-800 hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7
                    m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14" />
          </svg>
        </button>
        
      <!-- ✅ Click Button Here -->
        
        <!-- Optional Livewire component -->
     <livewire:create-item />
      </div>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr class="sticky top-0 bg-gray-50 dark:bg-gray-700 z-10">
            <th class="p-4">
              <input id="select-all" type="checkbox" class="w-4 h-4 text-blue-600 rounded" />
            </th>
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
              <td class="p-4">
                <input
                  type="checkbox"
                  class="checkbox-row w-4 h-4 text-blue-600 rounded"
                  name="ids[]"
                  value="{{ $inventory->id }}"
                />
              </td>
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
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const selectAll = document.getElementById('select-all');
    const rowCbs   = document.querySelectorAll('.checkbox-row');
    const deleteBtn = document.getElementById('bulk-delete-btn');

    function updateUi() {
      const anyChecked = Array.from(rowCbs).some(cb => cb.checked);
      const allChecked = Array.from(rowCbs).every(cb => cb.checked);

      if (anyChecked) deleteBtn.classList.remove('hidden');
      else deleteBtn.classList.add('hidden');

      selectAll.checked = allChecked;
    }

    selectAll.addEventListener('change', () => {
      rowCbs.forEach(cb => cb.checked = selectAll.checked);
      updateUi();
    });

    rowCbs.forEach(cb => cb.addEventListener('change', updateUi));
  });
</script>
@endsection
