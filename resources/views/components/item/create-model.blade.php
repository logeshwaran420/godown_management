  <div id="modalOverlay" class="fixed inset-0 z-50 overflow-y-auto" style="display:none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div id="modalBg" class="fixed inset-0 transition-opacity ease-in-out duration-300" aria-hidden="true" style="background:rgba(17,24,39,0.75);"></div>

            <div id="modalContent"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                
                <!-- Header -->
           <div class="bg-blue-600 px-4 py-3 sm:px-6">
    <div class="flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-white">
                        Add New Inventory Item
                    </h3>
                    <button id="closeModalBtn" type="button" class="text-blue-100 hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
           </div>
                
                <!-- Form Content -->
                <div class="bg-white">
                    <form action="{{ route('inventory.items.store') }}" method="POST" enctype="multipart/form-data" id="create-item-form">
                        @csrf
                        <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <!-- Name -->
                                <div class="sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Item Name <span class="text-red-500">*</span></label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <input type="text" name="name" id="name"
                                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="e.g. Premium Widget X200" required>
                                    </div>
                                    <span class="mt-1 text-sm text-red-600" id="error_name"></span>
                                </div>

                                <!-- Barcode -->
                                <div class="sm:col-span-3">
                                    <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>
                                            <input type="text" name="barcode" id="barcode"
                                                   class="block w-full pl-10 pr-12 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="Scan or enter barcode" required>
                                        </div>
                                        <button type="button" id="generateBarcodeBtn" class="ml-1 inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            Generate
                                        </button>
                                    </div>
                                    <span class="mt-1 text-sm text-red-600" id="error_barcode"></span>
                                </div>

                                <!-- Category -->
                                <div class="sm:col-span-2">
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                                    <div class="mt-1 relative">
                                        <select name="category_id" id="category_id" required
                                                class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="mt-1 text-sm text-red-600" id="error_category_id"></span>
                                </div>

                                <!-- HSN Code -->
                                <div class="sm:col-span-2">
                                    <label for="hsn_code" class="block text-sm font-medium text-gray-700">HSN Code</label>
                                    <div class="mt-1">
                                        <input type="text" name="hsn_code" id="hsn_code"
                                               class="block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Enter HSN code" required>
                                    </div>
                                    <span class="mt-1 text-sm text-red-600" id="error_hsn_code"></span>
                                </div>

                                <!-- Unit -->
                                <div class="sm:col-span-2">
                                    <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit <span class="text-red-500">*</span></label>
                                    <div class="mt-1 relative">
                                        <select name="unit_id" id="unit_id" required
                                                class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option value="">Select Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="mt-1 text-sm text-red-600" id="error_unit_id"></span>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                               <div class="sm:col-span-2">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price <span class="text-red-500">*</span></label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">₹</span>
                                        </div>
                                        <input type="number" step="0.01" min="0" name="price" id="price"
                                               class="block w-full pl-7 pr-12 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="0.00" required>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">INR</span>
                                        </div>
                                    </div>
                                    <span class="mt-1 text-sm text-red-600" id="error_price"></span>
                                </div>

                                <!-- Image Upload -->
                                <div class="sm:col-span-4">
                                    <label class="block text-sm font-medium text-gray-700">Product Image</label>
                                    <div class="mt-1 flex items-center space-x-4">
                                        <div class="relative group">
                                           <div class="h-24 w-24 rounded-md overflow-hidden bg-gray-100 group-hover:opacity-75 flex items-center justify-center">
    <img id="imagePreview" class="h-full w-full object-cover" style="display:none;" alt="Product image">
    <svg id="imagePlaceholder" class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
    </svg>
</div>

                                          
                                            <button id="removeImageBtn" type="button" class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded hover:bg-opacity-70" style="display:none;">
                                                Remove
                                            </button>
                                        </div>
                                        <div class="flex-1">
                                            <label for="image" class="cursor-pointer">
                                                <div class="border-2 border-dashed border-gray-300 rounded-md px-6 pt-5 pb-6 flex justify-center hover:border-blue-500 transition-colors duration-150">
                                                    <div class="space-y-1 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <div class="flex text-sm text-gray-600 justify-center">
                                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                                <span>Upload a file</span>
                                                                <input id="image" name="image" type="file" class="sr-only" accept="image/jpeg,image/png,image/gif">
                                                            </label>
                                                            <p class="pl-1">or drag and drop</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <span class="mt-1 text-sm text-red-600" id="error_image"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="px-4 py-5 sm:px-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <div class="mt-1">
                                <textarea id="description" name="description" rows="4"
                                          class="block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Provide detailed information about this product..."></textarea>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Brief description for your inventory item.</p>
                            <span class="mt-1 text-sm text-red-600" id="error_description"></span>
                        </div>


                        
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="button" id="cancelBtn" class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                Cancel
                            </button>
                            <button type="submit" id="submitBtn" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                <span id="submitText">Save Item</span>
                                <span id="spinner" class="ml-2 hidden">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>