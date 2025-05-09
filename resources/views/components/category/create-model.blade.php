<div id="create-category-modal" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full h-full bg-gray-500 bg-opacity-50 flex justify-center items-center">
    <div class="relative p-4 w-full max-w-md max-h-full bg-white rounded-lg shadow-lg dark:bg-gray-700">
 
        <div class="relative">
         
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Create New Category
                </h3>
       
                <button id="close-modal" type="button" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('inventory.categories.store') }}" method="POST" class="p-4">
                @csrf
            <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" id="name" name="name"
                        class="mt-2 block w-full p-2 border rounded-md dark:bg-gray-600 dark:border-gray-500 dark:text-white 
                        @error('name') border-red-500 @else border-gray-300 @enderror"
                        required  placeholder="Category Name" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> 
            
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="mt-2 block w-full p-2 border rounded-md dark:bg-gray-600 dark:border-gray-500 dark:text-white 
                        @error('description') border-red-500 @else border-gray-300 @enderror"
                        required placeholder="Category Description">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            
                <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none">
                    Add New Category
                </button>
            </form>
            
        </div>
    </div>
</div>