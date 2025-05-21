@extends('layouts.app')

@section('content')
<div class="w-full mx-auto bg-white px-4 py-6">
    <form id="movementForm" method="POST" action="{{ route('movements.store') }}">
        @csrf
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h2 class="text-xl font-semibold">Item Movement</h2>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 border-b gap-4 p-6 w-full">
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">From</label>
                <input type="text" value="{{ $from_warehouse->name }}" readonly class="mt-1 block w-full border rounded px-3 py-2 cursor-not-allowed">
                <input type="hidden" name="from_warehouse_id" value="{{ $from_warehouse->id }}">
            </div>

            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            </div>

            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">Barcode</label>
                <input type="text" id="barcodeInput" placeholder="Enter Barcode" class="mt-1 block w-full border rounded px-3 py-2" autocomplete="off">
            </div>

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

        <!-- Table -->
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
                    </tr>
                </thead>
                <tbody id="itemsTableBody" class="text-center">
                    <tr id="noDataRow">
                        <td class="px-3 py-3" colspan="9">No Data</td>
                    </tr>
                </tbody>
            </table>
            <button type="button" id="deleteSelectedBtn" class="mt-4 bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600 hidden">
                Delete Selected
            </button>
        </div>

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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('movementForm');
    const barcodeInput = document.getElementById('barcodeInput');
    const tableBody = document.getElementById('itemsTableBody');
    const deleteBtn = document.getElementById('deleteSelectedBtn');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');

    // Handle barcode input enter key press
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
                        } else {
                            alert(`Cannot exceed available stock (${maxStock})`);
                        }
                    } else {
                        document.getElementById('noDataRow')?.remove();

                        const rowCount = tableBody.rows.length + 1;

                        // Create new row
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
                        `;
                        tableBody.appendChild(tr);
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

    // Update summary on quantity change
    tableBody.addEventListener('input', function (e) {
        if (e.target.classList.contains('qtyInput')) {
            const maxStock = parseInt(e.target.dataset.stock, 10) || 0;
            let val = parseInt(e.target.value, 10) || 0;
            if (val > maxStock) {
                alert(`Quantity cannot exceed available stock (${maxStock})`);
                e.target.value = maxStock;
            } else if (val < 1) {
                e.target.value = 1;
            }
            updateSummary();
        }
    });

    // Delete selected rows
    deleteBtn.addEventListener('click', () => {
        tableBody.querySelectorAll('.rowCheckbox:checked').forEach(cb => cb.closest('tr').remove());

        if (tableBody.rows.length === 0) {
            tableBody.innerHTML = '<tr id="noDataRow"><td class="px-3 py-3" colspan="9">No Data</td></tr>';
        }
        deleteBtn.style.display = 'none';
        updateSlNo();
        updateSummary();
        selectAllCheckbox.checked = false;
    });

    // Show/hide delete button based on checkbox selection
    tableBody.addEventListener('change', function (e) {
        if (e.target.classList.contains('rowCheckbox')) {
            deleteBtn.style.display = tableBody.querySelector('.rowCheckbox:checked') ? 'inline-block' : 'none';

            // Update "Select All" checkbox state
            const allChecked = tableBody.querySelectorAll('.rowCheckbox').length === tableBody.querySelectorAll('.rowCheckbox:checked').length;
            selectAllCheckbox.checked = allChecked;
        }
    });

    // Select/deselect all rows
    selectAllCheckbox.addEventListener('change', function () {
        const checkboxes = tableBody.querySelectorAll('.rowCheckbox');
        checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
        deleteBtn.style.display = selectAllCheckbox.checked ? 'inline-block' : 'none';
    });

    // Update total quantity and amount
    function updateSummary() {
        let totalQty = 0;
        let totalAmount = 0;

        tableBody.querySelectorAll('tr').forEach(row => {
            if (row.id === 'noDataRow') return;

            const qtyInput = row.querySelector('.qtyInput');
            if (!qtyInput) return;

            const qty = parseInt(qtyInput.value, 10) || 0;
            totalQty += qty;

            // Assuming price is in last cell
            const priceCell = row.cells[row.cells.length - 1];
            const price = parseFloat(priceCell.textContent) || 0;
            totalAmount += price * qty;
        });

        document.getElementById('totalQty').textContent = totalQty;
        document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
    }

    // Update Slno after row deletion
    function updateSlNo() {
        let count = 1;
        tableBody.querySelectorAll('tr').forEach(row => {
            if (row.id === 'noDataRow') return;
            row.cells[1].textContent = count++;
        });
    }
});
</script>
@endsection
