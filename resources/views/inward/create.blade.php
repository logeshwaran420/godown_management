@extends('layouts.app')

@section('content')
<div class="w-full mx-auto bg-white px-4 py-6"
     x-data="storeForm({{ $items->toJson() }}, {{ $ledgers->toJson() }})">

    <div class="flex justify-between items-center border-b px-6 py-4">
        <h2 class="text-xl font-semibold">Inwards Entry</h2>
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
    fetch('{{ route('inwards.store') }}', {
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
            window.location.href = "{{ route('inwards') }}"; 
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
@endsection
