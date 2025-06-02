@extends('layouts.app')

@section('content')
<div class="w-full mx-auto bg-white px-4 py-6">
    <div class="flex justify-between items-center border-b px-6 py-4">
        <h2 class="text-xl font-semibold">Inwards Entry</h2>
        <button type="button" id="saveBtn"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 border-b gap-4 p-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" id="formDate" class="mt-1 block w-full border rounded px-3 py-2"
                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </div>

        <div class="relative">
            <label class="block text-sm font-medium text-gray-700">Ledger</label>
            <input type="text" id="ledgerInput" placeholder="Ledger" autocomplete="off"
                class="mt-1 block w-full border rounded px-3 py-2 bg-white">
            <ul id="ledgerList"
                class="absolute z-10 w-full border mt-1 bg-white rounded shadow max-h-48 overflow-y-auto hidden"></ul>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Barcode</label>
            <input type="text" id="barcodeInput" placeholder="Enter Barcode"
                class="mt-1 block w-full border rounded px-3 py-2" autofocus>
        </div>
    </div>

    <div class="px-6 py-2 pb-6">
        <h3 class="font-semibold text-lg mb-4">Inwards Item Details</h3>
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-2"></th>
                    <th class="border px-2 py-2">Slno</th>
                    <th class="border px-2 py-2">Bar Code</th>
                    <th class="border px-2 py-2">Category</th>
                    <th class="border px-2 py-2">Item</th>
                    <th class="border px-2 py-2">HSN Code</th>
                    <th class="border px-2 py-2">Qty</th>
                    <th class="border px-2 py-2">Unit</th>
                    <th class="border px-2 py-2">Rate</th>
                    <th class="border px-2 py-2">Subtotal</th>
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
                    <td id="grandTotal" class="border px-2 py-2 text-right">₹0.00</td>
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
                <tr>
                    <th class="border px-2 py-2 text-left">Total Qty</th>
                    <td id="totalQty" class="border px-2 py-2">0</td>
                </tr>
                <tr>
                    <th class="border px-2 py-2 text-left">Total Amount</th>
                    <td id="totalPrice" class="border px-2 py-2">₹0.00</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script>
    let itemCount = 0;

    document.getElementById('ledgerInput').addEventListener('input', function () {
        let query = this.value;
        if (query.length < 2) return;

        fetch(`/supplier/${query}`)
            .then(res => res.json())
            .then(data => {
                let list = document.getElementById('ledgerList');
                list.innerHTML = '';
                if (data.length === 0) return list.classList.add('hidden');
                
                data.forEach(ledger => {
                    let li = document.createElement('li');
                    li.textContent = ledger.name;
                    li.dataset.id = ledger.id;
                    li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                    li.onclick = () => {
                        document.getElementById('ledgerInput').value = ledger.name;
                        document.getElementById('ledgerInput').dataset.id = ledger.id;
                        list.classList.add('hidden');
                        list.innerHTML = '';        

                    };
                    list.appendChild(li);
                });
                list.classList.remove('hidden');
            });
    });
    
    
    document.getElementById('barcodeInput').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            let barcode = this.value.trim();
            if (!barcode) return;

            let existingRow = [...document.querySelectorAll('#itemsTableBody tr')].find(tr => tr.children[2]?.textContent === barcode);
            if (existingRow) {
                let qtyInput = existingRow.querySelector('.qtyInput');
                qtyInput.value = parseInt(qtyInput.value) + 1;
                calculateSummary();
                this.value = '';
                return;
            }

            fetch(`/inward/${barcode}`)
                .then(res => res.ok ? res.json() : Promise.reject('Item not found'))
                .then(item => {
                    document.getElementById('noDataRow')?.remove();
                    itemCount++;
                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="border px-2 py-2"><input type="checkbox" class="rowCheckbox"></td>
                        <td class="border px-2 py-2">${itemCount}</td>
                        <td class="border px-2 py-2">${item.barcode}</td>
                        <td class="border px-2 py-2">${item.category?.name || '-'}</td>
                        <td class="border px-2 py-2">${item.name}</td>
                        <td class="border px-2 py-2">${item.hsn_code || '-'}</td>
                        <td class="border px-2 py-2"><input type="number" value="1" min="1" class="qtyInput w-16 border rounded text-center"></td>
                        <td class="border px-2 py-2">${item.unit?.name || '-'}</td>
                        <td class="border px-2 py-2">${item.price}</td>
                        <td class="border px-2 py-2 text-right">0.00</td>
                    `;
                    row.dataset.itemId = item.id;
                    document.getElementById('itemsTableBody').appendChild(row);
                    this.value = '';
                    calculateSummary();
                })
                .catch(err => alert(err));
        }
    });
    
    document.getElementById('itemsTableBody').addEventListener('input', function (e) {
        if (e.target.classList.contains('qtyInput')) {
            calculateSummary();
        }
    });

    document.getElementById('itemsTableBody').addEventListener('change', toggleDeleteBtn);

    
    document.getElementById('deleteSelectedBtn').addEventListener('click', function () {
        document.querySelectorAll('.rowCheckbox:checked').forEach(chk => {
            chk.closest('tr').remove();
        });
        calculateSummary();
        toggleDeleteBtn();
        if (!document.querySelectorAll('#itemsTableBody tr').length) {
            document.getElementById('itemsTableBody').innerHTML = `<tr id="noDataRow"><td colspan="10" class="text-center py-3">No Data</td></tr>`;
            itemCount = 0;
        }
    });

    function toggleDeleteBtn() {
        const anyChecked = document.querySelectorAll('.rowCheckbox:checked').length > 0;
        document.getElementById('deleteSelectedBtn').classList.toggle('hidden', !anyChecked);
    }

    function calculateSummary() {
        let totalQty = 0;
        let grandTotal = 0;

        document.querySelectorAll('#itemsTableBody tr').forEach(row => {
            const qtyInput = row.querySelector('.qtyInput');
            if (!qtyInput) return;

            const qty = parseFloat(qtyInput.value) || 0;
            const rate = parseFloat(row.children[8].textContent.trim()) || 0;
            const subtotal = qty * rate;

            totalQty += qty;
            grandTotal += subtotal;

            if (row.children[9]) {
                row.children[9].textContent = subtotal.toFixed(2);
            }
        });

        document.getElementById('totalQty').textContent = totalQty;
        document.getElementById('totalPrice').textContent = grandTotal.toFixed(2);
        document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
    }

    
    document.getElementById('saveBtn').addEventListener('click', function () {
        const ledgerId = document.getElementById('ledgerInput').dataset.id;
        const date = document.getElementById('formDate').value;

        if (!ledgerId || !date) {
            alert("Date and Ledger are required");
            return;
        }

        const items = [...document.querySelectorAll('#itemsTableBody tr')]
            .filter(tr => tr.querySelector('.qtyInput'))
            .map(tr => ({
                item_id: parseInt(tr.dataset.itemId),
                quantity: parseFloat(tr.querySelector('.qtyInput').value),
                price: parseFloat(tr.children[8].textContent.trim()),
            }));

        if (items.length === 0) {
            alert("Please add at least one item");
            return;
        }

        fetch(`{{ route('inwards.store') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                date,
                ledger_id: ledgerId,
                items
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = "{{ route('inwards') }}";
            } else {
                alert("Error: " + data.message);
                location.reload();
            }
        })
        .catch(err => {
            alert("Error saving data");
            console.error(err);
        });
    });






</script>
@endsection
