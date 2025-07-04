@extends('layouts.app')

@section('content')

<div class="w-full mx-auto bg-white">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b px-4 sm:px-6 py-4 bg-gray-50">
        <h2 class="text-xl font-semibold text-gray-800 mb-2 sm:mb-0">Inwards Entry</h2>
        <button type="button" id="saveBtn"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 flex items-center w-full sm:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Save
        </button>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 p-4 sm:p-6 border-b">
        <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Date</label>
            <div class="relative">
                <input type="date" id="formDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border" max="{{ now()->format('Y-m-d') }}">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="relative space-y-1">
            <label class="block text-sm font-medium text-gray-700">Supplier</label>
            <div class="relative">
                <input type="text" id="ledgerInput" placeholder="Search supplier..." autocomplete="off"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border bg-white"
                    @if(isset($selectedLedger))
                    value="{{ $selectedLedger->name }}"
                    data-id="{{ $selectedLedger->id }}"
                    disabled
                    @endif>
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

    <div class="px-4 sm:px-6 py-4">
        <h3 class="font-semibold text-lg mb-4 text-gray-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
            </svg>
            Inwards Item Details
        </h3>
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">
                            <input type="checkbox" id="selectAllCheckbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th scope="col" class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th scope="col" class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barcode</th>
                        <th scope="col" class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Category</th>
                        <th scope="col" class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                        <th scope="col" class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">HSN Code</th>
                        <th scope="col" class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        <th scope="col" class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Unit</th>
                        <th scope="col" class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                        <th scope="col" class="px-2 sm:px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody id="itemsTableBody" class="bg-white divide-y divide-gray-200">
                    <tr id="noDataRow">
                        <td colspan="10" class="px-4 sm:px-6 py-4 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="mt-2">No items added yet</p>
                                <p class="text-xs text-gray-500 mt-1">Start scanning barcodes or add items manually</p>
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
            class="mt-4 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 hidden w-full sm:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            Delete Selected
        </button>
    </div>

    <div class="mt-2 border-t px-4 sm:px-6 py-4 bg-gray-50">
        <h3 class="font-semibold mb-3 text-gray-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            Summary
        </h3>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">
            <div class="bg-white p-3 sm:p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Total Quantity</span>
                    <span id="totalQty" class="text-lg font-semibold text-gray-800">0</span>
                </div>
            </div>
            <div class="bg-white p-3 sm:p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Total Amount</span>
                    <span id="totalPrice" class="text-lg font-semibold text-blue-600">₹0.00</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('formDate').valueAsDate = new Date();
    
    let itemCount = 0;

    // Supplier search functionality
    document.getElementById('ledgerInput').addEventListener('input', function() {
        let query = this.value.trim();
        if (query.length < 2) {
            document.getElementById('ledgerList').classList.add('hidden');
            return;
        }

        fetch(`/supplier/${query}`)
            .then(res => res.json())
            .then(data => {
                let list = document.getElementById('ledgerList');
                list.innerHTML = '';
                
                if (data.length === 0) {
                    let li = document.createElement('li');
                    li.className = 'px-4 py-2 text-sm text-gray-500';
                    li.textContent = 'No suppliers found';
                    list.appendChild(li);
                } else {
                    data.forEach(ledger => {
                        let li = document.createElement('li');
                        li.className = 'px-4 py-2 text-sm hover:bg-blue-50 cursor-pointer flex justify-between items-center';
                        li.innerHTML = `
                            <span>${ledger.name}</span>
                            <span class="text-xs text-gray-500">${ledger.phone || ''}</span>
                        `;
                        li.dataset.id = ledger.id;
                        li.onclick = () => {
                            document.getElementById('ledgerInput').value = ledger.name;
                            document.getElementById('ledgerInput').dataset.id = ledger.id;
                            list.classList.add('hidden');
                            document.getElementById('barcodeInput').focus();
                        };
                        list.appendChild(li);
                    });
                }
                list.classList.remove('hidden');
            })
            .catch(err => {
                console.error('Error fetching suppliers:', err);
            });
    });

    document.addEventListener('click', function(e) {
        if (!document.getElementById('ledgerInput').contains(e.target)) {
            document.getElementById('ledgerList').classList.add('hidden');
        }
    });

    document.getElementById('barcodeInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            let barcode = this.value.trim();
            if (!barcode) return;

            addItemByBarcode(barcode);
            this.value = '';
        }
    });

    function addItemByBarcode(barcode) {
        let existingRow = [...document.querySelectorAll('#itemsTableBody tr')].find(tr => {
            return tr.children[2]?.textContent === barcode && tr.id !== 'noDataRow';
        });
        
        if (existingRow) {
            let qtyInput = existingRow.querySelector('.qtyInput');
            qtyInput.value = parseInt(qtyInput.value) + 1;
            qtyInput.dispatchEvent(new Event('input'));
            
            existingRow.classList.add('bg-blue-50');
            setTimeout(() => existingRow.classList.remove('bg-blue-50'), 500);
            
            return;
        }

        fetch(`/inward/${barcode}`)
            .then(res => {
                if (!res.ok) throw new Error('Item not found');
                return res.json();
            })
            .then(item => {
                document.getElementById('noDataRow')?.remove();
                
                itemCount++;
                let row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.dataset.itemId = item.id;
                row.innerHTML = `
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap">
                        <input type="checkbox" class="rowCheckbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    </td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-900">${itemCount}</td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${item.barcode}</td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">${item.category?.name || '-'}</td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-900">${item.name}</td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">${item.hsn_code || '-'}</td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                        <input type="number" value="1" min="1" class="qtyInput w-16 border rounded-md px-2 py-1 text-center border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">${item.unit?.name || '-'}</td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-900">${item.price}</td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">0.00</td>
                `;
                
                document.getElementById('itemsTableBody').appendChild(row);
                
                calculateSummary();
                
                row.classList.add('bg-green-50');
                setTimeout(() => row.classList.remove('bg-green-50'), 500);
            })
            .catch(err => {
                alert(err.message);
                console.error('Error fetching item:', err);
            });
    }

    document.getElementById('itemsTableBody').addEventListener('input', function(e) {
        if (e.target.classList.contains('qtyInput')) {
            calculateSummary();
        }
    });

    document.getElementById('selectAllCheckbox').addEventListener('change', function() {
        document.querySelectorAll('.rowCheckbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleDeleteBtn();
    });

    document.getElementById('itemsTableBody').addEventListener('change', function(e) {
        if (e.target.classList.contains('rowCheckbox')) {
            const allChecked = document.querySelectorAll('.rowCheckbox:checked').length === document.querySelectorAll('.rowCheckbox').length;
            document.getElementById('selectAllCheckbox').checked = allChecked && document.querySelectorAll('.rowCheckbox').length > 0;
            toggleDeleteBtn();
        }
    });

    document.getElementById('deleteSelectedBtn').addEventListener('click', function() {
        const selectedRows = document.querySelectorAll('.rowCheckbox:checked');
        if (selectedRows.length === 0) return;
        
        if (!confirm(`Are you sure you want to delete ${selectedRows.length} selected item(s)?`)) {
            return;
        }
        
        selectedRows.forEach(chk => {
            chk.closest('tr').remove();
        });
        
        calculateSummary();
        toggleDeleteBtn();
        
        document.getElementById('selectAllCheckbox').checked = false;
        
        if (!document.querySelectorAll('#itemsTableBody tr').length || 
            (document.querySelectorAll('#itemsTableBody tr').length === 1 && document.getElementById('noDataRow'))) {
            document.getElementById('itemsTableBody').innerHTML = `
                <tr id="noDataRow">
                    <td colspan="10" class="px-4 sm:px-6 py-4 text-center text-sm text-gray-500">
                        <div class="flex flex-col items-center justify-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-2">No items added yet</p>
                            <p class="text-xs text-gray-500 mt-1">Start scanning barcodes or add items manually</p>
                        </div>
                    </td>
                </tr>`;
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
            if (row.id === 'noDataRow') return;
            
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
        document.getElementById('totalPrice').textContent = grandTotal.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById('grandTotal').textContent = grandTotal.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Save functionality
    document.getElementById('saveBtn').addEventListener('click', function() {
        const ledgerId = document.getElementById('ledgerInput').dataset.id;
        const date = document.getElementById('formDate').value;

        if (!ledgerId || !date) {
            alert("Please select a supplier and date");
            return;
        }

        const items = [...document.querySelectorAll('#itemsTableBody tr')]
            .filter(tr => tr.id !== 'noDataRow' && tr.querySelector('.qtyInput'))
            .map(tr => ({
                item_id: parseInt(tr.dataset.itemId),
                quantity: parseFloat(tr.querySelector('.qtyInput').value),
                price: parseFloat(tr.children[8].textContent.trim()),
            }));

        if (items.length === 0) {
            alert("Please add at least one item");
            return;
        }

        // Show loading state
        const saveBtn = document.getElementById('saveBtn');
        const originalText = saveBtn.innerHTML;
        saveBtn.disabled = true;
        saveBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
        `;

        fetch(`{{ route('inwards.store') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                date,
                ledger_id: ledgerId,
                items
            })
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) {
                throw new Error(data.message || 'Failed to save data');
            }
            return data;
        })
        .then(data => {
            alert(data.message || 'Inward entry saved successfully');
            window.location.href = "{{ route('inwards') }}";
        })
        .catch(err => {
            alert("Error: " + err.message);
            console.error('Error saving data:', err);
        })
        .finally(() => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalText;
        });
    });

    document.getElementById('manualAddBtn').addEventListener('click', function() {
        alert('Manual add functionality will be implemented here');
    });
