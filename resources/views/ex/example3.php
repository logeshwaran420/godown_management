
 <div x-data="{ showModal: false }">
   <button @click="showModal = true" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
     New 
    </button>

    <div 
        x-show="showModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        x-cloak
    >
        <!-- Modal Box -->
        <div 
            @click.outside="showModal = false"
            class="bg-white w-full max-w-5xl p-6 rounded-lg shadow-lg"
        >
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Create Item</h2>
                <button @click="showModal = false" class="text-gray-500 hover:text-gray-800 text-2xl">
                    &times;
                </button>
            </div>

            <!-- Modal Form -->
            <form method="POST" action="/items" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Item Name</label>
                        <input name="name" type="text" class="w-full mt-1 border rounded p-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Barcode</label>
                        <input name="barcode" type="text" class="w-full mt-1 border rounded p-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" class="w-full mt-1 border rounded p-2" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Unit</label>
                        <select name="unit_id" class="w-full mt-1 border rounded p-2" required>
                            <option value="">Select Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price</label>
                        <input name="price" type="number" step="0.01" class="w-full mt-1 border rounded p-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Stock</label>
                        <input name="current_stock" type="number" class="w-full mt-1 border rounded p-2" value="0">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">HSN Code</label>
                        <input name="hsn_code" type="text" class="w-full mt-1 border rounded p-2">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" class="w-full mt-1 border rounded p-2" rows="2"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Image</label>
                        <input name="image" type="file" class="w-full mt-1 border rounded p-2">
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="mt-6 flex justify-end space-x-2">
                    <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 

















@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-300 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-100">Outwards</h1>
            <a href="{{ route('outwards.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white text-lg px-6 py-3 rounded-lg shadow-md transition duration-300">
               + Outward
            </a>
        </div>

        <!-- Dark Table -->
        <div class="relative overflow-x-auto bg-gray-800 shadow-lg">
            <table class="w-full text-base text-left text-gray-300">
                <thead class="text-sm uppercase bg-gray-700 text-gray-400 sticky top-0 z-10 rounded-t-lg">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-base">Date</th>
                        <th scope="col" class="px-6 py-4 text-base">Vendor Name</th>
                        <th scope="col" class="px-6 py-4 text-base">Quantity</th>
                        <th scope="col" class="px-6 py-4 text-base">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($outwards as $outward)
                        <tr 
                            class="border-t border-gray-700 hover:bg-gray-700/50 transition cursor-pointer"
                            onclick="window.location='{{ route('outwards.show', $outward) }}'">
                            
                            <!-- Date -->
                            <td class="px-6 py-5 text-gray-200 font-medium text-lg">
                                {{ \Carbon\Carbon::parse($outward->date)->format('d M Y') }}
                            </td>

                            <!-- Vendor Name -->
                            <td class="px-6 py-5 text-lg">
                                {{ $outward->ledger->name }}
                            </td>

                            <!-- Quantity -->
                            <td class="px-6 py-5 text-lg">
                                @php
                                    $unitTotals = [];
                                    foreach ($outward->details as $detail) {
                                        $unit = $detail->item->unit;
                                        $unitId = $unit->id;
                                        $unitName = $unit->abbreviation;
                                        $quantity = $detail->quantity;

                                        if (!isset($unitTotals[$unitId])) {
                                            $unitTotals[$unitId] = ['name' => $unitName, 'qty' => 0];
                                        }

                                        $unitTotals[$unitId]['qty'] += $quantity;
                                    }
                                @endphp

                                @foreach ($unitTotals as $unit)
                                    <div>{{ $unit['qty'] }}{{ $unit['name'] }}</div>
                                @endforeach
                            </td>

                            <!-- Amount -->
                            <td class="px-6 py-5 text-green-400 font-semibold text-lg">
                                ₹{{ number_format($outward->total_amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

                  {{-- <div class="px-4 py-6 border-t border-gray-700 text-base text-gray-400">
                {{ $outwards->links() }}
            </div> --}}
        </div>
    </div>
</div>
@endsection
