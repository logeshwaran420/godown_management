@extends('layouts.app')

@section('content')
<div class="w-full mx-auto bg-white">
    <div class="flex justify-between items-center border-b px-6 py-4 bg-gray-50">
        <h2 class="text-xl font-semibold text-gray-800">Movement Entry</h2>
        <button type="submit" form="movementForm"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Save
        </button>
    </div>

    <form id="movementForm" method="POST" action="{{ route('movements.store') }}">
        @csrf
        <input type="hidden" name="from_warehouse_id" value="{{ $from_warehouse->id }}">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-6 border-b">
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">From Warehouse</label>
                <input type="text" value="{{ $from_warehouse->name }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border bg-gray-100 cursor-not-allowed">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <div class="relative">
                    <input type="date" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
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
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border"
                        autofocus>
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
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

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
                Delete 
            </button>
        </div>

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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('movementForm');
    const barcodeInput = document.getElementById('barcodeInput');
    const tableBody = document.getElementById('itemsTableBody');
    const deleteBtn = document.getElementById('deleteSelectedBtn');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    let itemCount = 0;

    // Add item on Enter barcode input
    barcodeInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const barcode = barcodeInput.value.trim();
            if (!barcode) return;

            fetch(`{{ url('/outward') }}/${barcode}`)
                .then(response => {
                    if (!response.ok) throw new Error('Item not found');
                    return response.json();
                })
                .then(item => {
                    // Check if item already in the table
                    const existingRow = Array.from(tableBody.rows).find(row => 
                        row.cells[2]?.textContent === item.barcode && row.id !== 'noDataRow');
                    
                    if (existingRow) {
                        const qtyInput = existingRow.querySelector('.qtyInput');
                        const maxStock = parseInt(qtyInput.dataset.stock, 10) || 0;
                        let currentQty = parseInt(qtyInput.value, 10) || 0;

                        if (currentQty < maxStock) {
                            qtyInput.value = currentQty + 1;
                            qtyInput.dispatchEvent(new Event('input'));
                            
                            // Visual feedback
                            existingRow.classList.add('bg-blue-50');
                            setTimeout(() => existingRow.classList.remove('bg-blue-50'), 500);
                        } else {
                            alert(`Cannot exceed available stock (${maxStock})`);
                        }
                    } else {
                        // Remove No Data row if present
                        document.getElementById('noDataRow')?.remove();

                        itemCount++;
                        const tr = document.createElement('tr');
                        tr.className = 'hover:bg-gray-50';
                        tr.dataset.itemId = item.id;
                        tr.innerHTML = `
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="checkbox" class="rowCheckbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${itemCount}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${item.barcode}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.category?.name || '-'}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${item.name}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.hsn_code || '-'}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                <input type="number" 
                                       name="items[${item.id}][qty]" 
                                       value="1" 
                                       min="1"
                                       max="${item.current_stock}" 
                                       data-stock="${item.current_stock}"
                                       class="qtyInput w-16 border rounded-md px-2 py-1 text-center border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                       required>
                                <input type="hidden" name="items[${item.id}][barcode]" value="${item.barcode}">
                                <input type="hidden" name="items[${item.id}][name]" value="${item.name}">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.unit?.name || '-'}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${parseFloat(item.price).toFixed(2)}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">0.00</td>
                        `;

                        tableBody.appendChild(tr);
                        updateRowSubtotal(tr);
                        updateSummary();
                        
                        // Visual feedback
                        tr.classList.add('bg-green-50');
                        setTimeout(() => tr.classList.remove('bg-green-50'), 500);
                    }
                    barcodeInput.value = '';
                    barcodeInput.focus();
                })
                .catch(err => {
                    if (err instanceof TypeError) {
                        alert('Network error or server not reachable');
                    } else {
                        alert(err.message || 'Error fetching item data');
                    }
                });
        }
    });

    // Quantity input validation and update subtotal & summary
    tableBody.addEventListener('input', function (e) {
        if (e.target.classList.contains('qtyInput')) {
            const input = e.target;
            const maxStock = parseInt(input.dataset.stock, 10);
            let val = parseInt(input.value, 10);

            if (isNaN(val) || val < 1) {
                input.value = 1;
                val = 1;
            } else if (val > maxStock) {
                alert(`Cannot exceed available stock (${maxStock})`);
                input.value = maxStock;
                val = maxStock;
            }

            const row = input.closest('tr');
            updateRowSubtotal(row);
            updateSummary();
        }
    });

    // Select/Deselect all rows
    selectAllCheckbox.addEventListener('change', function () {
        const checked = this.checked;
        tableBody.querySelectorAll('.rowCheckbox').forEach(cb => cb.checked = checked);
        toggleDeleteButton();
    });

    // Show/hide Delete button on checkbox change
    tableBody.addEventListener('change', function (e) {
        if (e.target.classList.contains('rowCheckbox')) {
            toggleDeleteButton();
        }
    });

    // Delete selected rows
    deleteBtn.addEventListener('click', function () {
        const checkedBoxes = tableBody.querySelectorAll('.rowCheckbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Select at least one row to delete.');
            return;
        }

        if (!confirm(`Are you sure you want to delete ${checkedBoxes.length} selected item(s)?`)) {
            return;
        }

        checkedBoxes.forEach(cb => cb.closest('tr').remove());

        // If no rows left, show No Data row
        if (tableBody.rows.length === 0 || 
            (tableBody.rows.length === 1 && document.getElementById('noDataRow'))) {
            tableBody.innerHTML = `
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

        updateSlNo();
        updateSummary();
        toggleDeleteButton();
        
        // Reset select all checkbox
        selectAllCheckbox.checked = false;
    });

    // Update row slno
    function updateSlNo() {
        const rows = Array.from(tableBody.querySelectorAll('tr')).filter(row => row.id !== 'noDataRow');
        rows.forEach((row, idx) => {
            const slnoCell = row.cells[1];
            if (slnoCell) slnoCell.textContent = idx + 1;
        });
        itemCount = rows.length;
    }

    // Update subtotal for a given row
    function updateRowSubtotal(row) {
        const qtyInput = row.querySelector('.qtyInput');
        const priceCell = row.cells[8];
        const subtotalCell = row.cells[9];

        const qty = parseInt(qtyInput.value) || 0;
        const price = parseFloat(priceCell.textContent) || 0;
        const subtotal = qty * price;

        subtotalCell.textContent = subtotal.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Update summary totals
    function updateSummary() {
        let totalQty = 0;
        let totalAmount = 0;

        tableBody.querySelectorAll('tr').forEach(row => {
            if (row.id === 'noDataRow') return;
            
            const qtyInput = row.querySelector('.qtyInput');
            const subtotalCell = row.cells[9];

            if (qtyInput && subtotalCell) {
                totalQty += parseInt(qtyInput.value) || 0;
                const subtotal = parseFloat(subtotalCell.textContent.replace(/[^0-9.-]+/g,"")) || 0;
                totalAmount += subtotal;
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

    // Toggle visibility of Delete button
    function toggleDeleteButton() {
        const anyChecked = Array.from(tableBody.querySelectorAll('.rowCheckbox')).some(cb => cb.checked);
        deleteBtn.classList.toggle('hidden', !anyChecked);
    }


    form.addEventListener('submit', function (e) {
        if (tableBody.querySelectorAll('tr').length === 0 ||
            tableBody.querySelector('#noDataRow')) {
            e.preventDefault();
            alert('Add at least one item to move.');
        }
    });
});
</script>
@endsection