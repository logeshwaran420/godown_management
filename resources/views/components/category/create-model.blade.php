<div id="create-category-modal" tabindex="-1" aria-hidden="true" 
     class="hidden fixed inset-0 z-50 w-full h-full bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="relative w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden dark:bg-gray-800 animate-[slideDown_0.3s_ease-out]">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-blue-600 mr-2 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Create New Category
                </h3>
            </div>
            <button id="close-modal" type="button" 
                    class="text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        <!-- Modal body -->
        <form action="{{ route('inventory.categories.store') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" required
                    class="w-full p-3 text-sm rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                           @error('name') border-red-500 bg-red-50 focus:ring-red-500 @else border-gray-300 dark:border-gray-600 @enderror
                           dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="e.g. Electronics, Furniture" 
                    value="{{ old('name') }}">
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div> 
        
            <div class="mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Description
                </label>
                <textarea id="description" name="description" rows="4"
                    class="w-full p-3 text-sm rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                           @error('description') border-red-500 bg-red-50 focus:ring-red-500 @else border-gray-300 dark:border-gray-600 @enderror
                           dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Modal footer -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg 
                           focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 
                           dark:focus:ring-blue-800 transition-colors flex items-center justify-center">
                    {{-- <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg> --}}
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>