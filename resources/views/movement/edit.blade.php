@extends('layouts.app')

@section('content')
<div class="w-full mx-auto bg-white px-4 py-6">
    <form id="movementForm" method="POST" action="{{ route('movements.update', $movement->id) }}">
        @csrf
        @method('PUT')

        <!-- Header -->
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h2 class="text-xl font-semibold">Edit Item Movement</h2>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </div>

        <!-- Movement Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 border-b gap-4 p-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">From</label>
                <input type="text" value="{{ $from_warehouse->name }}" readonly class="mt-1 w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                <input type="hidden" name="from_warehouse_id" value="{{ $from_warehouse->id }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" max="{{ now()->format('Y-m-d') }}" value="{{ \Carbon\Carbon::parse($movement->date)->format('Y-m-d') }}" class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Barcode</label>
                <input type="text" id="barcodeInput" placeholder="Enter Barcode" class="mt-1 w-full border rounded px-3 py-2" autocomplete="off">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">To</label>
                <select name="to_warehouse_id" class="mt-1 w-full border rounded px-3 py-2 bg-white" required>
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
        <div class="px-6 py-2 pb-6">
            <h3 class="font-semibold text-lg mb-4">Movement Item Details</h3>
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-2"><input type="checkbox" id="selectAllCheckbox"></th>
                        <th class="border px-2 py-2">Slno</th>
                        <th class="border px-2 py-2">Barcode</th>
                        <th class="border px-2 py-2">Category</th>
                        <th class="border px-2 py-2">Item</th>
                        <th class="border px-2 py-2">HSN Code</th>
                        <th class="border px-2 py-2">Qty</th>
                        <th class="border px-2 py-2">Unit</th>
                        <th class="border px-2 py-2">Price</th>
                    </tr>
                </thead>
                <tbody id="itemsTableBody" class="text-center">
                    @forelse($movement->items as $detail)
                        @php $item = $detail->item; @endphp
                        <tr>
                            <td class="border px-2 py-2"><input type="checkbox" class="rowCheckbox"></td>
                            <td class="border px-2 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border px-2 py-2">{{ $item->barcode }}</td>
                            <td class="border px-2 py-2">{{ $item->category->name }}</td>
                            <td class="border px-2 py-2">{{ $item->name }}</td>
                            <td class="border px-2 py-2">{{ $item->hsn_code }}</td>
                            <td class="border px-2 py-2">
                                <input type="number" name="items[{{ $item->id }}][qty]" value="{{ $detail->quantity }}" min="1" max="{{ $item->current_stock }}" class="qtyInput border rounded w-16 text-center px-1 py-0.5" data-stock="{{ $item->current_stock }}" required>
                                <input type="hidden" name="items[{{ $item->id }}][barcode]" value="{{ $item->barcode }}">
                                <input type="hidden" name="items[{{ $item->id }}][name]" value="{{ $item->name }}">
                            </td>
                            <td class="border px-2 py-2">{{ $item->unit->name ?? $item->unit }}</td>
                            <td class="border px-2 py-2">{{ number_format($item->price, 2) }}</td>
                        </tr>
                    @empty
                        <tr id="noDataRow">
                            <td colspan="9" class="py-4 text-center text-gray-500">No Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <button type="button" id="deleteSelectedBtn" class="mt-4 bg-red-500 text-white px-3 py-1 text-xs rounded hover:bg-red-600 hidden">
                Delete
            </button>
        </div>

        <!-- Summary -->
        <div class="mt-6 border-t px-6 py-4">
            <h3 class="font-semibold mb-2">Summary</h3>
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
    </form>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const barcodeInput = document.getElementById('barcodeInput');
    const itemsTableBody = document.getElementById('itemsTableBody');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');

    function updateSummary() {
        let totalQty = 0;
        let totalAmount = 0;

        document.querySelectorAll('.qtyInput').forEach(input => {
            const qty = parseInt(input.value) || 0;
            const price = parseFloat(input.closest('tr').querySelector('td:last-child').textContent) || 0;
            totalQty += qty;
            totalAmount += qty * price;
        });

        document.getElementById('totalQty').textContent = totalQty;
        document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
    }

    function updateSlno() {
        itemsTableBody.querySelectorAll('tr').forEach((row, index) => {
            const slnoCell = row.querySelector('td:nth-child(2)');
            if (slnoCell) slnoCell.textContent = index + 1;
        });
    }

    function updateDeleteButtonVisibility() {
        const anyChecked = document.querySelectorAll('.rowCheckbox:checked').length > 0;
        deleteSelectedBtn.style.display = anyChecked ? 'inline-block' : 'none';
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
        document.querySelectorAll('.rowCheckbox:checked').forEach(cb => cb.closest('tr').remove());
        if (!itemsTableBody.querySelector('tr')) {
            itemsTableBody.innerHTML = `<tr id="noDataRow"><td colspan="9" class="py-4 text-center text-gray-500">No Data</td></tr>`;
        }
        selectAllCheckbox.checked = false;
        deleteSelectedBtn.style.display = 'none';
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
                return;
            }

            fetch(`/outward/${barcode}`)
                .then(res => {
                    if (!res.ok) throw new Error('Not found');
                    return res.json();
                })
                .then(item => {
                    const row = `
                        <tr>
                            <td class="border px-2 py-2 text-center"><input type="checkbox" class="rowCheckbox"></td>
                            <td class="border px-2 py-2 text-center"></td>
                            <td class="border px-2 py-2">${item.barcode}</td>
                            <td class="border px-2 py-2">${item.category.name}</td>
                            <td class="border px-2 py-2">${item.name}</td>
                            <td class="border px-2 py-2">${item.hsn_code || ''}</td>
                            <td class="border px-2 py-2">
                                <input type="number" name="items[${item.id}][qty]" value="1" min="1" max="${item.current_stock}" class="qtyInput border rounded w-16 text-center px-1 py-0.5" data-stock="${item.current_stock}" required>
                                <input type="hidden" name="items[${item.id}][barcode]" value="${item.barcode}">
                                <input type="hidden" name="items[${item.id}][name]" value="${item.name}">
                            </td>
                            <td class="border px-2 py-2">${item.unit.name || item.unit || ''}</td>
                            <td class="border px-2 py-2">${parseFloat(item.price).toFixed(2)}</td>
                        </tr>
                    `;
                    itemsTableBody.insertAdjacentHTML('beforeend', row);
                    updateSlno();
                    updateSummary();
                })
                .catch(() => {
                    alert('Item not found in this warehouse.');
                });
        }
    });

    updateSlno();
    updateSummary();
});
</script>
@endsection
