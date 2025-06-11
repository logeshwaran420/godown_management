@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
 
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">Inventory Management</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Track and manage your product inventory</p>
            </div>

            <div class="flex items-center gap-3">
                 <div class="flex items-center gap-3">
          <div class="relative">
    <input type="text" id="itemSearchInput" placeholder="Search Items..."
        class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
        fill="currentColor">
        <path fill-rule="evenodd"
            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
            clip-rule="evenodd" />
    </svg>
    <ul id="itemsugession"
        class="absolute z-10 mt-1 w-full bg-white border rounded-md shadow-md max-h-60 overflow-y-auto hidden">
    </ul>
</div>




<script>
    document.addEventListener("DOMContentLoaded", function () {
        const input = document.getElementById("itemSearchInput");
        const suggestions = document.getElementById("itemsugession");

        input.addEventListener("input", function () {
            const query = this.value;

            if (query.length < 2) {
                suggestions.innerHTML = '';
                suggestions.classList.add("hidden");
                return;
            }

            fetch(`/search?q=${encodeURIComponent(query)}&type=item`)
                .then(response => response.json())
                .then(data => {
                    suggestions.innerHTML = '';
                    if (data.length > 0) {
                       data.forEach(item => {
    const li = document.createElement("li");
    li.innerHTML = `<h2>${item.name}</h2> `;
    li.className = "px-4 py-2 hover:bg-blue-100 cursor-pointer";
    li.addEventListener("click", function () {
        window.location.href = `/inventory/items/show/${item.id}`;
    });
    suggestions.appendChild(li);
});

                        suggestions.classList.remove("hidden");
                    } else {
                        suggestions.classList.add("hidden");
                    }
                });
        });
    });
</script>














                <button type="button"id="openModalBtn" 
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New Item
                </button>



                

 <x-item.create-model :categories="$categories" :units="$units" />
            </div>
        </div>

    </div>

 

    <!-- Inventory Table Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">HSN Code</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Unit</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rate</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Value</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($inventories as $inventory)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer"      onclick="window.location='{{ route('inventory.items.show', $inventory) }}'">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">

    <div class="flex-shrink-0 h-10 w-10 rounded-md overflow-hidden bg-gray-200">
    @if($inventory->image )
        <img src="{{ asset('storage/' . $inventory->image) }}" alt="Product" class="h-full w-full object-cover">
    @else
        <svg class="h-full w-full text-gray-400 p-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
        </svg>
    @endif
</div>



                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $inventory->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $inventory->category->name ?? 'Uncategorized' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $inventory->hsn_code }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex flex-col items-end">
                                    <span class="text-sm font-medium {{ $inventory->current_stock <= $inventory->low_stock_threshold ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                                        {{ $inventory->current_stock }}
                                    </span>
                                    @if($inventory->current_stock <= $inventory->low_stock_threshold)
                                        <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Low stock
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $inventory->unit->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-400">
                                ₹{{ number_format($inventory->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">
                                ₹{{ number_format($inventory->current_stock * $inventory->price, 2) }}
                            </td>
                          
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

 @if($inventories->hasPages())
<div class="flex flex-col sm:flex-row items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
    <!-- Items per page selector -->
    <div class="flex items-center mb-4 sm:mb-0">
        <span class="text-sm text-gray-700 dark:text-gray-300 mr-2">Items per page:</span>
        <select onchange="window.location.href = this.value" 
                class="text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @foreach ([5, 10, 25, 50, 100] as $size)
                <option value="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" 
                        {{ $perPage == $size ? 'selected' : '' }}>
                    {{ $size }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Pagination links -->
     <div class="flex items-center space-x-1">
       
        <a href="{{ $inventories->url(1) }}" 
           class="px-3 py-1 rounded-md text-sm font-medium {{ $inventories->currentPage() == 1 ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            &laquo;
        </a>

        <a href="{{ $inventories->previousPageUrl() }}" 
           class="px-3 py-1 rounded-md text-sm font-medium {{ $inventories->onFirstPage() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            &lsaquo;
        </a>

      
        @foreach ($inventories->getUrlRange(max(1, $inventories->currentPage() - 2), min($inventories->lastPage(), $inventories->currentPage() + 2)) as $page => $url)
            <a href="{{ $url }}" 
               class="px-3 py-1 rounded-md text-sm font-medium {{ $page == $inventories->currentPage() ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                {{ $page }}
            </a>
        @endforeach

        <!-- Next Page Link -->
        <a href="{{ $inventories->nextPageUrl() }}" 
           class="px-3 py-1 rounded-md text-sm font-medium {{ !$inventories->hasMorePages() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            &rsaquo;
        </a>

        <!-- Last Page Link -->
        <a href="{{ $inventories->url($inventories->lastPage()) }}" 
           class="px-3 py-1 rounded-md text-sm font-medium {{ $inventories->currentPage() == $inventories->lastPage() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            &raquo;
        </a>
    </div>

    <!-- Showing results info -->
    <div class="text-sm text-gray-700 dark:text-gray-300 mt-4 sm:mt-0">
        Showing <span class="font-medium">{{ $inventories->firstItem() }}</span> to 
        <span class="font-medium">{{ $inventories->lastItem() }}</span> of 
        <span class="font-medium">{{ $inventories->total() }}</span> results
    </div>

    </div>
@endif


</div>









<script>
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