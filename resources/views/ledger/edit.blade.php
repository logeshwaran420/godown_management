@extends('layouts.app')

@section('content')


<div class="container mx-auto px-4 py-6">
 

    <button id="openModalBtn" type="button"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Add New Item
    </button>

  
</div>







 <x-ledger.edit-model 
 
    :ledger="$ledger"
    />





















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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const countryDropdown = document.getElementById('country');
    const stateDropdown = document.getElementById('state');
    const cityDropdown = document.getElementById('city');

    const currentCountry = "{{ old('country', $ledger->country) }}";
    const currentState = "{{ old('state', $ledger->state) }}";
    const currentCity = "{{ old('city', $ledger->city) }}";

    fetch('https://countriesnow.space/api/v0.1/countries/positions')
        .then(res => res.json())
        .then(data => {
            data.data.forEach(country => {
                const option = document.createElement('option');
                option.value = country.name;
                option.textContent = country.name;
                if (country.name === currentCountry) {
                    option.selected = true;
                }
                countryDropdown.appendChild(option);
            });

            if (currentCountry) {
                const event = new Event('change');
                countryDropdown.dispatchEvent(event);
            }
        });

    
    countryDropdown.addEventListener('change', function () {
        const selectedCountry = this.value;
        cityDropdown.innerHTML = '<option value="">Select City</option>';
        cityDropdown.disabled = true;

        fetch('https://countriesnow.space/api/v0.1/countries/states', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ country: selectedCountry })
        })
        .then(res => res.json())
        .then(data => {
            stateDropdown.innerHTML = '<option value="">Select State</option>';
            data.data.states.forEach(state => {
                const option = document.createElement('option');
                option.value = state.name;
                option.textContent = state.name;
                if (state.name === currentState) {
                    option.selected = true;
                }
                stateDropdown.appendChild(option);
            });
            stateDropdown.disabled = false;
            
            
            if (currentState) {
                const event = new Event('change');
                stateDropdown.dispatchEvent(event);
            }
        });
    });


    stateDropdown.addEventListener('change', function () {
        const selectedCountry = countryDropdown.value;
        const selectedState = this.value;

        fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ country: selectedCountry, state: selectedState })
        })
        .then(res => res.json())
        .then(data => {
            cityDropdown.innerHTML = '<option value="">Select City</option>';
            data.data.forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                if (city === currentCity) {
                    option.selected = true;
                }
                cityDropdown.appendChild(option);
            });
            cityDropdown.disabled = false;
        });
    });
});
</script>




{{-- <div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Ledger</h1>
        <a href="{{ route('ledgers') }}" 
           class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Ledgers
        </a>
    </div>
    <div class="bg-white shadow rounded-xl overflow-hidden">
        <form action="{{ route('ledgers.update', $ledger->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Form grid with improved spacing and focus states -->
            <div class="space-y-6">
                <!-- Name Field -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Full name of the contact</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name', $ledger->name) }}" 
                                   class="pl-10 w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 transition duration-200 shadow-sm" 
                                   placeholder="John Doe" required>
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Select ledger category</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="relative">
                            <select id="type" name="type" 
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 appearance-none transition duration-200 shadow-sm" required>
                                <option value="" disabled>Select ledger type</option>
                                <option value="supplier" {{ old('type', $ledger->type) == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                <option value="customer" {{ old('type', $ledger->type) == 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="both" {{ old('type', $ledger->type) == 'both' ? 'selected' : '' }}>Both</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Phone Field -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">With country code</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $ledger->phone) }}"
                                   class="pl-10 w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 transition duration-200 shadow-sm" 
                                   placeholder="+1 (555) 123-4567">
                        </div>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email Field -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Valid email address</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email', $ledger->email) }}"
                                   class="pl-10 w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 transition duration-200 shadow-sm" 
                                   placeholder="john@example.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Select country</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="relative">
                            <select id="country" name="country" 
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 appearance-none transition duration-200 shadow-sm">
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- State Field -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">State</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">State or province</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="relative">
                            <select id="state" name="state" 
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 appearance-none transition duration-200 shadow-sm">
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- City Field -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">City or town</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="relative">
                            <select id="city" name="city" 
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 appearance-none transition duration-200 shadow-sm">
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address Field -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Street Address</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">House number and street</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute top-3 left-3">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <textarea id="address" name="address" rows="2"
                                      class="pl-10 w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 transition duration-200 shadow-sm" 
                                      placeholder="123 Main St">{{ old('address', $ledger->address) }}</textarea>
                        </div>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form actions with improved buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="#" 
                   class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:outline-none focus:ring-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:ring-gray-700 transition-colors duration-200 flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Cancel
                </a>
                <button type="submit" 
                        class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:from-blue-600 dark:to-blue-700 dark:hover:from-blue-700 dark:hover:to-blue-800 transition-colors duration-200 flex items-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Update Ledger
                </button>
            </div>
        </form>
    </div>
</div> --}}
@endsection