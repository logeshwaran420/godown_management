@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('inwards.update', $inward->id) }}" id="inwardForm">
    @csrf
    @method('PUT')

    <div class="w-full mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Edit Inward</h2>
                <p class="text-sm text-gray-600 mt-1">ID: {{ $inward->id }} | Created: {{ $inward->created_at->format('d M Y') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('inwards') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                    Cancel
                </a>
                <button type="submit" id="saveBtn" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Save Changes
                </button>
            </div>
        </div>

        <!-- Basic Information Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 border-b">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date*</label>
                <input type="date" id="formDate" name="date"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ $inward->date }}"
                    max="{{ date('Y-m-d') }}" 
                    required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ledger*</label>
                <select id="ledgerInput" name="ledger_id"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" required>
                    @foreach ($ledgers as $ledger)
                        <option value="{{ $ledger->id }}" {{ $ledger->id == $inward->ledger_id ? 'selected' : '' }}>
                            {{ $ledger->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Add Item by Barcode</label>
                <div class="relative">
                    <input type="text" id="barcodeInput" placeholder="Scan or enter barcode"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10"
                        autofocus>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table Section -->
        <div class="px-6 py-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Inward Items</h3>
                <button type="button" id="deleteSelectedBtn"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition hidden flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Delete Selected
                </button>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                <input type="checkbox" id="selectAll" class="rounded text-blue-600">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barcode</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HSN</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($inward->details as $index => $detail)
                            <tr class="hover:bg-gray-50 transition" data-item-id="{{ $detail->item->id }}">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <input type="checkbox" class="rowCheckbox rounded text-blue-600">
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap slno">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 whitespace-nowrap barcode-cell font-medium text-gray-900">
                                    {{ $detail->item->barcode }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <select name="category_ids[]" class="w-full border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $detail->item->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <input type="text" name="item_names[]" value="{{ $detail->item->name }}"
                                        class="w-full border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <input type="text" name="hsn_codes[]" value="{{ $detail->item->hsn_code }}"
                                        class="w-24 border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <input type="number" name="quantities[]" value="{{ $detail->quantity }}"
                                        class="w-20 border-gray-300 rounded-md px-2 py-1 text-center focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm qty-input"
                                        min="1" data-rate="{{ $detail->item->price }}">
                                </td>
                                <td class=" whitespace-nowrap">
                                    <select name="unit_ids[]" class="w-full border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}" {{ $unit->id == $detail->item->unit_id ? 'selected' : '' }}>
                                                {{ $unit->abbreviation }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-right rate-cell font-medium">
                                 ₹{{ number_format($detail->item->price, 2) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-right subtotal-cell font-medium text-blue-600">
                                   ₹{{ number_format($detail->quantity * $detail->item->price, 2) }}
                                </td>

                                <!-- Hidden inputs for existing item IDs and rates -->
                                <td style="display:none;">
                                    <input type="hidden" name="item_ids[]" value="{{ $detail->item->id }}">
                                    <input type="hidden" name="rates[]" value="{{ $detail->item->price }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t">
                        <tr>
                            <td colspan="8" class="px-4 py-3 text-right font-medium text-gray-700">Grand Total</td>
                            <td colspan="2" class="px-4 py-3 text-right font-bold text-gray-900 text-lg" id="grandTotal">₹ 0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="bg-gray-50 px-6 py-4 border-t">
            <h3 class="font-semibold text-gray-800 mb-3">Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-600">Total Quantity</span>
                        <span class="text-lg font-semibold total-qty">{{ $inward->total_quantity }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Total Amount</span>
                        <span class="text-lg font-semibold total-amount">₹{{ number_format($inward->total_amount, 2) }}</span>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Number of Items</span>
                        <span class="text-lg font-semibold">{{ $inward->details->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const barcodeInput = document.getElementById("barcodeInput");
    const tbody = document.querySelector("tbody");
    const deleteBtn = document.getElementById("deleteSelectedBtn");
    const selectAllCheckbox = document.getElementById("selectAll");
    let slnoCounter = {{ $inward->details->count() + 1 }};

    // Initialize tooltips
    tippy('[data-tippy-content]', {
        allowHTML: true,
        arrow: true,
    });

    // Recalculate serial numbers
    function recalcSlno() {
        tbody.querySelectorAll("tr").forEach((row, i) => {
            const slnoCell = row.querySelector(".slno");
            if(slnoCell) slnoCell.textContent = i + 1;
        });
        slnoCounter = tbody.querySelectorAll("tr").length + 1;
    }

    // Calculate totals
    function calculateTotals() {
        let totalQty = 0;
        let totalAmount = 0;

        tbody.querySelectorAll("tr").forEach(row => {
            const qtyInput = row.querySelector('input[name="quantities[]"]');
            const qty = parseFloat(qtyInput?.value || 0);
            const rate = parseFloat(row.querySelector(".rate-cell")?.textContent.replace(/,/g, '') || 0);
            const subtotalCell = row.querySelector(".subtotal-cell");

            const subtotal = qty * rate;
            if(subtotalCell) subtotalCell.textContent = subtotal.toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            totalQty += qty;
            totalAmount += subtotal;
        });

        document.querySelector(".total-qty").textContent = totalQty;
        document.querySelector(".total-amount").textContent = totalAmount.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById("grandTotal").textContent = totalAmount.toLocaleString('en-IN', {
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
        const qtyInput = row.querySelector('input[name="quantities[]"]');
        const checkbox = row.querySelector('.rowCheckbox');

        if (qtyInput) {
            qtyInput.addEventListener("input", () => {
                calculateTotals();
            });
        }

        if (checkbox) {
            checkbox.addEventListener("change", toggleDeleteButton);
        }
    }

    // Select all checkboxes
    selectAllCheckbox.addEventListener("change", function() {
        tbody.querySelectorAll(".rowCheckbox").forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        toggleDeleteButton();
    });

    // Barcode input handler
    barcodeInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();

            const barcode = barcodeInput.value.trim();
            if (!barcode) return;

            // Show loading state
            barcodeInput.disabled = true;
            barcodeInput.classList.add('opacity-75');

            fetch(`/inward/${barcode}`)
                .then(res => {
                    if (!res.ok) throw new Error("Item not found");
                    return res.json();
                })
                .then(item => {
                    const existingRow = Array.from(tbody.querySelectorAll("tr")).find(row => {
                        return row.querySelector(".barcode-cell")?.textContent.trim() === item.barcode;
                    });

                    if (existingRow) {
                        // Highlight existing row temporarily
                        existingRow.classList.add('bg-yellow-50');
                        setTimeout(() => existingRow.classList.remove('bg-yellow-50'), 1000);
                        
                        // Increment quantity
                        const qtyInput = existingRow.querySelector('input[name="quantities[]"]');
                        qtyInput.value = parseInt(qtyInput.value) + 1;
                        qtyInput.dispatchEvent(new Event('input'));
                    } else {
                        // Create new row
                        const tr = document.createElement("tr");
                        tr.className = "hover:bg-gray-50 transition";
                        tr.setAttribute('data-item-id', item.id);

                        tr.innerHTML = `
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="checkbox" class="rowCheckbox rounded text-blue-600">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap slno">${slnoCounter++}</td>
                            <td class="px-4 py-3 whitespace-nowrap barcode-cell font-medium text-gray-900">
                                ${item.barcode}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <select name="category_ids[]" class="w-full border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                                    ${item.category ? `<option value="${item.category.id}" selected>${item.category.name}</option>` : '<option value="">Select</option>'}
                                </select>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="text" name="item_names[]" value="${item.name}" class="w-full border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm" />
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="text" name="hsn_codes[]" value="${item.hsn_code || ''}" class="w-24 border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm" />
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="number" name="quantities[]" value="1" class="w-20 border-gray-300 rounded-md px-2 py-1 text-center focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm qty-input" min="1" data-rate="${item.price || 0}" />
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <select name="unit_ids[]" class="w-full border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                                    ${item.unit ? `<option value="${item.unit.id}" selected>${item.unit.name}</option>` : '<option value="">Select</option>'}
                                </select>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right rate-cell font-medium">
                                ${item.price ? parseFloat(item.price).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '0.00'}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right subtotal-cell font-medium text-blue-600">
                                0.00
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

                    // Reset barcode input
                    barcodeInput.value = '';
                    barcodeInput.focus();
                })
                .catch(err => {
                    // Show error message
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
            recalcSlno();
            calculateTotals();
        }
    });

    // Form submission handler
    document.getElementById('inwardForm').addEventListener('submit', function(e) {
        if (tbody.querySelectorAll("tr").length === 0) {
            e.preventDefault();
            alert("Please add at least one item before saving.");
            barcodeInput.focus();
        }
    });

    // Bind events to existing rows on page load
    tbody.querySelectorAll("tr").forEach(bindRowEvents);

    // Calculate initial totals
    calculateTotals();
});
</script>
@endsection














@extends('layouts.app')

@section('content')
<div class="w-full mx-auto bg-white">
    <form id="movementForm" method="POST" action="{{ route('movements.store') }}" class="w-full">
        @csrf

        {{-- Header: Title and Save Button --}}
        <div class="flex justify-between items-center border-b px-6 py-4 bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                    <path fill-rule="evenodd" d="M7 4a4 4 0 00-4 4v1h8V8a4 4 0 00-4-4zm3 4a3 3 0 00-6 0v1h6V8z" clip-rule="evenodd" />
                </svg>
                Movement Entry
            </h2>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Save
            </button>
        </div>

        {{-- Inputs Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6 border-b">
            {{-- From Warehouse (readonly) --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">From Warehouse</label>
                <div class="relative">
                    <input type="text" value="{{ $from_warehouse->name }}" readonly
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border cursor-not-allowed bg-gray-100">
                    <input type="hidden" name="from_warehouse_id" value="{{ $from_warehouse->id }}">
                </div>
            </div>

            {{-- Date --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <div class="relative">
                    <input type="date" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border" required>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Barcode Input --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Barcode</label>
                <div class="relative">
                    <input type="text" id="barcodeInput" placeholder="Scan barcode..."
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border"
                           autocomplete="off" autofocus>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- To Warehouse Dropdown --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">To Warehouse</label>
                <select name="to_warehouse_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2 border bg-white" required>
                    <option value="">Select Warehouse</option>
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Movement Items Table --}}
        <div class="px-6 py-4">
            <h3 class="font-semibold text-lg mb-4 text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                </svg>
                Movement Item Details
            </h3>
            
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">
                                <input type="checkbox" id="selectAllCheckbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barcode</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HSN Code</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
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

            {{-- Delete Selected Button --}}
            <button type="button" id="deleteSelectedBtn"
                    class="mt-4 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Delete Selected
            </button>
        </div>

        {{-- Summary Section --}}
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
                        <span id="totalAmount" class="text-lg font-semibold text-blue-600">₹0.00</span>
                    </div>
                </div>
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
                    const existingRow = Array.from(tableBody.rows).find(row => 
                        row.querySelector('td:nth-child(3)')?.textContent.trim() === item.barcode
                    );
                    
                    if (existingRow) {
                        const qtyInput = existingRow.querySelector('.qtyInput');
                        const maxStock = parseInt(qtyInput.dataset.stock, 10) || 0;
                        let currentQty = parseInt(qtyInput.value, 10) || 0;

                        if (currentQty < maxStock) {
                            qtyInput.value = currentQty + 1;
                            qtyInput.dispatchEvent(new Event('input'));
                            
                            existingRow.classList.add('bg-blue-50');
                            setTimeout(() => existingRow.classList.remove('bg-blue-50'), 500);
                        } else {
                            alert(`Cannot exceed available stock (${maxStock})`);
                        }
                    } else {
                        // Remove No Data row if present
                        document.getElementById('noDataRow')?.remove();

                        const rowCount = tableBody.querySelectorAll('tr').length + 1;

                        const tr = document.createElement('tr');
                        tr.className = 'hover:bg-gray-50';
                        tr.innerHTML = `
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="checkbox" class="rowCheckbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${rowCount}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${item.barcode}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.category?.name || '-'}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${item.name}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.hsn_code || ''}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                <input type="number" 
                                       name="items[${item.id}][qty]" 
                                       value="1" 
                                       min="1"
                                       max="${item.current_stock}" 
                                       data-stock="${item.current_stock}"
                                       class="qtyInput w-16 border rounded-md px-2 py-1 text-center border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                       required>
                                <input type="hidden" name="items[${item.id}][barcode]" value="${item.barcode}">
                                <input type="hidden" name="items[${item.id}][name]" value="${item.name}">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.unit?.name || '-'}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${parseFloat(item.price).toFixed(2)}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">${parseFloat(item.price).toFixed(2)}</td>
                        `;

                        tableBody.appendChild(tr);
                        bindRowEvents(tr);
                        updateSummary();
                        
                        tr.classList.add('bg-green-50');
                        setTimeout(() => tr.classList.remove('bg-green-50'), 500);
                    }
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
    function bindRowEvents(row) {
        const qtyInput = row.querySelector('.qtyInput');
        if (qtyInput) {
            qtyInput.addEventListener('input', function() {
                const maxStock = parseInt(this.dataset.stock, 10);
                let val = parseInt(this.value, 10);

                if (isNaN(val) {
                    this.value = 1;
                    val = 1;
                } else if (val < 1) {
                    this.value = 1;
                    val = 1;
                } else if (val > maxStock) {
                    alert(`Cannot exceed available stock (${maxStock})`);
                    this.value = maxStock;
                    val = maxStock;
                }

                updateRowSubtotal(row);
                updateSummary();
            });
        }

        const checkbox = row.querySelector('.rowCheckbox');
        if (checkbox) {
            checkbox.addEventListener('change', toggleDeleteButton);
        }
    }

    // Select/Deselect all rows
    selectAllCheckbox.addEventListener('change', function () {
        const checked = this.checked;
        tableBody.querySelectorAll('.rowCheckbox').forEach(cb => cb.checked = checked);
        toggleDeleteButton();
    });

    // Delete selected rows
    deleteBtn.addEventListener('click', function () {
        const checkedBoxes = tableBody.querySelectorAll('.rowCheckbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Select at least one row to delete.');
            return;
        }

        if (!confirm('Are you sure you want to delete the selected items?')) return;

        checkedBoxes.forEach(cb => cb.closest('tr').remove());

        // If no rows left, show No Data row
        if (tableBody.rows.length === 0) {
            const noDataRow = document.createElement('tr');
            noDataRow.id = 'noDataRow';
            noDataRow.innerHTML = `
                <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                    <div class="flex flex-col items-center justify-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2">No items added yet</p>
                        <p class="text-xs text-gray-500 mt-1">Start scanning barcodes to add items</p>
                    </div>
                </td>`;
            tableBody.appendChild(noDataRow);
        }

        updateSlNo();
        updateSummary();
        toggleDeleteButton();
    });

    // Update row slno
    function updateSlNo() {
        const rows = tableBody.querySelectorAll('tr:not(#noDataRow)');
        rows.forEach((row, idx) => {
            const slnoCell = row.querySelector('td:nth-child(2)');
            if (slnoCell) slnoCell.textContent = idx + 1;
        });
    }

    // Update subtotal for a given row
    function updateRowSubtotal(row) {
        const qtyInput = row.querySelector('.qtyInput');
        const priceCell = row.querySelector('td:nth-child(9)');
        const subtotalCell = row.querySelector('td:nth-child(10)');

        const qty = parseInt(qtyInput.value) || 0;
        const price = parseFloat(priceCell.textContent) || 0;
        const subtotal = qty * price;

        subtotalCell.textContent = subtotal.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Update summary totals
    function updateSummary() {
        let totalQty = 0;
        let totalAmount = 0;

        tableBody.querySelectorAll('tr:not(#noDataRow)').forEach(row => {
            const qtyInput = row.querySelector('.qtyInput');
            const subtotalCell = row.querySelector('td:nth-child(10)');

            if (qtyInput && subtotalCell) {
                totalQty += parseInt(qtyInput.value) || 0;
                totalAmount += parseFloat(subtotalCell.textContent.replace(/[^0-9.-]+/g,"")) || 0;
            }
        });

        document.getElementById('totalQty').textContent = totalQty;
        document.getElementById('totalAmount').textContent = totalAmount.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById('grandTotal').textContent = totalAmount.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Toggle visibility of Delete button
    function toggleDeleteButton() {
        const anyChecked = Array.from(tableBody.querySelectorAll('.rowCheckbox')).some(cb => cb.checked);
        deleteBtn.classList.toggle('hidden', !anyChecked);
    }

    // Prevent form submit if no items added
    form.addEventListener('submit', function (e) {
        if (tableBody.querySelectorAll('tr:not(#noDataRow)').length === 0) {
            e.preventDefault();
            alert('Add at least one item to move.');
        }
    });
});
</script>
@endsection