</script>

@if(isset($selectedItem))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add the selected item to the table automatically
        const selectedItem = @json($selectedItem);
        
        // Remove the "no data" row if it exists
        document.getElementById('noDataRow')?.remove();
        
        // Add the item to the table
        itemCount++;
        let row = document.createElement('tr');
        row.className = 'hover:bg-gray-50';
        row.dataset.itemId = selectedItem.id;
        row.innerHTML = `
            <td class="px-2 sm:px-4 py-3 whitespace-nowrap">
                <input type="checkbox" class="rowCheckbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            </td>
            <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-900">${itemCount}</td>
            <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${selectedItem.barcode || '-'}</td>
            <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">${selectedItem.category?.name || '-'}</td>
            <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-900">${selectedItem.name}</td>
            <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">${selectedItem.hsn_code || '-'}</td>
            <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                <input type="number" value="1" min="1" class="qtyInput w-16 border rounded-md px-2 py-1 text-center border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </td>
            <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">${selectedItem.unit?.name || '-'}</td>
            <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-900">${selectedItem.price || 0}</td>
            <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">0.00</td>
        `;
        
        document.getElementById('itemsTableBody').appendChild(row);
        calculateSummary();
        
        // Highlight the newly added row
        row.classList.add('bg-green-50');
        setTimeout(() => row.classList.remove('bg-green-50'), 500);
        
        // Focus on the quantity input of the newly added item
        const qtyInput = row.querySelector('.qtyInput');
        if (qtyInput) {
            qtyInput.focus();
            qtyInput.select();
        }
    });
</script>
@endif

@endsection