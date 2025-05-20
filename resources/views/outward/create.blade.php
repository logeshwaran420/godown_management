{{-- @extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white px-4 py-6"
     x-data="storeForm({{ $items->toJson() }}, {{ $ledgers->toJson() }})">

    <!-- Header -->
    <div class="flex justify-between items-center border-b px-6 py-4">
        <h2 class="text-xl font-semibold">Outward Entry</h2>
        <button type="button" :disabled="!canSave" @click="saveForm"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
            Save
        </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 border-b gap-4 p-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" x-model="formDate" class="mt-1 block w-full border rounded px-3 py-2">
        </div>

        <div class="relative">
            <label class="block text-sm font-medium text-gray-700">Ledger</label>
            <input type="text" x-model="ledgerQuery" @input="filterLedgers" @focus="showLedgerList = true"
                   @click.away="showLedgerList = false"
                   class="mt-1 block w-full border rounded px-3 py-2 bg-white"
                   placeholder="Ledger">
            <ul x-show="showLedgerList && filteredLedgers.length"
                class="absolute z-10 w-full border mt-1 bg-white rounded shadow max-h-48 overflow-y-auto">
                <template x-for="ledger in filteredLedgers" :key="ledger.id">
                    <li @click="selectLedger(ledger)"
                        class="px-3 py-2 hover:bg-gray-100 cursor-pointer" x-text="ledger.name"></li>
                </template>
            </ul>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Barcode</label>
            <input type="text" id="barcodeInput" placeholder="Enter BarCode"
                x-model="barInput" @change="addItemByBarcode"
                class="mt-1 block w-full border rounded px-3 py-2" x-ref="barcodeInput">
        </div>
    </div>

    <!-- Items Table -->
    <div class="px-6 pb-6">
        <h3 class="font-semibold text-lg mb-4">Outward Item Details</h3>
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
            <tbody class="text-center">
                <template x-for="(item, index) in selectedItems" :key="item.id">
                    <tr>
                        <td class="border px-2 py-2"><input type="checkbox" x-model="item.selected"></td>
                        <td class="border px-2 py-2" x-text="index + 1"></td>
                        <td class="border px-2 py-2" x-text="item.barcode"></td>
                        <td class="border px-2 py-2" x-text="item.category.name ?? '-'"></td>
                        <td class="border px-2 py-2" x-text="item.name"></td>
                        <td class="border px-2 py-2" x-text="item.hsn_code"></td>
                        <td class="border px-2 py-2"><input type="number" min="1"
                            :max="item.current_stock" x-model.number="item.qty"
                            @input="validateQty(item)" class="border rounded px-1 w-16 text-center"></td>
                        <td class="border px-2 py-2" x-text="item.unit.abbreviation"></td>
                        <td class="border px-2 py-2" x-text="formatPrice(item.price)"></td>
                    </tr>
                </template>
                <tr x-show="selectedItems.length === 0">
                    <td class="px-3 py-3" colspan="9">No Data</td>
                </tr>
            </tbody>
        </table>

        <button type="button" x-show="selectedItems.some(i => i.selected)" @click="deleteSelected"
            class="mt-4 bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600">
            Delete
        </button>
    </div>
    <div class="mt-6 border-t px-6 py-4">
        <h3 class="font-semibold mb-2">Summary</h3>
        <div class="overflow-x-auto">
            <table class="min-w-max text-sm border">
                <tr>
                    <th class="border px-2 py-2 text-left">Total Qty</th>
                    <td class="border px-2 py-2" x-text="totalQty"></td>
                </tr>
                <tr>
                    <th class="border px-2 py-2 text-left">Total Amount</th>
                    <td class="border px-2 py-2" x-text="formatPrice(totalPrice)"></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script>
function storeForm(items, ledgers) {
    return {
        allItems: items,
        selectedItems: [],
        barInput: '',
        formDate: '{{ \Carbon\Carbon::now()->format('Y-m-d') }}',

        
        allLedgers: ledgers,
        ledgerQuery: '',
        filteredLedgers: [],
        showLedgerList: false,
        selectedId: null,
        
        init() {
            this.$nextTick(() => this.$refs.barcodeInput.focus());
        },

        filterLedgers() {
            this.filteredLedgers = this.allLedgers.filter(i => i.name.toLowerCase().includes(this.ledgerQuery.toLowerCase()));
        },
        selectLedger(ledger) {
            this.ledgerQuery = ledger.name;
            this.selectedId = ledger.id;
            this.showLedgerList = false;
        },

   
        addItemByBarcode() {
            let barcode = this.barInput.trim();
            if (!barcode) return;
            
            let existing = this.selectedItems.find(i => i.barcode === barcode);
            if (existing) {
                if (existing.qty < existing.current_stock) {
                    existing.qty += 1;
                } else {
                    existing.qty = existing.current_stock;
                }
            } else {
                let item = this.allItems.find(i => i.barcode === barcode && i.current_stock > 0);
                if (item) {
                    let safeQty = Math.min(1, item.current_stock);
                    this.selectedItems.push({ ...item, qty: safeQty, selected: false });
                }
            }

            this.barInput = '';
            this.$nextTick(() => this.$refs.barcodeInput.focus());
        },
        deleteSelected() {
            this.selectedItems = this.selectedItems.filter(i => !i.selected);
        },
        validateQty(item) {
            if (item.qty > item.current_stock) {
                item.qty = item.current_stock;
            } else if (item.qty < 1) {
                item.qty = 1;
            }
        },
        get totalQty() {
            return this.selectedItems.reduce((sum, i) => sum + i.qty, 0);
        },
        get totalPrice() {
            return this.selectedItems.reduce((sum, i) => sum + (i.qty * i.price), 0);
        },
        get canSave() {
            return this.selectedItems.length > 0 &&
                   this.selectedItems.every(i => i.qty >= 1 && i.qty <= i.current_stock) &&
                   this.selectedId != null;
        },
        formatPrice(value) {
            if (value == null) return '0.00';
            return new Intl.NumberFormat('en-IN', { minimumFractionDigits: 2 }).format(value);
        },
        
 saveForm() {
    fetch('{{ route('outwards.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            date: this.formDate,
            ledger_id: this.selectedId,
            warehouse_id: "{{ session('warehouse_id') }}",
            invoice_no: null,
            items: this.selectedItems.map(i => ({
                item_id: i.id,
                quantity: i.qty, 
                price: i.price
            }))
        })
    })
    .then(response => {
        if (!response.ok) {
            console.error('Server Error:', response);
            throw new Error(`HTTP error ${response.status}`);
        }
        return response.json();
    })
    .then(result => {
        alert(result.message);
          if (result.success) {
            window.location.href = "{{ route('outwards') }}"; 
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    });
}
}
}
</script>
@endsection --}}

