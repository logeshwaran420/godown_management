@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center py-3 px-3">
            <h1 class="text-xl font-semibold">New Item</h1>
        </div>
        <form action="{{ route('inventory.items.store') }}" method="POST" enctype="multipart/form-data" class="flex justify-between max-w-5xl mx-auto gap-10">
            @csrf

            <div class="flex-1 space-y-5">
                
                <div class="flex items-start">
                    <label for="name" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Name</label>
                    <div class="w-2/3">
                        <input type="text" id="name" name="name" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start">
                    <label for="category_id" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Category</label>
                    <div class="w-2/3">
                        <select id="category_id" name="category_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror 
                    </div>
                </div>

            <div class="flex items-start">
    <label for="unit_id" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Unit</label>
    <div class="w-2/3 flex gap-4">
        <div class="w-2/3">
        <input type="number" id="current_stock" name="current_stock" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" min="0" step="1">
    </div>
    @error('current_stock')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror   
        </select>
        
        <select id="unit_id" name="unit_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @foreach($units as $unit)
                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
            @endforeach
        </select>
    </div>
    @error('unit_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


                <!-- Stock Input added below -->
                <div class="flex items-start">
                    <label for="stock" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Stock</label>
                    <div class="w-2/3">
                        <input type="number" id="stock" name="stock" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="0">
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start">
                    <label for="hsn_code" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">HSN Code</label>
                    <div class="w-2/3">
                        <input type="text" id="hsn_code" name="hsn_code" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="HSN code">
                        @error('hsn_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start">
                    <label for="description" class="w-1/3 pt-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <div class="w-2/3">
                        <textarea id="description" name="description" rows="3" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter item description..."></textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start">
                    <label for="price" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Price</label>
                    <div class="w-2/3">
                        <input type="number" id="price" name="price" step="0.01" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="0.00">
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

            <div class="w-40">
                <label for="image" class="flex flex-col items-center justify-center h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5A5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="image" name="image" type="file" class="hidden" />
                </label>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </form>
    </div>
</div>
@endsection
