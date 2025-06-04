 @extends('layouts.app')

@section('content')
<div class="w-full mx-auto bg-white">
    <div class="flex justify-between items-center border-b px-6 py-4 bg-gray-50">
        <h2 class="text-xl font-semibold text-gray-800">Edit Outward Entry</h2>
        <div class="flex space-x-2">
            <a href="{{ route('outwards') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                Cancel
            </a>
            <button type="submit" form="outwardForm" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Save Changes
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('outwards.update', $outward->id) }}" id="outwardForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-6 border-b">
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Date*</label>
                <input type="date" name="date" value="{{ $outward->date }}" max="{{ date('Y-m-d') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border">
            </div>

            <div class="relative space-y-1">
                <label class="block text-sm font-medium text-gray-700">Ledger*</label>
                <select name="ledger_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border bg-white">
                    @foreach ($ledgers as $ledger)
                        <option value="{{ $ledger->id }}" {{ $ledger->id == $outward->ledger_id ? 'selected' : '' }}>
                            {{ $ledger->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Barcode</label>
                <input type="text" id="barcodeInput" placeholder="Scan barcode..."
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border"
                    autofocus>
            </div>
        </div>

        <div class="px-6 py-4">
            <h3 class="font-semibold text-lg mb-4 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                </svg>
                Outward Items
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
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HSN</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="itemsTableBody">
                        @foreach ($outward->details as $index => $detail)
                        <tr class="hover:bg-gray-50" data-item-id="{{ $detail->item->id }}">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="checkbox" class="rowCheckbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $detail->item->barcode }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $detail->item->category->name }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $detail->item->name }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $detail->item->hsn_code }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="number" name="quantities[]" value="{{ $detail->quantity }}"
                                    class="qtyInput w-20 border-gray-300 rounded-md text-sm px-2 py-1 text-center focus:border-blue-500 focus:ring-blue-500"
                                    min="1" data-rate="{{ $detail->item->price }}">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $detail->item->unit->abbreviation }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                ₹{{ number_format($detail->item->price, 2) }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">
                                ₹{{ number_format($detail->quantity * $detail->item->price, 2) }}
                            </td>
                            <!-- Hidden inputs -->
                            <td style="display:none;">
                                <input type="hidden" name="item_ids[]" value="{{ $detail->item->id }}">
                                <input type="hidden" name="rates[]" value="{{ $detail->item->price }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="9" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Grand Total</td>
                            <td class="px-4 py-3 text-right text-sm font-medium text-gray-900" id="grandTotal">
                                ₹{{ number_format($outward->total_amount, 2) }}
                            </td>
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
                        <span id="totalQty" class="text-lg font-semibold text-gray-800">{{ $outward->total_quantity }}</span>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Total Amount</span>
                        <span id="totalAmount" class="text-lg font-semibold text-blue-600">₹{{ number_format($outward->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const barcodeInput = document.getElementById("barcodeInput");
    const tbody = document.getElementById("itemsTableBody");
    const deleteBtn = document.getElementById("deleteSelectedBtn");
    const selectAllCheckbox = document.getElementById("selectAll");
    let slnoCounter = {{ $outward->details->count() + 1 }};

    // Calculate totals
    function calculateTotals() {
        let totalQty = 0;
        let totalAmount = 0;

        tbody.querySelectorAll("tr").forEach(row => {
            const qtyInput = row.querySelector('.qtyInput');
            if (!qtyInput) return;
            
            const qty = parseFloat(qtyInput.value) || 0;
            const rate = parseFloat(row.querySelector('input[name="rates[]"]').value) || 0;
            const subtotal = qty * rate;

            // Update subtotal cell
            const subtotalCell = row.querySelector('td:nth-child(10)');
            if (subtotalCell) {
                subtotalCell.textContent = subtotal.toLocaleString('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            totalQty += qty;
            totalAmount += subtotal;
        });

        // Update summary
        document.getElementById("totalQty").textContent = totalQty;
        document.getElementById("totalAmount").textContent = totalAmount.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById("grandTotal").textContent = totalAmount.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Toggle delete button visibility
    function toggleDeleteButton() {
        const anyChecked = document.querySelectorAll(".rowCheckbox:checked").length > 0;
        deleteBtn.classList.toggle("hidden", !anyChecked);
    }

    // Bind events to a row
    function bindRowEvents(row) {
        const qtyInput = row.querySelector('.qtyInput');
        const checkbox = row.querySelector('.rowCheckbox');

        if (qtyInput) {
            qtyInput.addEventListener("input", calculateTotals);
        }

        if (checkbox) {
            checkbox.addEventListener("change", toggleDeleteButton);
        }
    }

    selectAllCheckbox.addEventListener("change", function() {
        tbody.querySelectorAll(".rowCheckbox").forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        toggleDeleteButton();
    });

    barcodeInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();

            const barcode = barcodeInput.value.trim();
            if (!barcode) return;

            // Show loading state
            barcodeInput.disabled = true;
            barcodeInput.classList.add('opacity-75');

            fetch(`/outward/${barcode}`)
                .then(res => {
                    if (!res.ok) throw new Error("Item not found");
                    return res.json();
                })
                .then(item => {
                    const existingRow = Array.from(tbody.querySelectorAll("tr")).find(row => {
                        return row.querySelector("td:nth-child(3)")?.textContent.trim() === item.barcode;
                    });

                    if (existingRow) {
                       
                        existingRow.classList.add('bg-yellow-50');
                        setTimeout(() => existingRow.classList.remove('bg-yellow-50'), 1000);
                        
                        const qtyInput = existingRow.querySelector('.qtyInput');
                        qtyInput.value = parseInt(qtyInput.value) + 1;
                        qtyInput.dispatchEvent(new Event('input'));
                    } else {
                       
                        const tr = document.createElement("tr");
                        tr.className = "hover:bg-gray-50";
                        tr.setAttribute('data-item-id', item.id);

                        tr.innerHTML = `
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="checkbox" class="rowCheckbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${slnoCounter++}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                ${item.barcode}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                ${item.category?.name || ''}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                ${item.name}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                ${item.hsn_code || ''}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="number" name="quantities[]" value="1" class="qtyInput w-20 border-gray-300 rounded-md text-sm px-2 py-1 text-center focus:border-blue-500 focus:ring-blue-500" min="1" data-rate="${item.price || 0}">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                ${item.unit?.abbreviation || ''}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                ₹${item.price ? parseFloat(item.price).toFixed(2) : '0.00'}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">
                                ₹${item.price ? parseFloat(item.price).toFixed(2) : '0.00'}
                            </td>
                            <td style="display:none;">
                                <input type="hidden" name="item_ids[]" value="${item.id}">
                                <input type="hidden" name="rates[]" value="${item.price || 0}">
                            </td>
                        `;

                        tbody.appendChild(tr);
                        bindRowEvents(tr);
                        calculateTotals();
                    }

                    barcodeInput.value = '';
                    barcodeInput.focus();
                })
                .catch(err => {
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded shadow-lg flex items-center';
                    toast.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        ${err.message || "Failed to fetch item"}
                    `;
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);
                })
                .finally(() => {
                    barcodeInput.disabled = false;
                    barcodeInput.classList.remove('opacity-75');
                });
        }
    });

    // Delete selected rows
    deleteBtn.addEventListener("click", function () {
        if (confirm("Are you sure you want to delete the selected items?")) {
            document.querySelectorAll(".rowCheckbox:checked").forEach(cb => {
                cb.closest("tr").remove();
            });

            deleteBtn.classList.add("hidden");
            selectAllCheckbox.checked = false;
            calculateTotals();
        }
    });


    document.getElementById('outwardForm').addEventListener('submit', function(e) {
        if (tbody.querySelectorAll("tr").length === 0) {
            e.preventDefault();
            alert("Please add at least one item before saving.");
            barcodeInput.focus();
        }
    });
    
    tbody.querySelectorAll("tr").forEach(bindRowEvents);
});
    

</script>
@endsection