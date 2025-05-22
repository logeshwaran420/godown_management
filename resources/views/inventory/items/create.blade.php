@extends('layouts.app')

@section('content')

<div class="w-full mx-auto bg-white px-4 py-6">

    <form action="{{ route('inventory.items.store') }}" method="POST" enctype="multipart/form-data" class="p-6" id="create-item-form">
        @csrf

        <div class="flex justify-between items-center border-b px-6 py-4 mb-6">
            <h2 class="text-xl font-semibold">Create New Item</h2>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Create
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 border-b gap-4 pb-6">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="mt-1 block w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode</label>
                <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}"
                    class="mt-1 block w-full border rounded px-3 py-2 @error('barcode') border-red-500 @enderror" required>
                @error('barcode')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id" required
                    class="mt-1 block w-full border rounded px-3 py-2 bg-white @error('category_id') border-red-500 @enderror">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="hsn_code" class="block text-sm font-medium text-gray-700">HSN Code</label>
                <input type="text" name="hsn_code" id="hsn_code" value="{{ old('hsn_code') }}"
                    class="mt-1 block w-full border rounded px-3 py-2 @error('hsn_code') border-red-500 @enderror">
                @error('hsn_code')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 border-b gap-4 py-6">

            <div>
                <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit</label>
                <select name="unit_id" id="unit_id" required
                    class="mt-1 block w-full border rounded px-3 py-2 bg-white @error('unit_id') border-red-500 @enderror">
                    <option value="">Select Unit</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" @if(old('unit_id') == $unit->id) selected @endif>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
                @error('unit_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
                    class="mt-1 block w-full border rounded px-3 py-2 @error('price') border-red-500 @enderror" required>
                @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="current_stock" class="block text-sm font-medium text-gray-700">Current Stock</label>
                <input type="number" name="current_stock" id="current_stock" value="{{ old('current_stock', 0) }}"
                    class="mt-1 block w-full border rounded px-3 py-2 @error('current_stock') border-red-500 @enderror" min="0" required>
                @error('current_stock')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" 
                    class="mt-1 block w-full text-sm text-gray-500">
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="py-6">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full border rounded px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

    </form>
</div>

@endsection
