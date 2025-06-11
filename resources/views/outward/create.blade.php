    @extends('layouts.app')

    @section('content')

    <div class="w-full mx-auto bg-white">
        <div class="flex justify-between items-center border-b px-6 py-4 bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-800">Outwards Entry</h2>
            <button type="button" id="saveBtn"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 flex items-center"
                disabled>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Save
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-6 border-b">
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <div class="relative">
                    <input type="date" id="formDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}" >
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative space-y-1">
                <label class="block text-sm font-medium text-gray-700">Customer</label>
                <div class="relative">
                    <input type="text" id="ledgerInput" placeholder="Search customer..." autocomplete="off"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border bg-white"
                        
                  @if($selectedLedger ?? false)
    value="{{ $selectedLedger->name }}"
    data-id="{{ $selectedLedger->id }}"
    
@endif
                
                >
                    <ul id="ledgerList"
                        class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg max-h-60 overflow-y-auto hidden border border-gray-200 divide-y divide-gray-200"></ul>
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
        </div>

        <div class="px-6 py-4">
            <h3 class="font-semibold text-lg mb-4 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                </svg>
                Outwards Item Details
            </h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barcode</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HSN Code</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
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
                Delete Selected
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
                        <span id="totalPrice" class="text-lg font-semibold text-blue-600">₹0.00</span>
                    </div>
                </div>
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

        if (ledgerInput.dataset.id) {
    selectedLedgerId = ledgerInput.dataset.id;
    checkEnableSave();
}

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
                        const li = document.createElement('li');
                        li.className = 'px-4 py-2 text-sm text-gray-500';
                        li.textContent = 'No customers found';
                        ledgerList.appendChild(li);
                    } else {
                        data.forEach(ledger => {
                            const li = document.createElement('li');
                            li.className = 'px-4 py-2 text-sm hover:bg-blue-50 cursor-pointer flex justify-between items-center';
                            li.innerHTML = `
                                <span>${ledger.name}</span>
                                <span class="text-xs text-gray-500">${ledger.phone || ''}</span>
                            `;
                            li.addEventListener('click', function () {
                                ledgerInput.value = ledger.name;
                                selectedLedgerId = ledger.id;
                                ledgerList.classList.add('hidden');
                                checkEnableSave();
                            });
                            ledgerList.appendChild(li);
                        });
                    }
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
                saveBtn.disabled = true;
                deleteSelectedBtn.classList.add('hidden');
                selectAllCheckbox.checked = false;
                return;
            }

            items.forEach((item, index) => {
                item.entered_qty = item.entered_qty || 1;
                const subtotal = (item.entered_qty * (item.price || 0)).toFixed(2);

                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50';
                tr.innerHTML = `
                    <td class="px-4 py-3 whitespace-nowrap">
                        <input type="checkbox" class="rowCheckbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" data-index="${index}">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${index + 1}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${item.barcode}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.category?.name || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${item.name}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.hsn_code || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                        <input type="number" min="1" max="${item.current_stock}" value="${item.entered_qty}"
                            class="qtyInput w-16 border rounded-md px-2 py-1 text-center border-gray-300 focus:border-blue-500 focus:ring-blue-500" data-index="${index}">
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.unit?.name || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${item.price || 0}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">${subtotal}</td>
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
            totalPrice.textContent = totalPriceVal.toLocaleString('en-IN', {
                style: 'currency',
                currency: 'INR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            document.getElementById('grandTotal').textContent = totalPriceVal.toLocaleString('en-IN', {
                style: 'currency',
                currency: 'INR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
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
                alert('Please select a customer');
                return;
            }

            if (items.length === 0) {
                alert('Please add items before saving.');
                return;
            }

            const originalBtnContent = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;

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
                    saveBtn.innerHTML = originalBtnContent;
                });
        });

        // Initial table update
        updateTable();
    });
    </script>
    @endsection