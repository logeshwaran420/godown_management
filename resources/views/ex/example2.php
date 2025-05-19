<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinkiss Sales</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 p-6">
    <div class="max-w-5xl mx-auto bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="flex justify-between items-center border-b px-6 py-4">
            <div>
                <h2 class="text-xl font-semibold">New Pinkiss Sales <span class="text-orange-500">●</span></h2>
                <p class="text-sm text-gray-500">Not Saved</p>
            </div>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save</button>
        </div>

        <!-- Form Fields -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Phone No</label>
                <input type="text" class="mt-1 block w-full border rounded px-3 py-2 bg-yellow-50" value="1234567809">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="text" class="mt-1 block w-full border rounded px-3 py-2 bg-yellow-50" value="12-05-2025">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Barcode</label>
                <input type="text" class="mt-1 block w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Return Barcode</label>
                <input type="text" class="mt-1 block w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Employee Code</label>
                <input type="text" class="mt-1 block w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Customer</label>
                <input type="text" class="mt-1 block w-full border rounded px-3 py-2 bg-gray-100 font-semibold" value="puppy shame" readonly>
            </div>
            <div class="md:col-span-4">
                <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Send Whatsapp Bill</button>
            </div>
        </div>

        <!-- Item Details Table -->
        <div class="px-6 pb-6">
            <h3 class="font-semibold text-lg mb-4">Sales Item Details</h3>
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-2"><input type="checkbox"></th>
                        <th class="border px-2 py-2">Barcode</th>
                        <th class="border px-2 py-2">Brand</th>
                        <th class="border px-2 py-2">Item</th>
                        <th class="border px-2 py-2">Style No</th>
                        <th class="border px-2 py-2">Colour</th>
                        <th class="border px-2 py-2">Size</th>
                        <th class="border px-2 py-2">Qty</th>
                        <th class="border px-2 py-2">MRP R</th>
                        <th class="border px-2 py-2">Dis %</th>
                        <th class="border px-2 py-2">Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border px-2 py-4 text-center" colspan="11">No Data</td>
                    </tr>
                </tbody>
            </table>
            <button class="mt-4 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Add Row</button>
        </div>
    </div>
</body>

