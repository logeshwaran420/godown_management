@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="flex justify-between items-center py-3 px-3">
        <h1 class="text-xl font-semibold">All Stocks</h1> 
        <!-- Button to open modal -->
        <button id="open-modal" class="bg-blue-600 text-white px-3 py-1 rounded">+ New</button>
    </div>

    <div class="relative overflow-x-auto">    
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="sticky top-0 bg-gray-50 dark:bg-gray-700 z-10">
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categories as $category)
               <tr class="group bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
        {{ $category->name }}
    </td>
    <td class="px-6 py-4">
        {{ $category->description }}
    </td>
    <td class="px-6 py-4 ">
        <button 
            class="text-blue-500  hover:underline font-semibold edit-btn opacity-0 group-hover:opacity-100 transition duration-200"
            data-action="{{ route('inventory.categories.update', $category) }}"
            data-id="{{ $category->id }}"
            data-name="{{ $category->name }}"
            data-description="{{ $category->description }}">
            Edit
        </button>
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

<!-- Modals -->
<x-category.create-model />
<x-category.edit-model />

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const createModal = document.getElementById("create-category-modal");
    const editModal = document.getElementById("edit-category-modal");

    const openCreateModalButton = document.getElementById("open-modal");
    const closeCreateModalButton = document.getElementById("close-modal");
    const closeEditModalButton = document.getElementById("close-edit-modal");

    const editButtons = document.querySelectorAll(".edit-btn");

    // Open create modal
    openCreateModalButton.addEventListener("click", function() {
        document.getElementById("edit-category-form").reset();
        document.getElementById("modal-title").textContent = "Create New Category";
        document.getElementById("edit-category-form").action = "{{ route('inventory.categories.store') }}";
        createModal.classList.remove("hidden");
    });

    // Open edit modal
    editButtons.forEach(button => {
        button.addEventListener("click", function() {
            const name = button.getAttribute('data-name');
            const desc = button.getAttribute('data-description');
            const id = button.getAttribute('data-id');
            const action = button.getAttribute('data-action');

            document.getElementById("edit-name").value = name;
            document.getElementById("edit-description").value = desc;
            document.getElementById("category-id").value = id;
            document.getElementById("edit-category-form").action = action;

            document.getElementById("modal-title").textContent = "Edit Category";
            editModal.classList.remove("hidden");
        });
    });

    closeCreateModalButton?.addEventListener("click", () => createModal.classList.add("hidden"));
    closeEditModalButton?.addEventListener("click", () => editModal.classList.add("hidden"));

    window.addEventListener("click", function(e) {
        if (e.target === createModal) createModal.classList.add("hidden");
        if (e.target === editModal) editModal.classList.add("hidden");
    });
});
</script>
@endsection
