@extends('layouts.app')

@section('content')
<div class="w-full mx-auto bg-white px-4 py-6">
    <form id="movementForm" method="POST" action="{{ route('movements.store') }}">
        @csrf

        {{-- Header: Title and Save Button --}}
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h2 class="text-xl font-semibold">Movement Entry</h2>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save
            </button>
        </div>

        {{-- Inputs Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 border-b gap-4 p-6 w-full">
            {{-- From Warehouse (readonly) --}}
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">From</label>
                <input type="text" value="{{ $from_warehouse->name }}" readonly
                       class="mt-1 block w-full border rounded px-3 py-2 cursor-not-allowed">
                <input type="hidden" name="from_warehouse_id" value="{{ $from_warehouse->id }}">
            </div>

            {{-- Date --}}
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                       class="mt-1 block w-full border rounded px-3 py-2" required>
            </div>

            {{-- Barcode Input --}}
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">Barcode</label>
                <input type="text" id="barcodeInput" placeholder="Enter Barcode"
                       class="mt-1 block w-full border rounded px-3 py-2" autocomplete="off">
            </div>

            {{-- To Warehouse Dropdown --}}
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">To</label>
                <select name="to_warehouse_id" class="mt-1 block w-full border rounded px-3 py-2 bg-white" required>
                    <option value="">Select Warehouse</option>
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Movement Items Table --}}
        <div class="px-6 py-2 pb-6">
            <h3 class="font-semibold text-lg mb-4">Movement Item Details</h3>
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-2"><input type="checkbox" id="selectAllCheckbox"></th>
                        <th class="border px-2 py-2">Slno</th>
                        <th class="border px-2 py-2">Bar Code</th>
                        <th class="border px-2 py-2">Category</th>
                        <th class="border px-2 py-2">Item</th>
                        <th class="border px-2 py-2">HSN Code</th>
                        <th class="border px-2 py-2">Qty</th>
                        <th class="border px-2 py-2">Unit</th>
                        <th class="border px-2 py-2">Price</th>
                        <th class="border px-2 py-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody id="itemsTableBody" class="text-center">
                    <tr id="noDataRow">
                        <td class="px-3 py-3" colspan="10">No Data</td>
                    </tr>
                </tbody>
                <tfoot class="bg-gray-100 font-semibold">
                    <tr>
                        <td colspan="9" class="text-right border px-2 py-2">Grand Total</td>
                        <td id="grandTotal" class="border px-2 py-2 text-right">0.00</td>
                    </tr>
                </tfoot>
            </table>

            {{-- Delete Selected Button --}}
            <button type="button" id="deleteSelectedBtn"
                    class="mt-4 bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600 hidden">
                Delete
            </button>
        </div>

        {{-- Summary Section --}}
        <div class="mt-6 border-t px-6 py-4">
            <h3 class="font-semibold mb-2">Summary</h3>
            <div class="overflow-x-auto">
                <table class="min-w-max text-sm border">
                    <tr>
                        <th class="border px-2 py-2 text-left">Total Qty</th>
                        <td class="border px-2 py-2" id="totalQty">0</td>
                    </tr>
                    <tr>
                        <th class="border px-2 py-2 text-left">Total Amount</th>
                        <td class="border px-2 py-2" id="totalAmount">0.00</td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
</div>

