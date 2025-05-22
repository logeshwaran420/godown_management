@extends('layouts.app')

@section('content')
@php
   $totalAmount = $movement->items->reduce(function($carry, $detail) {
        return $carry + ($detail->quantity * $detail->item->price);
    }, 0);
@endphp

<div class="w-full mx-auto bg-white px-4 py-6">

 <div class="flex justify-between items-center border-b px-6 py-4">
        <h2 class="text-xl font-semibold">Movements Details</h2>


        <button type="button" 
        onclick="window.location='{{ route('movements.edit',$movement) }}'"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    Edit
</button>
  
    </div>


    <div class="grid grid-cols-1 md:grid-cols-4 border-b gap-4 p-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Date</label>
            <div class="mt-1 text-base text-gray-900">
                {{ $movement->date }}
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">From Warehouse</label>
            <div class="mt-1 text-base text-gray-900">
                {{ $movement->fromWarehouse->name }}
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">To Warehouse</label>
            <div class="mt-1 text-base text-gray-900">
                {{ $movement->toWarehouse->name }}
            </div>
        </div>
    </div>

    <div class="px-6 py-2 pb-6">
        <h3 class="font-semibold text-lg mb-4">Inwards Item Details</h3>
        <table class="min-w-full text-sm text-left text-gray-500 border border-gray-200">
            <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                <tr>
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
            <tbody>
                @foreach ($movement->items as $index => $detail)
                <tr>
                    <td class="border px-6 py-4">
                        {{ $index + 1 }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ $detail->item->barcode }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ $detail->item->category->name }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ $detail->item->name }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ $detail->item->hsn_code }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ $detail->quantity }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ $detail->item->unit->abbreviation }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ $detail->item->price  }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 border-t px-6 py-4">
        <h3 class="font-semibold mb-2">Summary</h3>
        <div class="overflow-x-auto">
            <table class="min-w-max text-sm border">
                <tr>
                    <th class="border px-2 py-2 text-left">Total Qty</th>
                    <td class="border px-2 py-2">
                        {{ $movement->total_quantity }}
                    </td>
                </tr>
                <tr>
                    <th class="border px-2 py-2 text-left">Total Amount</th>
                    <td class="border px-2 py-2">
                        {{ number_format($totalAmount, 2) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

</div>
@endsection
