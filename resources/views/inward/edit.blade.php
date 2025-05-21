@extends('layouts.app')

@section('content')

<div class="w-full mx-auto bg-white px-4 py-6">

    <div class="flex justify-between items-center border-b px-6 py-4">
        <h2 class="text-xl font-semibold">Inward Details</h2>
        <button type="button" id="saveBtn"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 border-b gap-4 p-6">
        <div>
    <label class="block text-sm font-medium text-gray-700">Date</label>
    <input 
        type="date" 
        id="formDate" 
        class="mt-1 block w-full border rounded px-3 py-2"
        value="{{ $inward->date }}"
        max="{{ date('Y-m-d') }}"  >
</div>


        <div>
            <label class="block text-sm font-medium text-gray-700">Ledger</label>
            <select id="ledgerInput" name="ledger_id"
                class="mt-1 block w-full border rounded px-3 py-2 bg-white">
                @foreach ($ledgers as $ledger)
                    <option value="{{ $ledger->id }}"
                        {{ $ledger->id == $inward->ledger_id ? 'selected' : '' }}>
                        {{ $ledger->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Barcode</label>
            <input type="text" id="barcodeInput" placeholder="Enter Barcode"
                class="mt-1 block w-full border rounded px-3 py-2" autofocus>
        </div>






    </div>

        
    <div class="px-6 py-2 pb-6">
        <h3 class="font-semibold text-lg mb-4">Inwards Item Details</h3>
        
        <!-- Responsive table wrapper -->
        <div class="overflow-x-auto w-full">
            <table class="w-full text-sm text-gray-500 border border-gray-200">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 text-center">
                    <tr> <th class="border px-2 py-2 whitespace-nowrap"> select </th>
                        <th class="border px-2 py-2 whitespace-nowrap">Slno</th>
                        <th class="border px-2 py-2 whitespace-nowrap">Bar Code</th>
                        <th class="border px-2 py-2 whitespace-nowrap">Category</th>
                        <th class="border px-2 py-2 whitespace-nowrap">Item</th>
                        <th class="border px-2 py-2 whitespace-nowrap">HSN Code</th>
                        <th class="border px-2 py-2 whitespace-nowrap">Qty</th>
                        <th class="border px-2 py-2 whitespace-nowrap">Unit</th>
                        <th class="border px-2 py-2 whitespace-nowrap">Rate</th>
                    </tr>
                </thead>
                <tbody class="text-center text-black">
                    @foreach ($inward->details as $index => $detail)
                        <tr>
                        <td><input type="checkbox" class="rowCheckbox"></td>
                            <td class="border px-2 py-2">{{ $index + 1 }}</td>
                            <td class="border px-2 py-2">{{ $detail->item->barcode }}</td>
                            <td class="border px-2 py-2">
                                <select name="category_ids[]" class="w-full border rounded px-2 py-1">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $detail->item->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border px-2 py-2">
                                <input type="text" name="item_names[]" value="{{ $detail->item->name }}"
                                    class="w-full md:w-40 border rounded px-2 py-1 text-center">
                            </td>
                            <td class="border px-2 py-2">
                                <input type="text" name="hsn_codes[]" value="{{ $detail->item->hsn_code }}"
                                    class="w-full md:w-32 border rounded px-2 py-1 text-center">
                            </td>
                            <td class="border px-2 py-2">
                                <input type="number" name="quantities[]" value="{{ $detail->quantity }}"
                                    class="w-full md:w-24 border rounded px-2 py-1 text-center qty-input" min="0"
                                    data-rate="{{ $detail->item->price }}">
                            </td>
                            <td class="border px-2 py-2">
                                <select name="unit_ids[]" class="w-full border rounded px-2 py-1">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ $unit->id == $detail->item->unit_id ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border px-2 py-2 rate-cell whitespace-nowrap">
                                {{ $detail->item->price }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <button type="button" id="deleteSelectedBtn"
            class="mt-4 bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600 hidden">
            Delete
        </button>
        </div>
    </div>

    <div class="mt-6 border-t px-6 py-4">
        <h3 class="font-semibold mb-2">Summary</h3>
        <div class="overflow-x-auto w-full">
            <table class=" text-sm border">
                <tr>
                    <th class="border px-2 py-2 text-left whitespace-nowrap">Total Qty</th>
                    <td class="border px-2 py-2 total-qty">{{ $inward->total_quantity }}</td>
                </tr>
                <tr>
                    <th class="border px-2 py-2 text-left whitespace-nowrap">Total Amount</th>
                    <td class="border px-2 py-2 total-amount">{{ number_format($inward->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const qtyInputs = document.querySelectorAll(".qty-input");
    const totalQtyEl = document.querySelector(".total-qty");
    const totalAmountEl = document.querySelector(".total-amount");
    const checkboxes = document.querySelectorAll(".rowCheckbox");
    const deleteBtn = document.getElementById("deleteSelectedBtn");

    function calculateTotals() {
        let totalQty = 0;
        let totalAmount = 0;

        document.querySelectorAll(".qty-input").forEach(input => {
            const qty = parseFloat(input.value) || 0;
            const rate = parseFloat(input.dataset.rate) || 0;

            totalQty += qty;
            totalAmount += qty * rate;
        });

        totalQtyEl.textContent = totalQty;
        totalAmountEl.textContent = totalAmount.toFixed(2);
    }

    qtyInputs.forEach(input => {
        input.addEventListener("input", calculateTotals);
    });

    // Show/hide delete button based on checkbox selection
    function toggleDeleteButton() {
        const anyChecked = document.querySelectorAll(".rowCheckbox:checked").length > 0;
        deleteBtn.classList.toggle("hidden", !anyChecked);
    }

    checkboxes.forEach(cb => {
        cb.addEventListener("change", toggleDeleteButton);
    });

    // Delete selected rows on button click
    deleteBtn.addEventListener("click", function () {
        document.querySelectorAll(".rowCheckbox:checked").forEach(cb => {
            cb.closest("tr").remove();
        });

        // Hide the button after deletion
        deleteBtn.classList.add("hidden");

        // Recalculate totals after deletion
        calculateTotals();
    });

    // Run on page load in case some are pre-checked (optional)
    toggleDeleteButton();
});
</script>


@endsection