{{-- <!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <title>Barcode & Ledger Search (API)</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 2rem auto; }
        label, input, button { display: block; margin: 0.5rem 0; }
        .item-details, .ledger-results { background: #f0f0f0; padding: 1rem; margin-top: 1rem; }
        .error { color: red; margin-top: 1rem; }
        ul { list-style: none; padding-left: 0; margin-top: 0.5rem; }
        ul li { padding: 0.3rem 0; border-bottom: 1px solid #ccc; cursor: pointer; }
    </style>
</head>


<body>
    <h1>Search Item by Barcode (API)</h1>
    <form id="barcode-form">
        <label for="barcode">Enter Barcode:</label>
        <input type="text" id="barcode" name="barcode" required />
        <button type="submit">Search</button>
    </form>
    <div id="barcode-result"></div>
    <hr>
    <h1>Search Customer Ledger (Live Search)</h1>
    <label for="ledger-search">Type Customer Name:</label>
    <input type="text" id="ledger-search" autocomplete="off" placeholder="Start typing..." />
    <div id="ledger-result"></div>

    <script>
       const barcodeForm = document.getElementById('barcode-form');
       const barcodeResult = document.getElementById('barcode-result');

        barcodeForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            barcodeResult.innerHTML = 'Searching...';

            const barcode = document.getElementById('barcode').value.trim();
            if (!barcode) {
                barcodeResult.innerHTML = '<p class="error">Please enter a barcode.</p>';
                return;
            }

            try {
                const response = await fetch(`/outward/${encodeURIComponent(barcode)}`);
                if (!response.ok) {
                    const errorData = await response.json();
                    barcodeResult.innerHTML = `<p class="error">${errorData.message || 'Item not found'}</p>`;
                    return;
                }

                const item = await response.json();

                barcodeResult.innerHTML = `
                    <div class="item-details">
                        <h2>Item Details</h2>
                        <p><strong>Name:</strong> ${item.name}</p>
                        <p><strong>Category:</strong> ${item.category?.name || 'N/A'}</p>
                        <p><strong>Unit:</strong> ${item.unit?.name || 'N/A'}</p>
                        <p><strong>Current Stock:</strong> ${item.current_stock}</p>
                        <p><strong>Barcode:</strong> ${item.barcode}</p>
                    </div>
                `;
            } catch (error) {
                barcodeResult.innerHTML = `<p class="error">Error: ${error.message}</p>`;
            }
        });

        const ledgerInput = document.getElementById('ledger-search');
        const ledgerResult = document.getElementById('ledger-result');
        let ledgerTimeout = null;

        ledgerInput.addEventListener('input', () => {
            const query = ledgerInput.value.trim();
            ledgerResult.innerHTML = '';

            if (query.length < 2) {
                return; 
            
            }

            clearTimeout(ledgerTimeout);
            ledgerTimeout = setTimeout(async () => {
                ledgerResult.innerHTML = 'Searching...';

                try {
                    const response = await fetch(`/customer/${encodeURIComponent(query)}`);
                    if (!response.ok) {
                        ledgerResult.innerHTML = '<p class="error">Failed to fetch customers.</p>';
                        return;
                    }

                    const customers = await response.json();

                    if (customers.length === 0) {
                        ledgerResult.innerHTML = '<p>No customers found.</p>';
                        return;
                    }

                    let list = '<ul>';
                    customers.forEach(cust => {
                        list += `<li>${cust.name} (ID: ${cust.id})</li>`;
                    });
                    list += '</ul>';

                    ledgerResult.innerHTML = list;
                } catch (err) {
                    ledgerResult.innerHTML = `<p class="error">Error: ${err.message}</p>`;
                }
            }, 300); 
        });
    </script>

</body>
</html> --}}


 @extends('layouts.app')

