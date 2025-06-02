@extends('layouts.app')
@section('content')

<div class="w-full mx-auto bg-white px-4 py-6 max-w-7xl">
    <div class="flex justify-between items-center border-b px-6 py-4">
        <h2 class="text-xl font-semibold">Outwards Entry</h2>
        <button type="button" id="saveBtn"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            disabled>
            Save
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 border-b gap-4 p-6">
        <div>
            <label for="formDate" class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" id="formDate" name="formDate" class="mt-1 block w-full border rounded px-3 py-2"
                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </div>
        <div class="relative">
            <label for="ledgerInput" class="block text-sm font-medium text-gray-700">Ledger</label>
            <input type="text" id="ledgerInput" name="ledgerInput" placeholder="Ledger" autocomplete="off"
                class="mt-1 block w-full border rounded px-3 py-2 bg-white">
            <ul id="ledgerList"
                class="absolute z-10 w-full border mt-1 bg-white rounded shadow max-h-48 overflow-y-auto hidden"></ul>
        </div>

        <div>
            <label for="barcodeInput" class="block text-sm font-medium text-gray-700">Barcode</label>
            <input type="text" id="barcodeInput" name="barcodeInput" placeholder="Enter Barcode"
                class="mt-1 block w-full border rounded px-3 py-2" autofocus>
        </div>
    </div>

    <div class="px-6 py-2 pb-6">
        <h3 class="font-semibold text-lg mb-4">Outward Item Details</h3>
        <table class="w-full border text-sm table-fixed">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-2 w-10"><input type="checkbox" id="selectAll"></th>
                    <th class="border px-2 py-2 w-10">Slno</th>
                    <th class="border px-2 py-2 w-32">Bar Code</th>
                    <th class="border px-2 py-2 w-28">Category</th>
                    <th class="border px-2 py-2">Item</th>
                    <th class="border px-2 py-2 w-24">HSN Code</th>
                    <th class="border px-2 py-2 w-20">Qty</th>
                    <th class="border px-2 py-2 w-20">Unit</th>
                    <th class="border px-2 py-2 w-20">Rate</th>
                    <th class="border px-2 py-2 w-20">Subtotal</th>
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

        <button type="button" id="deleteSelectedBtn"
            class="mt-4 bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600 hidden">
            Delete
        </button>
    </div>

    <div class="mt-6 border-t px-6 py-4">
        <h3 class="font-semibold mb-2">Summary</h3>
        <div class="overflow-x-auto">
            <table class="min-w-max text-sm border">
                <tbody>
                    <tr>
                        <th class="border px-2 py-2 text-left">Total Qty</th>
                        <td id="totalQty" class="border px-2 py-2">0</td>
                    </tr>
                    <tr>
                        <th class="border px-2 py-2 text-left">Total Amount</th>
                        <td id="totalPrice" class="border px-2 py-2">0.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ledgerInput = document.getElementById('ledgerInput');
    const ledgerList = document.getElementById('ledgerList');
    const barcodeInput = document.getElementById('barcodeInput');
    const itemsTableBody = document.getElementById('itemsTableBody');
    const totalQty = document.getElementById('totalQty');
    const totalPrice = document.getElementById('totalPrice');
    const saveBtn = document.getElementById('saveBtn');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    const selectAllCheckbox = document.getElementById('selectAll');

    let items = [];
    let selectedLedgerId = null;

    ledgerInput.addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length < 2) {
            ledgerList.classList.add('hidden');
            selectedLedgerId = null;
            checkEnableSave();
            return;
        }

        fetch(`/customer/${query}`)
            .then(response => response.json())
            .then(data => {
                ledgerList.innerHTML = '';
                if (data.length === 0) {
                    ledgerList.classList.add('hidden');
                    selectedLedgerId = null;
                    checkEnableSave();
                    return;
                }

                data.forEach(ledger => {
                    const li = document.createElement('li');
                    li.textContent = ledger.name;
                    li.classList.add('cursor-pointer', 'px-3', 'py-1', 'hover:bg-gray-200');
                    li.addEventListener('click', function () {
                        ledgerInput.value = ledger.name;
                        selectedLedgerId = ledger.id;
                        ledgerList.classList.add('hidden');
                        checkEnableSave();
                    });
                    ledgerList.appendChild(li);
                });

                ledgerList.classList.remove('hidden');
            })
            .catch(() => {
                ledgerList.classList.add('hidden');
                selectedLedgerId = null;
                checkEnableSave();
            });
    });

    document.addEventListener('click', function (e) {
        if (!ledgerInput.contains(e.target) && !ledgerList.contains(e.target)) {
            ledgerList.classList.add('hidden');
        }
    });

    barcodeInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const barcode = this.value.trim();
            if (!barcode) return;

            fetch(`/outward/${barcode}`)
                .then(res => {
                    if (!res.ok) throw new Error('Item not found');
                    return res.json();
                })
                .then(data => {
                    if (!data.current_stock || data.current_stock <= 0) {
                        alert('Item is unavailable in the godown');
                        barcodeInput.value = '';
                        return;
                    }

                    const existingItemIndex = items.findIndex(item => item.barcode === data.barcode);
                    if (existingItemIndex !== -1) {
                        let currentQty = items[existingItemIndex].entered_qty || 1;
                        if (currentQty < data.current_stock) {
                            items[existingItemIndex].entered_qty = currentQty + 1;
                        } else {
                            alert('Reached maximum stock limit for this item');
                        }
                    } else {
                        data.entered_qty = 1;
                        items.push(data);
                    }

                    updateTable();
                    barcodeInput.value = '';
                    checkEnableSave();
                })
                .catch(err => {
                    alert(err.message);
                });
        }
    });

    function updateTable() {
        itemsTableBody.innerHTML = '';
        if (items.length === 0) {
            itemsTableBody.innerHTML = `<tr id="noDataRow"><td class="px-3 py-3" colspan="10">No Data</td></tr>`;
            saveBtn.disabled = true;
            deleteSelectedBtn.classList.add('hidden');
            selectAllCheckbox.checked = false;
            return;
        }

        items.forEach((item, index) => {
            item.entered_qty = item.entered_qty || 1;

            const subtotal = (item.entered_qty * (item.price || 0)).toFixed(2);

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="border px-2 py-2"><input type="checkbox" class="rowCheckbox" data-index="${index}"></td>
                <td class="border px-2 py-2">${index + 1}</td>
                <td class="border px-2 py-2">${item.barcode}</td>
                <td class="border px-2 py-2">${item.category?.name || '-'}</td>
                <td class="border px-2 py-2">${item.name}</td>
                <td class="border px-2 py-2">${item.hsn_code || '-'}</td>
                <td class="border px-2 py-2">
                    <input type="number" min="1" max="${item.current_stock}" value="${item.entered_qty}"
                        class="qtyInput w-16 border rounded px-1 text-center" data-index="${index}">
                </td>
                <td class="border px-2 py-2">${item.unit?.name || '-'}</td>
                <td class="border px-2 py-2">${item.price || 0}</td>
                <td class="border px-2 py-2">${subtotal}</td>
            `;
            itemsTableBody.appendChild(tr);
        });

        document.querySelectorAll('.qtyInput').forEach(input => {
            input.addEventListener('input', function () {
                const index = this.dataset.index;
                let value = Number(this.value);
                const max = Number(this.max);
                if (value > max) value = max;
                if (value < 1) value = 1;
                this.value = value;
                items[index].entered_qty = value;
                calculateTotals();
                updateTable();
                checkEnableSave();
            });
        });

        document.querySelectorAll('.rowCheckbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                toggleDeleteButton();
                toggleSelectAllCheckbox();
            });
        });

        saveBtn.disabled = false;
        calculateTotals();
    }

    function calculateTotals() {
        let totalQtyVal = 0;
        let totalPriceVal = 0;

        items.forEach(item => {
            totalQtyVal += Number(item.entered_qty || 0);
            totalPriceVal += Number(item.entered_qty || 0) * Number(item.price || 0);
        });

        totalQty.textContent = totalQtyVal;
        totalPrice.textContent = totalPriceVal.toFixed(2);

        document.getElementById('grandTotal').textContent = totalPriceVal.toFixed(2);
    }

    function toggleDeleteButton() {
        const anyChecked = Array.from(document.querySelectorAll('.rowCheckbox')).some(chk => chk.checked);
        deleteSelectedBtn.classList.toggle('hidden', !anyChecked);
    }

    deleteSelectedBtn.addEventListener('click', function () {
        const checkedBoxes = Array.from(document.querySelectorAll('.rowCheckbox:checked'));
        checkedBoxes.sort((a, b) => b.dataset.index - a.dataset.index).forEach(chk => {
            items.splice(chk.dataset.index, 1);
        });
        updateTable();
        checkEnableSave();
    });

    selectAllCheckbox.addEventListener('change', function () {
        const checked = this.checked;
        document.querySelectorAll('.rowCheckbox').forEach(chk => {
            chk.checked = checked;
        });
        toggleDeleteButton();
    });

    function toggleSelectAllCheckbox() {
        const all = document.querySelectorAll('.rowCheckbox');
        const checked = document.querySelectorAll('.rowCheckbox:checked');
        selectAllCheckbox.checked = all.length > 0 && all.length === checked.length;
    }

    function checkEnableSave() {
        saveBtn.disabled = !(items.length > 0 && selectedLedgerId !== null);
    }

    saveBtn.addEventListener('click', function () {
        if (!selectedLedgerId) {
            alert('Please select a ledger');
            return;
        }

        if (items.length === 0) {
            alert('Please add items before saving.');
            return;
        }

        const data = {
            date: document.getElementById('formDate').value,
            ledger_id: selectedLedgerId,
            warehouse_id: 1, // adjust if dynamic
            invoice_no: '',
            items: items.map(item => ({
                item_id: item.id,
                barcode: item.barcode,
                category_id: item.category?.id || null,
                name: item.name,
                hsn_code: item.hsn_code || null,
                quantity: item.entered_qty,
                unit_id: item.unit?.id || null,
                price: item.price || 0,
            }))
        };

        saveBtn.disabled = true;
        fetch('/outwards/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
            .then(res => {
                if (!res.ok) throw new Error('Failed to save');
                return res.json();
            })
            .then(resp => {
                alert('Outward entry saved successfully.');
                
                items = [];
                selectedLedgerId = null;
                ledgerInput.value = '';
                barcodeInput.value = '';
                updateTable();
                checkEnableSave();
                  window.location.href = "{{ route('outwards') }}";
            })
            .catch(() => {
                alert('Error saving data.');
            })
            .finally(() => {
                saveBtn.disabled = false;
            });
    });

    // Initial table update
    updateTable();
});
</script>

@endsection
