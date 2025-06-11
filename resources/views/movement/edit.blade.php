@extends('layouts.app')

@section('content')
<div class="w-full mx-auto bg-white">
    <form id="movementForm" method="POST" action="{{ route('movements.update', $movement->id) }}">
        @csrf
        @method('PUT')

        <!-- Header -->
        <div class="flex justify-between items-center border-b px-6 py-4 bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
                Edit Item Movement
            </h2>
             <div class="flex space-x-2">
             <a href="{{ route('movements') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Save
            </button>
        </div>
        </div>

        <!-- Movement Info -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-6 border-b">
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">From Warehouse</label>
                <input type="text" value="{{ $from_warehouse->name }}" readonly 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border bg-gray-100 cursor-not-allowed">
                <input type="hidden" name="from_warehouse_id" value="{{ $from_warehouse->id }}">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <div class="relative">
                    <input type="date" name="date" max="{{ now()->format('Y-m-d') }}" 
                           value="{{ \Carbon\Carbon::parse($movement->date)->format('Y-m-d') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border" required>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Barcode</label>
                <div class="relative">
                    <input type="text" id="barcodeInput" placeholder="Scan barcode..." 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border" autofocus>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">To Warehouse</label>
                <select name="to_warehouse_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border bg-white" required>
                    <option value="">Select Warehouse</option>
                    @foreach($warehouses as $warehouse)
                        @if($warehouse->id != $from_warehouse->id)
                            <option value="{{ $warehouse->id }}" @selected($warehouse->id == $movement->to_warehouse_id)>
                                {{ $warehouse->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Items Table -->
        <div class="px-6 py-4">
            <h3 class="font-semibold text-lg mb-4 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                </svg>
                Movement Item Details
            </h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">
                                <input type="checkbox" id="selectAllCheckbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barcode</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HSN Code</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="itemsTableBody" class="bg-white divide-y divide-gray-200">
                        @forelse($movement->items as $detail)
                            @php $item = $detail->item; @endphp
                            <tr class="hover:bg-gray-50" data-item-id="{{ $item->id }}">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <input type="checkbox" class="rowCheckbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->barcode }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $item->category->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $item->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $item->hsn_code }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    <input type="number" name="items[{{ $item->id }}][qty]" value="{{ $detail->quantity }}" min="1" max="{{ $item->current_stock }}" 
                                           class="qtyInput w-16 border rounded-md px-2 py-1 text-center border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                           data-price="{{ $item->price }}" data-stock="{{ $item->current_stock }}" required>
                                    <input type="hidden" name="items[{{ $item->id }}][barcode]" value="{{ $item->barcode }}">
                                    <input type="hidden" name="items[{{ $item->id }}][name]" value="{{ $item->name }}">
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $item->unit->name ?? $item->unit }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right subtotal">0.00</td>
                            </tr>
                        @empty
                            <tr id="noDataRow">
                                <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="mt-2">No items added yet</p>
                                        <p class="text-xs text-gray-500 mt-1">Start scanning barcodes to add items</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="9" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Grand Total</td>
                            <td id="grandTotal" class="px-4 py-3 text-right text-sm font-medium text-gray-900">₹0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <button type="button" id="deleteSelectedBtn"
                    class="mt-4 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Delete Selected
            </button>
        </div>

        <!-- Summary -->
        <div class="mt-2 border-t px-6 py-4 bg-gray-50">
            <h3 class="font-semibold mb-3 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Summary
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Total Quantity</span>
                        <span id="totalQty" class="text-lg font-semibold text-gray-800">0</span>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Total Amount</span>
                        <span id="totalAmount" class="text-lg font-semibold text-blue-600">₹0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const barcodeInput = document.getElementById('barcodeInput');
    const itemsTableBody = document.getElementById('itemsTableBody');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    let itemCount = {{ $movement->items->count() }};

    function updateSummary() {
        let totalQty = 0;
        let totalAmount = 0;

        document.querySelectorAll('.qtyInput').forEach(input => {
            const qty = parseInt(input.value) || 0;
            const price = parseFloat(input.dataset.price) || 0;
            const subtotal = qty * price;
            totalQty += qty;
            totalAmount += subtotal;

            const subtotalCell = input.closest('tr').querySelector('.subtotal');
            if (subtotalCell) {
                subtotalCell.textContent = subtotal.toLocaleString('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        });

        document.getElementById('totalQty').textContent = totalQty;
        document.getElementById('totalAmount').textContent = totalAmount.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById('grandTotal').textContent = totalAmount.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function updateSlno() {
        const rows = Array.from(itemsTableBody.querySelectorAll('tr')).filter(row => row.id !== 'noDataRow');
        rows.forEach((row, index) => {
            const slnoCell = row.querySelector('td:nth-child(2)');
            if (slnoCell) slnoCell.textContent = index + 1;
        });
        itemCount = rows.length;
    }

    function updateDeleteButtonVisibility() {
        const anyChecked = document.querySelectorAll('.rowCheckbox:checked').length > 0;
        deleteSelectedBtn.classList.toggle('hidden', !anyChecked);
    }

    itemsTableBody.addEventListener('input', function(e) {
        if (e.target.classList.contains('qtyInput')) {
            const input = e.target;
            const maxStock = parseInt(input.dataset.stock);
            let val = parseInt(input.value);
            if (isNaN(val) || val < 1) val = 1;
            if (val > maxStock) {
                alert('Quantity cannot exceed current stock: ' + maxStock);
                val = maxStock;
            }
            input.value = val;
            updateSummary();
        }
    });

    itemsTableBody.addEventListener('change', function(e) {
        if (e.target.classList.contains('rowCheckbox')) {
            updateDeleteButtonVisibility();
            if (!e.target.checked) selectAllCheckbox.checked = false;
            else {
                const allChecked = Array.from(document.querySelectorAll('.rowCheckbox')).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
            }
        }
    });

    selectAllCheckbox.addEventListener('change', function() {
        document.querySelectorAll('.rowCheckbox').forEach(cb => cb.checked = this.checked);
        updateDeleteButtonVisibility();
    });

    deleteSelectedBtn.addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.rowCheckbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Select at least one row to delete.');
            return;
        }

        if (!confirm(`Are you sure you want to delete ${checkedBoxes.length} selected item(s)?`)) {
            return;
        }

        checkedBoxes.forEach(cb => cb.closest('tr').remove());

        // If no rows left, show No Data row
        if (itemsTableBody.querySelectorAll('tr').length === 0 || 
            (itemsTableBody.querySelectorAll('tr').length === 1 && document.getElementById('noDataRow'))) {
            itemsTableBody.innerHTML = `
                <tr id="noDataRow">
                    <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                        <div class="flex flex-col items-center justify-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-2">No items added yet</p>
                            <p class="text-xs text-gray-500 mt-1">Start scanning barcodes to add items</p>
                        </div>
                    </td>
                </tr>`;
            itemCount = 0;
        }

        selectAllCheckbox.checked = false;
        deleteSelectedBtn.classList.add('hidden');
        updateSlno();
        updateSummary();
    });

    barcodeInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const barcode = barcodeInput.value.trim();
            if (!barcode) return;
            barcodeInput.value = '';

            const noDataRow = document.getElementById('noDataRow');
            if (noDataRow) noDataRow.remove();

            const exists = Array.from(itemsTableBody.querySelectorAll('tr')).find(row => {
                const code = row.querySelector('td:nth-child(3)');
                return code && code.textContent === barcode;
            });

            if (exists) {
                const qtyInput = exists.querySelector('.qtyInput');
                const max = parseInt(qtyInput.dataset.stock);
                let val = parseInt(qtyInput.value) + 1;
                if (val > max) {
                    alert('Quantity cannot exceed current stock: ' + max);
                    val = max;
                }
                qtyInput.value = val;
                updateSummary();
                
                // Visual feedback
                exists.classList.add('bg-blue-50');
                setTimeout(() => exists.classList.remove('bg-blue-50'), 500);
                return;
            }

            fetch(`/outward/${barcode}`)
                .then(res => {
                    if (!res.ok) throw new Error('Not found');
                    return res.json();
                })
                .then(item => {
                    itemCount++;
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-50';
                    row.dataset.itemId = item.id;
                    row.innerHTML = `
                        <td class="px-4 py-3 whitespace-nowrap">
                            <input type="checkbox" class="rowCheckbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${itemCount}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${item.barcode}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.category.name}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${item.name}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.hsn_code || ''}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <input type="number" name="items[${item.id}][qty]" value="1" min="1" max="${item.current_stock}" 
                                   class="qtyInput w-16 border rounded-md px-2 py-1 text-center border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                   data-price="${item.price}" data-stock="${item.current_stock}" required>
                            <input type="hidden" name="items[${item.id}][barcode]" value="${item.barcode}">
                            <input type="hidden" name="items[${item.id}][name]" value="${item.name}">
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.unit.name || item.unit || ''}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${parseFloat(item.price).toFixed(2)}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right subtotal">0.00</td>
                    `;
                    itemsTableBody.appendChild(row);
                    
                    // Visual feedback
                    row.classList.add('bg-green-50');
                    setTimeout(() => row.classList.remove('bg-green-50'), 500);
                    
                    updateSlno();
                    updateSummary();
                })
                .catch(() => {
                    alert('Item not found in this warehouse.');
                });
        }
    });

    // Initialize summary on load
    updateSummary();
});
</script>
@endsection