@section('content')



<div class="w-full mx-auto bg-white px-4 py-6 max-w-7xl">

    <div class="flex justify-between items-center border-b px-6 py-4">
        <h2 class="text-xl font-semibold">Inwards Entry</h2>
        <button type="button" id="saveBtn" disabled
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
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
            <ul id="ledgerList" class="absolute z-10 w-full border mt-1 bg-white rounded shadow max-h-48 overflow-y-auto hidden"></ul>
        </div>
        <div>
            <label for="barcodeInput" class="block text-sm font-medium text-gray-700">Barcode</label>
            <input type="text" id="barcodeInput" name="barcodeInput" placeholder="Enter Barcode"
                   class="mt-1 block w-full border rounded px-3 py-2" autofocus>
        </div>
    </div>

    <div class="px-6 py-2 pb-6">
        <h3 class="font-semibold text-lg mb-4">Inwards Item Details</h3>
        <table class="w-full border text-sm table-fixed">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-2 w-10"></th>
                    <th class="border px-2 py-2 w-10">Slno</th>
                    <th class="border px-2 py-2 w-32">Bar Code</th>
                    <th class="border px-2 py-2 w-28">Category</th>
                    <th class="border px-2 py-2">Item</th>
                    <th class="border px-2 py-2 w-24">HSN Code</th>
                    <th class="border px-2 py-2 w-16">Qty</th>
                    <th class="border px-2 py-2 w-20">Unit</th>
                    <th class="border px-2 py-2 w-20">Rate</th>
                </tr>
            </thead>
            <tbody id="itemsTableBody" class="text-center">
                <tr id="noDataRow">
                    <td class="px-3 py-3" colspan="9">No Data</td> 
                </tr> 
            </tbody>
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
    (function() {

        const ledgerInput = document.getElementById('ledgerInput');
        const ledgerList = document.getElementById('ledgerList');
        const barcodeInput = document.getElementById('barcodeInput');
        const itemsTableBody = document.getElementById('itemsTableBody');
        const noDataRow = document.getElementById('noDataRow');
        const totalQtyEl = document.getElementById('totalQty');
        const totalPriceEl = document.getElementById('totalPrice');
        const saveBtn = document.getElementById('saveBtn');
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

        let selectedItems = [];
        let selectedLedger = null;
        let ledgerFetchTimeout = null;

        // URLs from Laravel routes
        const ledgerSearchUrlBase = '/customer/';
        const inwardBarcodeUrlBase = '/outward/';

        // Fetch ledger list by query
        async function fetchLedgers(query) {
            if (!query) return [];
            try {
                const response = await fetch(ledgerSearchUrlBase + encodeURIComponent(query));
                if (!response.ok) return [];
                return await response.json();
            } catch {
                return [];
            }
        }

        // Fetch item info by barcode
        async function fetchItemByBarcode(barcode) {
            if (!barcode) return null;
            try {
                const response = await fetch(inwardBarcodeUrlBase + encodeURIComponent(barcode));
                if (!response.ok) throw new Error('Item not found');
                return await response.json();
            } catch {
                return null;
            }
        }

        // Ledger input autocomplete
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

        // Hide ledger list if clicking outside
        document.addEventListener('click', (e) => {
            if (!ledgerList.contains(e.target) && e.target !== ledgerInput) {
                ledgerList.classList.add('hidden');
            }
        });

        // Barcode input enter key handler
        barcodeInput.addEventListener('keydown', async (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const barcode = barcodeInput.value.trim();
                if (!barcode) return;

                const foundItem = await fetchItemByBarcode(barcode);
                if (!foundItem) {
                    alert('Item not found in this warehouse.');
                    barcodeInput.value = '';
                    return;
                }

                // Check if item already added
                const existingItem = selectedItems.find(i => i.barcode === barcode);
                if (existingItem) {
                    // Optional: check max stock limit if needed
                    existingItem.qty++;
                } else {
                    // Add new item with qty=1
                    selectedItems.push({
                        ...foundItem,
                        qty: 1,
                        selected: false
                    });
                }

                renderItems();
                barcodeInput.value = '';
            }
        });

        // Update save button enabled state
        function updateSaveButton() {
            saveBtn.disabled = !selectedLedger || selectedItems.length === 0;
        }

        // Render items table and summary
        function renderItems() {
            itemsTableBody.innerHTML = '';
            let totalQty = 0;
            let totalPrice = 0;

            if (selectedItems.length === 0) {
                // Clone noDataRow to avoid removing it from DOM
                itemsTableBody.appendChild(noDataRow.cloneNode(true));
                deleteSelectedBtn.classList.add('hidden');
                updateSaveButton();
                return;
            }

            deleteSelectedBtn.classList.remove('hidden');

            selectedItems.forEach((item, index) => {
                totalQty += item.qty;
                totalPrice += item.qty * item.rate;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="border px-2 py-1">
                        <input type="checkbox" class="itemCheckbox" data-index="${index}">
                    </td>
                    <td class="border px-2 py-1">${index + 1}</td>
                    <td class="border px-2 py-1">${item.barcode}</td>
                    <td class="border px-2 py-1">${item.category?.name || '-'}</td>
                    <td class="border px-2 py-1">${item.name}</td>
                    <td class="border px-2 py-1">${item.hsn_code}</td>
                    <td class="border px-2 py-1">
                        <input type="number" min="1" class="qtyInput border rounded px-1 w-16 text-center" 
                               data-index="${index}" value="${item.qty}">
                    </td>
                    <td class="border px-2 py-1">${item.unit?.name || '-'}</td>
                    <td class="border px-2 py-1">${item.rate.toFixed(2)}</td>
                `;
                itemsTableBody.appendChild(tr);
            });

            totalQtyEl.textContent = totalQty;
            totalPriceEl.textContent = totalPrice.toFixed(2);

            updateSaveButton();
        }

        // Event delegation for qty inputs and checkboxes
        itemsTableBody.addEventListener('input', e => {
            if (e.target.classList.contains('qtyInput')) {
                const index = parseInt(e.target.dataset.index);
                let val = parseInt(e.target.value);
                if (isNaN(val) || val < 1) val = 1;

                selectedItems[index].qty = val;
                renderItems();
            }
        });

        itemsTableBody.addEventListener('change', e => {
            if (e.target.classList.contains('itemCheckbox')) {
                const index = parseInt(e.target.dataset.index);
                selectedItems[index].selected = e.target.checked;

                // Show or hide delete button
                const anySelected = selectedItems.some(item => item.selected);
                deleteSelectedBtn.style.display = anySelected ? 'inline-block' : 'none';
            }
        });

        // Delete selected items on click
        deleteSelectedBtn.addEventListener('click', () => {
            selectedItems = selectedItems.filter(item => !item.selected);
            renderItems();
            deleteSelectedBtn.style.display = 'none';
        });

        // Save button click handler
        saveBtn.addEventListener('click', () => {
            if (!selectedLedger) {
                alert('Please select a ledger.');
                return;
            }
            if (selectedItems.length === 0) {
                alert('No items added.');
                return;
            }

            // Example data payload, customize to your backend API requirements
            const payload = {
                date: document.getElementById('formDate').value,
                ledger_id: selectedLedger.id,
                items: selectedItems.map(i => ({
                    item_id: i.id,
                    qty: i.qty,
                    rate: i.rate,
                })),
            };

            // POST to your backend API to save inward (adjust URL and method)
            fetch('/api/inwards', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(res => {
                if (!res.ok) throw new Error('Failed to save');
                return res.json();
            })
            .then(data => {
                alert('Saved successfully!');
                // Reset form & data
                selectedItems = [];
                selectedLedger = null;
                ledgerInput.value = '';
                barcodeInput.value = '';
                renderItems();
                updateSaveButton();
            })
            .catch(err => {
                alert('Error saving data: ' + err.message);
            });
        });

        // Initialize with no data row visible
        renderItems();

    })();
</script> 

@endsection