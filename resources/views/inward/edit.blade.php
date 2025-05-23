@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('inwards.update', $inward->id) }}">
    @csrf
    @method('PUT')

    <div class="w-full mx-auto bg-white px-4 py-6">

        <div class="flex justify-between items-center border-b px-6 py-4">
            <h2 class="text-xl font-semibold">Edit Inward </h2>
            <button type="submit" id="saveBtn"
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
                    name="date"
                    class="mt-1 block w-full border rounded px-3 py-2"
                    value="{{ $inward->date }}"
                    max="{{ date('Y-m-d') }}" 
                    required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Ledger</label>
                <select id="ledgerInput" name="ledger_id"
                    class="mt-1 block w-full border rounded px-3 py-2 bg-white" required>
                    @foreach ($ledgers as $ledger)
                        <option value="{{ $ledger->id }}" {{ $ledger->id == $inward->ledger_id ? 'selected' : '' }}>
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
            <div class="overflow-x-auto w-full">
                <table class="w-full text-sm text-gray-500 border border-gray-200">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 text-center">
                        <tr>
                            <th class="border px-2 py-2">Select</th>
                            <th class="border px-2 py-2">Slno</th>
                            <th class="border px-2 py-2">Barcode</th>
                            <th class="border px-2 py-2">Category</th>
                            <th class="border px-2 py-2">Item</th>
                            <th class="border px-2 py-2">HSN Code</th>
                            <th class="border px-2 py-2">Qty</th>
                            <th class="border px-2 py-2">Unit</th>
                            <th class="border px-2 py-2">Rate</th>
                            <th class="border px-2 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-center text-black">
                        @foreach ($inward->details as $index => $detail)
                            <tr>
                                <td><input type="checkbox" class="rowCheckbox"></td>
                                <td class="border px-2 py-2 slno">{{ $index + 1 }}</td>
                                <td class="border px-2 py-2 barcode-cell">{{ $detail->item->barcode }}</td>
                                <td class="border px-2 py-2">
                                    <select name="category_ids[]" class="w-full border rounded px-2 py-1">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $detail->item->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="border px-2 py-2">
                                    <input type="text" name="item_names[]" value="{{ $detail->item->name }}"
                                        class="w-full border rounded px-2 py-1 text-center">
                                </td>
                                <td class="border px-2 py-2">
                                    <input type="text" name="hsn_codes[]" value="{{ $detail->item->hsn_code }}"
                                        class="w-full border rounded px-2 py-1 text-center">
                                </td>
                                <td class="border px-2 py-2">
                                    <input type="number" name="quantities[]" value="{{ $detail->quantity }}"
                                        class="w-full border rounded px-2 py-1 text-center qty-input" min="1"
                                        data-rate="{{ $detail->item->price }}">
                                </td>
                                <td class="border px-2 py-2">
                                    <select name="unit_ids[]" class="w-full border rounded px-2 py-1">
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}" {{ $unit->id == $detail->item->unit_id ? 'selected' : '' }}>
                                                {{ $unit->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="border px-2 py-2 rate-cell">{{ $detail->item->price }}</td>
                                <td class="border px-2 py-2 subtotal-cell">{{ number_format($detail->quantity * $detail->item->price, 2) }}</td>

                                {{-- Hidden inputs for existing item IDs and rates --}}
                                <td style="display:none;">
                                    <input type="hidden" name="item_ids[]" value="{{ $detail->item->id }}">
                                    <input type="hidden" name="rates[]" value="{{ $detail->item->price }}">
                                </td>
                            </tr>
                        @endforeach
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
        </div>

        <div class="mt-6 border-t px-6 py-4">
            <h3 class="font-semibold mb-2">Summary</h3>
            <div class="overflow-x-auto w-full">
                <table class="text-sm border">
                    <tr>
                        <th class="border px-2 py-2 text-left">Total Qty</th>
                        <td class="border px-2 py-2 total-qty">{{ $inward->total_quantity }}</td>
                    </tr>
                    <tr>
                        <th class="border px-2 py-2 text-left">Total Amount</th>
                        <td class="border px-2 py-2 total-amount">{{ number_format($inward->total_amount, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const barcodeInput = document.getElementById("barcodeInput");
    const tbody = document.querySelector("tbody");
    const deleteBtn = document.getElementById("deleteSelectedBtn");
    let slnoCounter = {{ $inward->details->count() + 1 }};

    function recalcSlno() {
        tbody.querySelectorAll("tr").forEach((row, i) => {
            const slnoCell = row.querySelector(".slno");
            if(slnoCell) slnoCell.textContent = i + 1;
        });
        slnoCounter = tbody.querySelectorAll("tr").length + 1;
    }

    function calculateTotals() {
        let totalQty = 0;
        let totalAmount = 0;

        tbody.querySelectorAll("tr").forEach(row => {
            const qtyInput = row.querySelector('input[name="quantities[]"]');
            const qty = parseFloat(qtyInput?.value || 0);
            const rate = parseFloat(row.querySelector(".rate-cell")?.textContent || 0);
            const subtotalCell = row.querySelector(".subtotal-cell");

            const subtotal = qty * rate;
            if(subtotalCell) subtotalCell.textContent = subtotal.toFixed(2);

            totalQty += qty;
            totalAmount += subtotal;
        });

        document.querySelector(".total-qty").textContent = totalQty;
        document.querySelector(".total-amount").textContent = totalAmount.toFixed(2);
        document.getElementById("grandTotal").textContent = totalAmount.toFixed(2);
    }

    function toggleDeleteButton() {
        const anyChecked = document.querySelectorAll(".rowCheckbox:checked").length > 0;
        deleteBtn.classList.toggle("hidden", !anyChecked);
    }

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

    barcodeInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();

            const barcode = barcodeInput.value.trim();
            if (!barcode) return;

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
                        const qtyInput = existingRow.querySelector('input[name="quantities[]"]');
                        qtyInput.value = parseInt(qtyInput.value) + 1;
                        // existingRow.classList.add('bg-yellow-100');
                        // setTimeout(() => existingRow.classList.remove('bg-yellow-100'), 500);
                        calculateTotals();
                    } else {
                        const tr = document.createElement("tr");

                        tr.innerHTML = `
                            <td><input type="checkbox" class="rowCheckbox" /></td>
                            <td class="border px-2 py-2 slno">${slnoCounter++}</td>
                            <td class="border px-2 py-2 barcode-cell">${item.barcode}</td>
                            <td class="border px-2 py-2">
                                <select name="category_ids[]" class="w-full border rounded px-2 py-1">
                                    ${item.category ? `<option value="${item.category.id}" selected>${item.category.name}</option>` : '<option value="">Select</option>'}
                                </select>
                            </td>
                            <td class="border px-2 py-2">
                                <input type="text" name="item_names[]" value="${item.name}" class="w-full border rounded px-2 py-1 text-center" />
                            </td>
                            <td class="border px-2 py-2">
                                <input type="text" name="hsn_codes[]" value="${item.hsn_code || ''}" class="w-full border rounded px-2 py-1 text-center" />
                            </td>
                            <td class="border px-2 py-2">
                                <input type="number" name="quantities[]" value="1" class="w-full border rounded px-2 py-1 text-center qty-input" min="1" data-rate="${item.price || 0}" />
                            </td>
                            <td class="border px-2 py-2">
                                <select name="unit_ids[]" class="w-full border rounded px-2 py-1">
                                    ${item.unit ? `<option value="${item.unit.id}" selected>${item.unit.name}</option>` : '<option value="">Select</option>'}
                                </select>
                            </td>
                            <td class="border px-2 py-2 rate-cell">${item.price || 0}</td>
                            <td class="border px-2 py-2 subtotal-cell">0.00</td>
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
                    alert(err.message || "Failed to fetch item");
                });
        }
    });

    deleteBtn.addEventListener("click", function () {
        document.querySelectorAll(".rowCheckbox:checked").forEach(cb => {
            cb.closest("tr").remove();
        });

        deleteBtn.classList.add("hidden");
        recalcSlno();
        calculateTotals();
    });

    // Bind events to existing rows on page load
    tbody.querySelectorAll("tr").forEach(bindRowEvents);

    calculateTotals();
});
</script>
@endsection
