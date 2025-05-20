    @extends('layouts.app')

    @section('content')
    <div class="w-full mx-auto bg-white px-4 py-6">

        <div class="flex justify-between items-center border-b px-6 py-4">
            <h2 class="text-xl font-semibold">Inwards Entry</h2>
            <button type="button" id="saveBtn" disabled
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                Save
            </button>
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
                <ul id="ledgerList" class="absolute z-10 w-full border mt-1 bg-white rounded shadow max-h-48 overflow-y-auto hidden"></ul>
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
                    </tr>
                </thead>
                <tbody id="itemsTableBody" class="text-center">

                    <tr id="noDataRow">
                        <td class="px-3 py-3" colspan="9">No Data</td> 
                    </tr>
        </tbody>
        </table>
        <button type="button" id="deleteSelectedBtn" class="mt-4 bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600 hidden">
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
                        <td id="totalPrice" class="border px-2 py-2">0.00</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const allItems = @json($items);

            let selectedItems = [];
            let selectedLedger = null;
            let ledgerFetchTimeout = null;

            const barcodeInput = document.getElementById('barcodeInput');
            const itemsTableBody = document.getElementById('itemsTableBody');
            const noDataRow = document.getElementById('noDataRow');
            const totalQtyEl = document.getElementById('totalQty');
            const totalPriceEl = document.getElementById('totalPrice');
            const saveBtn = document.getElementById('saveBtn');
            const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
            const ledgerInput = document.getElementById('ledgerInput');
            const ledgerList = document.getElementById('ledgerList');
            const formDate = document.getElementById('formDate');




            async function fetchLedgers(query) {
                if (!query) return [];
                try {
                    const response = await fetch(`/ledger/${encodeURIComponent(query)}`);
                    if (!response.ok) return [];
                    const data = await response.json();
                    return data;
                } catch {
                    return [];
                }
            }

            ledgerInput.addEventListener('input', () => {
                clearTimeout(ledgerFetchTimeout);
                const query = ledgerInput.value.trim();
                ledgerFetchTimeout = setTimeout(async () => {
                    ledgerList.innerHTML = '';
                    selectedLedger = null;
                    updateSaveButton();
                    
                    
                    if (!query) {
                        ledgerList.classList.add('hidden');
                        return;
                    }

                    const results = await fetchLedgers(query);
                    if (results.length === 0) {
                        ledgerList.classList.add('hidden');
                        return;
                    }

                    results.forEach(ledger => {
                        const li = document.createElement('li');
                        li.textContent = ledger.name;
                        li.classList.add('px-3', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
                        li.addEventListener('click', () => {
                            ledgerInput.value = ledger.name;
                            selectedLedger = ledger;
                            ledgerList.classList.add('hidden');
                            updateSaveButton();
                        });
                        ledgerList.appendChild(li);
                    });
                    ledgerList.classList.remove('hidden');
                }, 300);
            });

            document.addEventListener('click', (e) => {
                if (!ledgerList.contains(e.target) && e.target !== ledgerInput) {
                    ledgerList.classList.add('hidden');
                }
            });


            function formatPrice(value) {
                return new Intl.NumberFormat('en-IN', { minimumFractionDigits: 2 }).format(value);
            }
            
            function updateSummary() {
                const totalQty = selectedItems.reduce((sum, i) => sum + i.qty, 0);
                const totalPrice = selectedItems.reduce((sum, i) => sum + (i.qty * i.price), 0);
                totalQtyEl.textContent = totalQty;
                totalPriceEl.textContent = formatPrice(totalPrice);
            }

            function updateSaveButton() {
                const canSave = selectedItems.length > 0 &&
                selectedItems.every(i => i.qty >= 1 && i.qty <= i.current_stock) &&
                selectedLedger !== null;
                saveBtn.disabled = !canSave;
            }

            function renderItems() {
                itemsTableBody.innerHTML = '';

                if (selectedItems.length === 0) {
                    itemsTableBody.appendChild(noDataRow);
                    deleteSelectedBtn.style.display = 'none';
                    updateSaveButton();
                    updateSummary();
                    return;
                }
                deleteSelectedBtn.style.display = 'inline-block';

                selectedItems.forEach((item, index) => {
                    const tr = document.createElement('tr');

                    const tdCheckbox = document.createElement('td');
                    tdCheckbox.classList.add('border', 'px-2', 'py-2');
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.checked = item.selected || false;
                    checkbox.addEventListener('change', (e) => {
                        item.selected = e.target.checked;
                        updateDeleteButton();
                    });
                    tdCheckbox.appendChild(checkbox);
                    tr.appendChild(tdCheckbox);

                    const tdSlno = document.createElement('td');
                    tdSlno.classList.add('border', 'px-2', 'py-2');
                    tdSlno.textContent = index + 1;
                    tr.appendChild(tdSlno);

                    const tdBarcode = document.createElement('td');
                    tdBarcode.classList.add('border', 'px-2', 'py-2');
                    tdBarcode.textContent = item.barcode;
                    tr.appendChild(tdBarcode);

                    const tdCategory = document.createElement('td');
                    tdCategory.classList.add('border', 'px-2', 'py-2');
                    tdCategory.textContent = item.category.name;
                    tr.appendChild(tdCategory);

                    const tdName = document.createElement('td');
                    tdName.classList.add('border', 'px-2', 'py-2');
                    tdName.textContent = item.name;
                    tr.appendChild(tdName);

                    const tdHSN = document.createElement('td');
                    tdHSN.classList.add('border', 'px-2', 'py-2');
                    tdHSN.textContent = item.hsn_code;
                    tr.appendChild(tdHSN);

                    const tdQty = document.createElement('td');
                    tdQty.classList.add('border', 'px-2', 'py-2');
                    const qtyInput = document.createElement('input');
                    qtyInput.type = 'number';
                    qtyInput.min = 1;
                    qtyInput.max = item.current_stock;
                    qtyInput.value = item.qty;
                    qtyInput.classList.add('w-20', 'border', 'rounded', 'text-center');
                    qtyInput.addEventListener('input', (e) => {
                        let val = parseInt(e.target.value, 10);
                        if (isNaN(val) || val < 1) val = 1;
                        if (val > item.current_stock) val = item.current_stock;
                        e.target.value = val;
                        item.qty = val;
                        updateSaveButton();
                        updateSummary();
                    });
                    tdQty.appendChild(qtyInput);
                    tr.appendChild(tdQty);

                    const tdUnit = document.createElement('td');
                    tdUnit.classList.add('border', 'px-2', 'py-2');
                    tdUnit.textContent = item.unit.abbreviation;
                    tr.appendChild(tdUnit);

                    const tdRate = document.createElement('td');
                    tdRate.classList.add('border', 'px-2', 'py-2');
                    tdRate.textContent = formatPrice(item.price);
                    tr.appendChild(tdRate);

                    itemsTableBody.appendChild(tr);
                });

                updateSaveButton();
                updateSummary();
            }

            function updateDeleteButton() {
                const anySelected = selectedItems.some(i => i.selected);
                deleteSelectedBtn.style.display = anySelected ? 'inline-block' : 'none';
            }

            deleteSelectedBtn.addEventListener('click', () => {
                selectedItems = selectedItems.filter(i => !i.selected);
                renderItems();
                updateDeleteButton();
            });

            barcodeInput.addEventListener('keydown', async (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const barcode = barcodeInput.value.trim();
                    if (!barcode) return;

                    try {
                        const response = await fetch(`/items/${encodeURIComponent(barcode)}`);
                        if (!response.ok) throw new Error('Item not found');
                        const foundItem = await response.json();

                        const existingItem = selectedItems.find(i => i.barcode === barcode);
                        if (existingItem) {
                            if (existingItem.qty < existingItem.current_stock) {
                                existingItem.qty++;
                            } else {
                                alert('Reached max stock quantity for this item.');
                            }
                        } else {
                            selectedItems.push({
                                ...foundItem,
                                qty: 1,
                                selected: false
                            });
                        }
                        renderItems();
                        barcodeInput.value = '';
                    } catch (error) {
                        alert('Item not found for barcode: ' + barcode);
                        barcodeInput.value = '';
                    }
                }
            });

            saveBtn.addEventListener('click', () => {
                if (!selectedLedger) {
                    alert('Please select a ledger');
                    return;
                }
                
                if (selectedItems.length === 0) {
                    alert('No items to save');
                    return;
                }
             
                const payload = {
    date: formDate.value,
    ledger_id: selectedLedger.id,
    items: selectedItems.map(i => ({
        item_id: i.id,
        quantity: i.qty,  
        price: i.price
    }))
};

                saveBtn.disabled = true;
                saveBtn.textContent = 'Saving...';

                fetch("{{ route('inwards.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                }).then(res => {
                    if (!res.ok) throw new Error('Failed to save');
                    return res.json();
                }).then(data => {
                    alert('Saved successfully!');
                    selectedItems = [];
                    selectedLedger = null;
                    ledgerInput.value = '';
                    renderItems();
                    updateSaveButton();
                    saveBtn.textContent = 'Save';
                    barcodeInput.focus();
                }).catch(err => {
                    alert('Error saving data.');
                    saveBtn.disabled = false;
                    saveBtn.textContent = 'Save';
                });
            });

            // Initial render
            renderItems();
        })();
    </script>
    @endsection
