@extends('layouts.app')

@section('content')

<div class="px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white">
        {{-- Header with Title and Actions --}}
        <div class="bg-gradient-to-r from-blue-50 to-gray-50 px-6 py-5 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    {{ $item->name }}
                </h1>
                <div class="flex flex-wrap items-center gap-2 mt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $item->category->name }}
                    </span>
                    @if($item->barcode)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Barcode: {{ $item->barcode }}
                    </span>
                    @endif
                </div>
            </div>
            
            <div class="flex flex-wrap gap-3">
 <a href="{{ route('inwards.create', ['item' => $item]) }}" 
        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Inward
    </a>


                <button 
                   id="openModalBtn"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit 
                </button>

                <form action="{{ route('inventory.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');" class="inline">
                    @csrf
                    @method('DELETE')
                       <button type="button" 
                    onclick="confirmDelete()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>



        {{-- <form action="{{ route('ledgers.destory', $ledger->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="button" 
                    onclick="confirmDelete()"
                    class="px-4 py-2 border border-red-300 rounded-md text-red-700 hover:bg-red-50 transition flex items-center justify-center dark:border-red-700 dark:text-red-400 dark:hover:bg-red-900/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Delete
                </button>
            </form> --}}

        {{-- Main Content --}}
        <div class="divide-y divide-gray-200">
            {{-- Basic Info Section --}}
            <div class="px-6 py-5">
                <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Basic Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Item Name</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $item->name }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Category</p>
                        <p class="mt-1 text-lg text-gray-900">{{ $item->category->name }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Unit</p>
                        <p class="mt-1 text-lg text-gray-900">{{ $item->unit->name }} ({{ $item->unit->abbreviation }})</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Barcode</p>
                        <p class="mt-1 text-lg font-mono text-gray-900">{{ $item->barcode ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">HSN Code</p>
                        <p class="mt-1 text-lg text-gray-900">{{ $item->hsn_code ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Price</p>
                        <p class="mt-1 text-lg text-gray-900">₹{{ number_format($item->price, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- Stock Summary Section --}}
            <div class="px-6 py-5">
                <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Stock Summary
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <p class="text-sm font-medium text-blue-800">Total Quantity</p>
                        <div class="mt-2 flex items-baseline">
                            <p class="text-3xl font-bold text-blue-900">{{ $item->current_stock }}</p>
                            <p class="ml-2 text-sm font-medium text-blue-700">{{ $item->unit->abbreviation }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                        <p class="text-sm font-medium text-green-800">Unit Price</p>
                        <div class="mt-2 flex items-baseline">
                            <p class="text-3xl font-bold text-green-900">₹{{ number_format($item->price, 2) }}</p>
                        </div>
                    </div>
                    
                    {{-- <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                        <p class="text-sm font-medium text-purple-800">Total Inventory Value</p>
                        <div class="mt-2 flex items-baseline">
                            <p class="text-3xl font-bold text-purple-900">₹{{ number_format($item->current_stock * $item->price, 2) }}</p>
                        </div>
                    </div> --}}
                </div>
            </div>

            {{-- Warehouse Inventory Section --}}
            <div class="px-6 py-5">
                <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                    Warehouse Inventory
                </h2>
                
                @if($item->inventories->isEmpty())
                    <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No inventory data</h3>
                        <p class="mt-1 text-sm text-gray-500">This item hasn't been added to any warehouses yet.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($item->inventories as $inventory)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                                <div class="px-4 py-3 bg-gray-50 border-b flex justify-between items-center">
                                    <h4 class="font-medium text-gray-800 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        {{ $inventory->warehouse->name }}
                                    </h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $inventory->warehouse->code }}
                                    </span>
                                </div>
                                <div class="p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center">
                                            <p class="text-sm font-medium text-gray-500">Current Stock</p>
                                            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $inventory->current_stock }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->unit->abbreviation }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-sm font-medium text-gray-500">Inventory Value</p>
                                            <p class="mt-1 text-2xl font-bold text-green-600">₹{{ number_format($inventory->current_stock * $item->price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<x-item.edit-model :item="$item"  :categories="$categories" :units="$units"/>


<div id="deleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Item</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Are you sure you want to delete this Item? All of the data will be permanently removed. This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    function confirmDelete() {
        document.getElementById('deleteForm').action = "{{ route('inventory.items.destroy', $item) }}";
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

document.addEventListener('DOMContentLoaded', function () {

    const openModalBtn = document.getElementById('openModalBtn');
    const modalOverlay = document.getElementById('modalOverlay');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('create-item-form');
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const imagePlaceholder = document.getElementById('imagePlaceholder');
    const removeImageBtn = document.getElementById('removeImageBtn');
    const generateBarcodeBtn = document.getElementById('generateBarcodeBtn');
    const barcodeInput = document.getElementById('barcode');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const spinner = document.getElementById('spinner');

    // Open/Close modal
    function openModal() {
        modalOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modalOverlay.style.display = 'none';
        document.body.style.overflow = 'auto';
        resetForm();
    }

    function resetForm() {
        form.reset();
        imagePreview.src = '';
        imagePreview.style.display = 'none';
        imagePlaceholder.style.display = 'block';
        removeImageBtn.style.display = 'none';
        
        // Clear all error messages
        document.querySelectorAll('[id^="error_"]').forEach(el => {
            el.textContent = '';
        });
    }

    openModalBtn.addEventListener('click', openModal);
    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
  
    // Generate random barcode
    generateBarcodeBtn.addEventListener('click', function () {
        const randomBarcode = 'BC' + Math.floor(100000000 + Math.random() * 900000000);
        barcodeInput.value = randomBarcode;
    });

    // Image preview and validation
    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        const errorSpan = document.getElementById('error_image');

        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                errorSpan.textContent = 'Only JPG, PNG or GIF images are allowed';
                imageInput.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                errorSpan.textContent = 'Image size must be less than 2MB';
                imageInput.value = '';
                return;
            }

            errorSpan.textContent = '';

            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                imagePlaceholder.style.display = 'none';
                removeImageBtn.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }
    });

    removeImageBtn.addEventListener('click', function () {
        imageInput.value = '';
        imagePreview.src = '';
        imagePreview.style.display = 'none';
        imagePlaceholder.style.display = 'block';
        removeImageBtn.style.display = 'none';
        document.getElementById('error_image').textContent = '';
    });

    // Form submission
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Clear previous errors
        document.querySelectorAll('[id^="error_"]').forEach(el => {
            el.textContent = '';
        });
        
        // Show loading state
        submitText.textContent = 'Saving...';
        spinner.classList.remove('hidden');
        submitBtn.disabled = true;
        
        // Prepare form data
        const formData = new FormData(form);
        
        // Submit via fetch API
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                

                
            // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
        })
        .then(response => {
    if (!response.ok) {
        return response.json().then(err => { throw err; });
    }
    return response.json();
})

        .then(data => {
           
            resetForm();
            closeModal();
            alert('Item added successfully!');
            
        })
        .catch(error => {
            if (error.errors) {
                Object.entries(error.errors).forEach(([field, messages]) => {
                    const errorElement = document.getElementById(`error_${field}`);
                    if (errorElement) {
                        errorElement.textContent = messages.join(' ');
                    }
                });
            } else {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        })
        .finally(() => {
            // Reset button state
            submitText.textContent = 'Save Item';
            spinner.classList.add('hidden');
            submitBtn.disabled = false;
        });
    });

   modalOverlay.addEventListener('click', function (e) {
        if (e.target === modalOverlay) {
            closeModal();
        }
    });
});
</script>

@endsection