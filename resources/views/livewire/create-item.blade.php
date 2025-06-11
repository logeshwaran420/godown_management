<div>
    <button wire:click="$set('showModal', true)"   type="button" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
       + New
    </button>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white w-full max-w-5xl p-6 rounded-lg shadow-lg relative">
            
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Create Item</h2>
                <button wire:click="$set('showModal', false)" type="button" class="text-gray-500 hover:text-gray-800 text-2xl absolute top-4 right-4">&times;</button>
            </div>

            <!-- Form -->
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <!-- Item Fields -->
                    <div>
                        <label for="name" class="block font-medium text-gray-700 mb-1">Item Name</label>
                        <input wire:model.defer="name" id="name" type="text" class="w-full mt-1 border rounded p-2">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
 
                    <div>
                        <label for="barcode" class="block font-medium text-gray-700 mb-1">Barcode</label>
                        <input  wire:model.defer="barcode" id="barcode" type="text" class="w-full mt-1 border rounded p-2">
                        {{-- @error('barcode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror --}}
                    </div>

                    <div>
                        <label for="category_id" class="block font-medium text-gray-700 mb-1">Category</label>
                        <select wire:model.defer="category_id" id="category_id" class="w-full mt-1 border rounded p-2">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        {{-- @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror --}}
                    </div>

                    <div>
                        <label for="unit_id" class="block font-medium text-gray-700 mb-1">Unit</label>
                        <select wire:model.defer="unit_id" id="unit_id" class="w-full mt-1 border rounded p-2">
                            <option value="">Select Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        {{-- @error('unit_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror --}}
                    </div>

                    

                    <div>
                        <label for="price" class="block font-medium text-gray-700 mb-1">Price</label>
                        <input wire:model.defer="price" id="price" type="number" step="0.01" class="w-full mt-1 border rounded p-2">
                        {{-- @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror --}}
                    </div>

                    <div>
                        <label for="hsn_code" class="block font-medium text-gray-700 mb-1">HSN Code</label>
                        <input wire:model.defer="hsn_code" id="hsn_code" type="text" class="w-full mt-1 border rounded p-2">
                        {{-- @error('hsn_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror --}}
                    </div>

                    <div class="colspan-2">
                        <label for="description" class="block font-medium text-gray-700 mb-1">Description</label>
                        <textarea wire:model.defer="description" id="description" class="w-full mt-1 border rounded p-2" rows="2"></textarea>
                        {{-- @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror --}}
                    </div>

                    <div>
                        <label for="image" class="block font-medium text-gray-700 mb-1">Image</label>
                        <input wire:model="image" id="image" type="file" class="w-full mt-1 border rounded p-2">
                        {{-- @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror --}}
                    </div>

                <div class="mt-20  justify-end space-x-2">
                    <button type="button" wire:click="$set('showModal', false)" class="px-2 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div> 
{{-- <div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Form Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create New Inventory Item</h1>
                <p class="mt-2 text-sm text-gray-600">Add a new product to your inventory management system</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('inventory.items') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </a>
                <button wire:click="save"
                        class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Item
                </button>
            </div>
        </div>

        <!-- Main Form -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <!-- Basic Information Section -->
            <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
                <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Basic Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Essential details about the inventory item.</p>
                    </div>
                </div>
                
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- Name -->
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium text-gray-700">Item Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <input type="text" wire:model="name" id="name"
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                   placeholder="e.g. Premium Widget X200" required>
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Barcode -->
                    <div class="sm:col-span-3">
                        <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <input type="text" wire:model="barcode" id="barcode"
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('barcode') border-red-500 @enderror"
                                   placeholder="Scan or enter barcode" required>
                        </div>
                        @error('barcode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="sm:col-span-2">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative">
                            <select wire:model="category_id" id="category_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('category_id') border-red-500 @enderror">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- HSN Code -->
                    <div class="sm:col-span-2">
                        <label for="hsn_code" class="block text-sm font-medium text-gray-700">HSN Code</label>
                        <div class="mt-1">
                            <input type="text" wire:model="hsn_code" id="hsn_code"
                                   class="block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('hsn_code') border-red-500 @enderror"
                                   placeholder="Enter HSN code">
                        </div>
                        @error('hsn_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Unit -->
                    <div class="sm:col-span-2">
                        <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative">
                            <select wire:model="unit_id" id="unit_id" required
                                    class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('unit_id') border-red-500 @enderror">
                                <option value="">Select Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                </svg>
                            </div>
                        </div>
                        @error('unit_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing & Image Section -->
            <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Pricing & Media</h3>
                <p class="mt-1 text-sm text-gray-500">Financial details and product images.</p>
                
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- Price -->
                    <div class="sm:col-span-2">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₹</span>
                            </div>
                            <input type="number" step="0.01" wire:model="price" id="price"
                                   class="block w-full pl-7 pr-12 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror"
                                   placeholder="0.00" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">INR</span>
                            </div>
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="sm:col-span-4">
                        <label class="block text-sm font-medium text-gray-700">Product Image</label>
                        <div class="mt-1 flex items-center space-x-4">
                            <div class="relative group">
                                <div class="h-24 w-24 rounded-md overflow-hidden bg-gray-100 group-hover:opacity-75">
                                    @if($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="h-full w-full object-cover" alt="Preview">
                                    @else
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">Preview</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <label for="image" class="cursor-pointer">
                                    <div class="border-2 border-dashed border-gray-300 rounded-md px-6 pt-5 pb-6 flex justify-center">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                    <span>Upload a file</span>
                                                    <input id="image" type="file" wire:model="image" class="sr-only">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="px-4 py-5 sm:px-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <div class="mt-1">
                    <textarea id="description" wire:model="description" rows="4"
                              class="block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                              placeholder="Provide detailed information about this product..."></textarea>
                </div>
                <p class="mt-2 text-sm text-gray-500">Brief description for your inventory item.</p>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div> --}}