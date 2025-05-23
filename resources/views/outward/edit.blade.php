@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('outwards.update', $outward->id) }}">
    @csrf
    @method('PUT')

    <div class="w-full mx-auto bg-white px-4 py-6">

        <div class="flex justify-between items-center border-b px-6 py-4">
            <h2 class="text-xl font-semibold">Edit Outward</h2>
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
                    value="{{ $outward->date }}"
                    max="{{ date('Y-m-d') }}" 
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Ledger</label>
                <select id="ledgerInput" name="ledger_id"
                    class="mt-1 block w-full border rounded px-3 py-2 bg-white" required>
                    @foreach ($ledgers as $ledger)
                        <option value="{{ $ledger->id }}" {{ $ledger->id == $outward->ledger_id ? 'selected' : '' }}>
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
            <h3 class="font-semibold text-lg mb-4">Outwards Item Details</h3>
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
                        @foreach ($outward->details as $index => $detail)
                            <tr>
                                <td><input type="checkbox" class="rowCheckbox"></td>
                                <td class="border px-2 py-2">{{ $index + 1 }}</td>
                                <td class="border px-2 py-2">{{ $detail->item->barcode }}</td>
                                <td class="border px-2 py-2">{{ $detail->item->category->name }}</td>
                                <td class="border px-2 py-2">{{ $detail->item->name }}</td>
                                <td class="border px-2 py-2">{{ $detail->item->hsn_code }}</td>
                                <td class="border px-2 py-2">
                                    <input type="number" name="quantities[]" value="{{ $detail->quantity }}"
                                        class="w-full border rounded px-2 py-1 text-center qty-input" min="1"
                                        data-rate="{{ $detail->item->price }}">
                                </td>
                                <td class="border px-2 py-2">{{ $detail->item->unit->abbreviation }}</td>
                                <td class="border px-2 py-2 rate-cell">{{ $detail->item->price }}</td>
                                <td class="border px-2 py-2 subtotal-cell">
                                    {{ number_format($detail->quantity * $detail->item->price, 2) }}
                                </td>

                                {{-- Hidden inputs for existing items --}}
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
                        <td class="border px-2 py-2 total-qty">{{ $outward->total_quantity }}</td>
                    </tr>
                    <tr>
                        <th class="border px-2 py-2 text-left">Total Amount</th>
                        <td class="border px-2 py-2 total-amount">{{ number_format($outward->total_amount, 2) }}</td>
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
    let slnoCounter = {{ $outward->details->count() + 1 }};

    function calculateTotals() {
        let totalQty = 0;
        let totalAmount = 0;

        document.querySelectorAll("tbody tr").forEach(row => {
            const qtyInput = row.querySelector('input[name="quantities[]"]');
            const rateCell = row.querySelector(".rate-cell");
            const subtotalCell = row.querySelector(".subtotal-cell");

            if (!qtyInput || !rateCell || !subtotalCell) return;

            const qty = parseFloat(qtyInput.value) || 0;
            const rate = parseFloat(rateCell.textContent) || 0;
            const subtotal = qty * rate;

            totalQty += qty;
            totalAmount += subtotal;

            subtotalCell.textContent = subtotal.toFixed(2);
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
            qtyInput.addEventListener("input", calculateTotals);
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

            fetch(`/outward/${barcode}`)
                .then(res => {
                    if (!res.ok) throw new Error("Item not found");
                    return res.json();
                })
                .then(item => {
                    const existingRow = Array.from(tbody.querySelectorAll("tr")).find(row => {
                        return row.cells[2]?.textContent.trim() === item.barcode;
                    });

                    if (existingRow) {
                        const qtyInput = existingRow.querySelector('input[name="quantities[]"]');
                        qtyInput.value = parseInt(qtyInput.value) + 1;
                        existingRow.classList.add('bg-yellow-100');
                        setTimeout(() => existingRow.classList.remove('bg-yellow-100'), 500);
                    } else {
                        const tr = document.createElement("tr");
                        tr.innerHTML = `
                            <td><input type="checkbox" class="rowCheckbox" /></td>
                            <td class="border px-2 py-2">${slnoCounter++}</td>
                            <td class="border px-2 py-2">${item.barcode}</td>
                            <td class="border px-2 py-2">${item.category?.name || ''}</td>
                            <td class="border px-2 py-2">${item.name}</td>
                            <td class="border px-2 py-2">${item.hsn_code || ''}</td>
                            <td class="border px-2 py-2">
                                <input type="number" name="quantities[]" value="1" min="1"
                                    class="w-full border rounded px-2 py-1 text-center qty-input" data-rate="${item.price}">
                            </td>
                            <td class="border px-2 py-2">${item.unit?.abbreviation || ''}</td>
                            <td class="border px-2 py-2 rate-cell">${parseFloat(item.price).toFixed(2)}</td>
                            <td class="border px-2 py-2 subtotal-cell">0.00</td>

                            <td style="display:none;">
                                <input type="hidden" name="item_ids[]" value="${item.id}" />
                                <input type="hidden" name="rates[]" value="${parseFloat(item.price).toFixed(2)}" />
                            </td>
                        `;
                        tbody.appendChild(tr);
                        bindRowEvents(tr);
                        calculateTotals();
                    }

                    barcodeInput.value = "";
                    barcodeInput.focus();
                })
                .catch(err => {
                    alert("Item not found");
                });
        }
    });

    deleteBtn.addEventListener("click", () => {
        const rows = Array.from(tbody.querySelectorAll("tr"));
        rows.forEach(row => {
            const checkbox = row.querySelector(".rowCheckbox");
            if (checkbox && checkbox.checked) {
                row.remove();
            }
        });

        // Re-number slno column
        Array.from(tbody.querySelectorAll("tr")).forEach((row, idx) => {
            row.cells[1].textContent = idx + 1;
        });
        slnoCounter = tbody.querySelectorAll("tr").length + 1;

        calculateTotals();
        toggleDeleteButton();
    });

    // Initial binding for existing rows
    document.querySelectorAll("tbody tr").forEach(bindRowEvents);

    // Initial calculation on page load
    calculateTotals();
});
</script>

@endsection