</html>

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center py-3 px-3">
        <h1 class="text-xl font-semibold">Outward Entry</h1>
    </div>
    <form action="{{ route('outwards.store') }}" method="POST" enctype="multipart/form-data" class="flex justify-between max-w-5xl mx-auto gap-10">
        @csrf

        <div class="flex-1 space-y-5">

            <div class="flex items-start">
                <label for="date" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Date</label>
                <div class="w-2/3">
                    <input type="date" id="date" name="date"
                           value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" 
                           class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                           placeholder="Select Date">
                    @error('date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

           <div class="flex items-start">
                <label for="name" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Name</label>
                <div class="w-2/3">
                    <select id="name" name="name" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Select Ledger</option>
                        @foreach($ledgers as $ledger)
                            <option value="{{ $ledger->id }}">{{ $ledger->name }}</option>
                        @endforeach
                    </select>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-start">
                <label for="current_stock" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Item</label>
                <div class="w-2/3 flex gap-4">
                    <input id="current_stock" name="current_stock"
                           placeholder="HSN code"
                           class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" min="0" step="1">
                    @error('current_stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="w-2/3">
                        <input id="unit_id" name="unit_id" type="number"
                               placeholder="Quantity"
                               class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>
                </div>
                @error('unit_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-start">
                <label for="price" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Total Price</label>
                <div class="w-2/3">
                    <input type="text" id="price" name="price" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Total Price" readonly>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center">
                <div class="w-1/3"></div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
            </div>
        </div>

    </form>
</div> 
    
            <div>
                <label class="block text-sm font-medium text-gray-700">Employee Code</label>
                <input type="text" class="mt-1 block w-full border rounded px-3 py-2">
            </div>
--}}
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white px-4 py-6" x-data="outwardEntry({{ $items->toJson() }})">
    <div class="flex justify-between items-center border-b px-6 py-4">
        <div>
            <h2 class="text-xl font-semibold">Outward Entry <span class="text-orange-500">●</span></h2>
        </div>
        <button type="button" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 border-b gap-4 p-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                class="mt-1 block w-full border rounded px-3 py-2">
        </div>

        <div x-data="customerSearch({{ $ledgers->toJson() }})" class="relative w-full">
            <label class="block text-sm font-medium text-gray-700">Customer</label>
            <input type="text" x-model="query" @input="filterList" @focus="showList = true"
                @click.away="showList = false"
                class="mt-1 block w-full border rounded px-3 py-2 bg-white font-semibold"
                placeholder="Customer">
            <ul x-show="showList && filtered.length"
                class="absolute z-10 w-full border mt-1 bg-white rounded shadow max-h-48 overflow-y-auto">
                <template x-for="customer in filtered" :key="customer.id">
                    <li @click="selectCustomer(customer)"
                        class="px-3 py-2 hover:bg-gray-100 cursor-pointer" x-text="customer.name"></li>
                </template>
            </ul>
            <input type="hidden" name="customer_id" :value="selectedId">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Barcode</label>
            <input type="text" id="barcodeInput" placeholder="Enter BarCode"
    x-model="barInput" @change="addItemBybar"
    class="mt-1 block w-full border rounded px-3 py-2" x-ref="barcodeInput">
        </div>
    </div>

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
                        <td class="px-2 py-2">
                            <input type="checkbox" x-model="item.selected" class="form-checkbox">
                        </td>
                        <td class="px-2 py-2" x-text="index + 1"></td>
                        <td class="border px-2 py-2" x-text="item.barcode"></td>
                        <td class="border px-2 py-2" x-text="item.category.name ?? '-'"></td>
                        <td class="border px-2 py-2" x-text="item.name"></td>
                        <td class="border px-2 py-2" x-text="item.hsn_code"></td>
                        <td class="border px-2 py-2" x-text="item.qty"></td>
                        <td class="border px-2 py-2" x-text="item.unit.abbreviation"></td>
                        <td class="border px-2 py-2" x-text="formatPrice(item.price)"></td>
                    </tr>
                </template>
                <tr x-show="selectedItems.length === 0">
                    <td class="border px-2 py-4 text-center" colspan="9">No Data</td>
                </tr>
            </tbody>
        </table>

        <button type="button" x-show="selectedItems.some(i => i.selected)" @click="deleteSelected"
            class="mt-4 bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600">
            Delete Selected
        </button>
    </div>

    <div class="mt-4 border-t pt-4">
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
function outwardEntry(items) {
    return {
        allItems: items,
        selectedItems: [],
        barInput: '',
        addItemBybar() {
            if (!this.barInput.trim()) return;

            let barcode = this.barInput.trim();
    
            let existing = this.selectedItems.find(i => i.barcode.toLowerCase() === barcode.toLowerCase());
            if (existing) {
                existing.qty += 1;
            } else {
                // let item = this.allItems.find(i => i.barcode.toLowerCase() === barcode.toLowerCase());
                
                if (item) {
                    let newItem = { ...item, qty: 1, selected: false };
                    this.selectedItems.push(newItem);
                } 
            }
            this.barInput = '';
            this.$nextTick(() => this.$refs.barcodeInput.focus()); // Autofocus after add
        },
        deleteSelected() {
            this.selectedItems = this.selectedItems.filter(i => !i.selected);
        },
        get totalQty() {
            return this.selectedItems.reduce((sum, i) => sum + i.qty, 0);
        },
        get totalPrice() {
            return this.selectedItems.reduce((sum, i) => sum + (i.qty * i.price), 0);
        },
        formatPrice(value) {
            return new Intl.NumberFormat('en-IN', { minimumFractionDigits: 2 }).format(value);
        }
    }
}

function customerSearch(data) {
    return {
        all: data,
        query: '',  
        filtered: [],
        showList: false,
        selectedId: '',
        filterList() {
            this.filtered = this.all.filter(i => i.name.toLowerCase().includes(this.query.toLowerCase()));
        },
        selectCustomer(customer) {
            this.query = customer.name;
            this.selectedId = customer.id;
            this.showList = false;
        }
    }
}
</script>
@endsection













<script>
       function outwardEntry(items) {

    return {
        allItems: items,
        selectedItems: [],
        barInput: '',
        init() {
            this.$nextTick(() => this.$refs.barcodeInput.focus());
        },
        addItemBybar() {
            // let barcode = this.barInput.trim().toLowerCase();
             let barcode = this.barInput.trim();
            if (!barcode) return;

            // let existing = this.selectedItems.find(i => i.barcode.toLowerCase() === barcode);
            let existing = this.selectedItems.find(i => i.barcode == barcode);
            if (existing) {
                existing.qty += 1;
            } else {
                // let item = this.allItems.find(i => i.barcode.toLowerCase() === barcode);
                let existing = this.selectedItems.find(i => i.barcode == barcode);

                if (item) {
                    this.selectedItems.push({ ...item, qty: 1, selected: false });
   }
            }
            this.barInput = '';
            this.$nextTick(() => this.$refs.barcodeInput.focus());
        },
        deleteSelected() {
            this.selectedItems = this.selectedItems.filter(i => !i.selected);
        },
        get totalQty() {
            return this.selectedItems.reduce((sum, i) => sum + i.qty, 0);
        },
        get totalPrice() {
            return this.selectedItems.reduce((sum, i) => sum + (i.qty * i.price), 0);
        },
        formatPrice(value) {
            if (!value) return '0.00';
            return new Intl.NumberFormat('en-IN', { minimumFractionDigits: 2 }).format(value);
        }
    }
}

   </script>