{{-- JavaScript for dynamic row adding, updating totals, deleting --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('movementForm');
    const barcodeInput = document.getElementById('barcodeInput');
    const tableBody = document.getElementById('itemsTableBody');
    const deleteBtn = document.getElementById('deleteSelectedBtn');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');

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
                    const existingRow = Array.from(tableBody.rows).find(row => row.cells[2]?.textContent === item.barcode);
                    if (existingRow) {
                        const qtyInput = existingRow.querySelector('.qtyInput');
                        const maxStock = parseInt(qtyInput.dataset.stock, 10) || 0;
                        let currentQty = parseInt(qtyInput.value, 10) || 0;

                        if (currentQty < maxStock) {
                            qtyInput.value = currentQty + 1;
                            updateRowSubtotal(existingRow);
                        } else {
                            alert(`Cannot exceed available stock (${maxStock})`);
                        }
                    } else {
                        // Remove No Data row if present
                        document.getElementById('noDataRow')?.remove();

                        const rowCount = tableBody.querySelectorAll('tr').length + 1;

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="border px-2 py-2 text-center">
                                <input type="checkbox" class="rowCheckbox">
                            </td>
                            <td class="border px-2 py-2 text-center">${rowCount}</td>
                            <td class="border px-2 py-2">${item.barcode}</td>
                            <td class="border px-2 py-2">${item.category.name}</td>
                            <td class="border px-2 py-2">${item.name}</td>
                            <td class="border px-2 py-2">${item.hsn_code || ''}</td>
                            <td class="border px-2 py-2">
                                <input type="number" 
                                       name="items[${item.id}][qty]" 
                                       value="1" 
                                       min="1"
                                       max="${item.current_stock}" 
                                       data-stock="${item.current_stock}"
                                       class="qtyInput border rounded w-16 text-center px-1 py-0.5" 
                                       required>
                                <input type="hidden" name="items[${item.id}][barcode]" value="${item.barcode}">
                                <input type="hidden" name="items[${item.id}][name]" value="${item.name}">
                            </td>
                            <td class="border px-2 py-2">${item.unit.name || item.unit}</td>
                            <td class="border px-2 py-2">${parseFloat(item.price).toFixed(2)}</td>
                            <td class="border px-2 py-2 text-right">0.00</td>
                        `;

                        tableBody.appendChild(tr);
                        updateRowSubtotal(tr);
                        updateSlNo();
                    }
                    updateSummary();
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

        checkedBoxes.forEach(cb => cb.closest('tr').remove());

        // If no rows left, show No Data row
        if (tableBody.rows.length === 0) {
            const noDataRow = document.createElement('tr');
            noDataRow.id = 'noDataRow';
            noDataRow.innerHTML = `<td class="px-3 py-3" colspan="10">No Data</td>`;
            tableBody.appendChild(noDataRow);
        }

        updateSlNo();
        updateSummary();
        toggleDeleteButton();
    });

    // Update row slno
    function updateSlNo() {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach((row, idx) => {
            const slnoCell = row.cells[1];
            if (slnoCell) slnoCell.textContent = idx + 1;
        });
    }

    // Update subtotal for a given row
    function updateRowSubtotal(row) {
        const qtyInput = row.querySelector('.qtyInput');
        const priceCell = row.cells[8];
        const subtotalCell = row.cells[9];

        const qty = parseInt(qtyInput.value) || 0;
        const price = parseFloat(priceCell.textContent) || 0;
        const subtotal = qty * price;

        subtotalCell.textContent = subtotal.toFixed(2);
    }

    // Update summary totals
    function updateSummary() {
        let totalQty = 0;
        let totalAmount = 0;

        tableBody.querySelectorAll('tr').forEach(row => {
            const qtyInput = row.querySelector('.qtyInput');
            const subtotalCell = row.cells[9];

            if (qtyInput && subtotalCell) {
                totalQty += parseInt(qtyInput.value) || 0;
                totalAmount += parseFloat(subtotalCell.textContent) || 0;
            }
        });

        document.getElementById('totalQty').textContent = totalQty;
        document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
        document.getElementById('grandTotal').textContent = totalAmount.toFixed(2);
    }

    // Toggle visibility of Delete button
    function toggleDeleteButton() {
        const anyChecked = Array.from(tableBody.querySelectorAll('.rowCheckbox')).some(cb => cb.checked);
        deleteBtn.style.display = anyChecked ? 'inline-block' : 'none';
    }

    // Optional: prevent form submit if no items added
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
