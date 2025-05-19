@extends('layouts.app')

@section('content')
<div class="w-full mx-auto bg-white px-4 py-6"
     x-data="moments({{ $items->toJson() }})"
>
    <!-- Form Start -->
    <form action="{{ route('movements.store') }}" method="POST" @submit.prevent="submitForm">
        @csrf

        <!-- Header -->
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h2 class="text-xl font-semibold">Item Movement</h2>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </div>

        <!-- Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 border-b gap-4 p-6 w-full">
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">From</label>
                <input type="text" value="{{ $from_warehouse->name }}" readonly
                       class="mt-1 block w-full border rounded px-3 py-2 cursor-not-allowed">
                <input type="hidden" name="from_warehouse_id" value="{{ $from_warehouse->id }}">
            </div>

            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                       class="mt-1 block w-full border rounded px-3 py-2" required>
            </div>

            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">Barcode</label>
                <input
                    x-model="barInput"
                    @change="addItemByBarcode()"
                    type="text"
                    placeholder="Enter Barcode"
                    class="mt-1 block w-full border rounded px-3 py-2"
                    x-ref="barcodeInput"
                >
            </div>

            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">To</label>
                <select name="to_warehouse_id" class="mt-1 block w-full border rounded px-3 py-2 bg-white" required>
                    <option value="">Select Warehouse</option>
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Item Table -->
        <div class="px-6 pb-6">
            <h3 class="font-semibold text-lg mb-4">Outward Item Details</h3>
            <template x-if="selectedItems.length > 0">
                <div>
                    <template x-for="(item, index) in selectedItems" :key="item.barcode">
                        <div class="flex items-center gap-4 border p-2 rounded mb-2" :data-barcode="item.barcode">
                            <input type="hidden" :name="'items[' + item.id + '][barcode]'" :value="item.barcode">
                            <input type="hidden" :name="'items[' + item.id + '][name]'" :value="item.name">
                            <input type="hidden" :name="'items[' + item.id + '][quantity]'" :value="item.qty">

                            <div class="flex-1">
                                <div><strong x-text="item.name"></strong> (<span x-text="item.barcode"></span>)</div>
                                <small>Available: <span x-text="item.current_stock"></span> {{ $item->unit->abbreviation ?? '' }}</small>
                            </div>
                            <input type="number" min="1"
                                   :max="item.current_stock"
                                   x-model.number="item.qty"
                                   @input="validateQty(item)"
                                   class="border rounded px-1 w-24 text-center">
                            <button type="button" @click="removeItem(item.barcode)" class="text-red-500 text-sm">Remove</button>
                        </div>
                    </template>
                </div>
            </template>
            <div x-show="selectedItems.length === 0" class="text-center text-gray-500 mt-4">No items selected.</div>
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
    </form>
    <!-- Form End -->
</div>

<script>
    function moments(items) {
        return {
            allItems: items,
            selectedItems: [],
            barInput: '',

            addItemByBarcode() {
                if (!this.barInput.trim()) return;
                let barcode = this.barInput.trim();
                let existing = this.selectedItems.find(i => i.barcode === barcode);
                if (existing) {
                    if (existing.qty < existing.current_stock) {
                        existing.qty += 1;
                    } else {
                        alert("Quantity exceeds current stock!");
                    }
                } else {
                    let item = this.allItems.find(i => i.barcode === barcode);
                    if (item && item.current_stock > 0) {
                        this.selectedItems.push({ ...item, qty: 1 });
                    } else {
                        alert("Invalid or out of stock item!");
                    }
                }
                this.barInput = '';
                this.$nextTick(() => this.$refs.barcodeInput.focus());
            },

            removeItem(barcode) {
                this.selectedItems = this.selectedItems.filter(i => i.barcode !== barcode);
            },

            validateQty(item) {
                if (item.qty > item.current_stock) {
                    alert("Quantity exceeds current stock!");
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

            formatPrice(value) {
                return new Intl.NumberFormat('en-IN', { minimumFractionDigits: 2 }).format(value);
            },

            submitForm() {
                if (this.selectedItems.length === 0) {
                    alert("Please add at least one item.");
                    return;
                }
                this.$el.submit();
            }
        }
    }
</script>
@endsection
