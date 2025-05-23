@extends('layouts.app')

@section('content')

<div class="w-full max-w-5xl mx-auto bg-white px-4 py-6 rounded shadow">
    <form action="{{ route('inventory.items.update', $item) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex justify-between items-center border-b px-6 py-4">
            <h2 class="text-xl font-semibold">Edit Item</h2>
            <button type="submit" id="saveBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-6 py-6">

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $item->name) }}"
                       class="mt-1 block w-full border rounded px-3 py-2">
            </div>

            <!-- Barcode -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Barcode</label>
                <input type="text" name="barcode" value="{{ old('barcode', $item->barcode) }}"
                       class="mt-1 block w-full border rounded px-3 py-2">
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" class="mt-1 block w-full border rounded px-3 py-2 bg-white" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Unit -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Unit</label>
                <select name="unit_id" class="mt-1 block w-full border rounded px-3 py-2 bg-white" required>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}"
                            {{ old('unit_id', $item->unit_id) == $unit->id ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" name="price" value="{{ old('price', $item->price) }}" step="0.01"
                       class="mt-1 block w-full border rounded px-3 py-2">
            </div>

            {{-- <!-- Current Stock -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Current Stock</label>
                <input type="number" name="current_stock" value="{{ old('current_stock', $item->current_stock) }}"
                       class="mt-1 block w-full border rounded px-3 py-2">
            </div> --}}

            <!-- HSN Code -->
            <div>
                <label class="block text-sm font-medium text-gray-700">HSN Code</label>
                <input type="text" name="hsn_code" value="{{ old('hsn_code', $item->hsn_code) }}"
                       class="mt-1 block w-full border rounded px-3 py-2">
            </div>

            <!-- Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Image</label>
                @if($item->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Current Image" class="h-16">
                    </div>
                @endif
                <input type="file" name="image" class="block w-full text-sm text-gray-500">
            </div>

            <!-- Description -->
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="4"
                          class="mt-1 block w-full border rounded px-3 py-2">{{ old('description', $item->description) }}</textarea>
            </div>
        </div>
    </form>
</div>

@endsection
