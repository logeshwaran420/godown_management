
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