{{-- <div>
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
                        @error('barcode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block font-medium text-gray-700 mb-1">Category</label>
                        <select wire:model.defer="category_id" id="category_id" class="w-full mt-1 border rounded p-2">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="unit_id" class="block font-medium text-gray-700 mb-1">Unit</label>
                        <select wire:model.defer="unit_id" id="unit_id" class="w-full mt-1 border rounded p-2">
                            <option value="">Select Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        @error('unit_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    

                    <div>
                        <label for="price" class="block font-medium text-gray-700 mb-1">Price</label>
                        <input wire:model.defer="price" id="price" type="number" step="0.01" class="w-full mt-1 border rounded p-2">
                        @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="hsn_code" class="block font-medium text-gray-700 mb-1">HSN Code</label>
                        <input wire:model.defer="hsn_code" id="hsn_code" type="text" class="w-full mt-1 border rounded p-2">
                        @error('hsn_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="colspan-2">
                        <label for="description" class="block font-medium text-gray-700 mb-1">Description</label>
                        <textarea wire:model.defer="description" id="description" class="w-full mt-1 border rounded p-2" rows="2"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="image" class="block font-medium text-gray-700 mb-1">Image</label>
                        <input wire:model="image" id="image" type="file" class="w-full mt-1 border rounded p-2">
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
</div> --}}
