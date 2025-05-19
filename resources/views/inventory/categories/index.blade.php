@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="flex justify-between items-center py-3 px-3">
        <h1 class="text-xl font-semibold">All Stocks</h1> 
        <!-- Button to open modal -->
        <button id="open-modal" class="bg-blue-600 text-white px-3 py-1 rounded">+ New</button>
    </div>

    <div class="relative overflow-x-auto">    
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="sticky top-0 bg-gray-50 dark:bg-gray-700 z-10">
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categories as $category)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 group">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $category->name }}</a>
                    </th>
                    <td class="px-6 py-4">
                        {{ $category->description }}
                    </td>
                    <td class="px-6 py-4">
                 <div class="invisible group-hover:visible flex space-x-1">
                    <button 
    class="text-blue-600 hover:underline edit-btn"
    data-action="{{ route('inventory.categories.update', $category) }}"
    data-id="{{ $category->id }}"
    data-name="{{ $category->name }}"
    data-description="{{ $category->description }}">
    Edit
</button>

 <form action="{{ route( 'inventory.categories.destroy',   $category) }}" method="POST"
  onsubmit="return confirm('Are you sure you want to delete this ledger?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:underline bg-transparent p-0 m-0 border-0 cursor-pointer">
                Delete
            </button>
        </form>
                 </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>

</div>

<x-category.create-model/>




<x-category.edit-model/>

@endsection

<script>
 document.addEventListener('DOMContentLoaded', function() {
    const createModal = document.getElementById("create-category-modal");
    const editModal = document.getElementById("edit-category-modal");
    
    const openCreateModalButton = document.getElementById("open-modal");
    const closeCreateModalButton = document.getElementById("close-modal");
    const closeEditModalButton = document.getElementById("close-edit-modal");    
    const editButtons = document.querySelectorAll(".edit-btn");

    openCreateModalButton.addEventListener("click", function() {
      
        document.getElementById("edit-category-form").reset();
        document.getElementById("edit-category-form").
        action = "{{ route('inventory.categories.store') }}"
        ;
        createModal.classList.remove("hidden");
    });

    
 editButtons.forEach(button => {
    button.addEventListener("click", function(event) {
        const categoryName = button.getAttribute('data-name');
        const categoryDescription = button.getAttribute('data-description');
        const categoryId = button.getAttribute('data-id');
        const categoryAction = button.getAttribute('data-action');

        document.getElementById("edit-name").value = categoryName;
        document.getElementById("edit-description").value = categoryDescription;
        document.getElementById("category-id").value = categoryId;

        document.getElementById("modal-title").textContent = "Edit Category";
        document.getElementById("edit-category-form").action = categoryAction;

        editModal.classList.remove("hidden");
    });
});

 
    closeCreateModalButton.addEventListener("click", function() {
        createModal.classList.add("hidden");
    });

    closeEditModalButton.addEventListener("click", function() {
        editModal.classList.add("hidden");
    });

  
});

</script>
