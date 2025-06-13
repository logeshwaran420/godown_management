@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Ledger Accounts</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">Manage your Ledgers accounts and contacts</p>
        </div>
        {{-- <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <input type="text" id="ledgerSearchInput" placeholder="Search ledgers..."
                    class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
                <ul id="ledgerSuggestions"
                    class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 border rounded-md shadow-md max-h-60 overflow-y-auto hidden">
                </ul>
            </div>

            <button type="button" id="ledgeropenModalBtn" 
                    class="w-full sm:w-auto flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>New Ledger</span>
            </button>
        </div> --}}
{{-- 
        <div class="flex flex-row flex-wrap items-center gap-3 w-full"> --}}
        
                    <div class="flex items-center gap-3">
    <div class="relative flex-1 min-w-[200px]">
        <input type="text" id="ledgerSearchInput" placeholder="Search ledgers..."
            class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
        <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd" />
        </svg>
        <ul id="ledgerSuggestions"
            class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 border rounded-md shadow-md max-h-60 overflow-y-auto hidden">
        </ul>
    </div>

    <button type="button"  id="ledgeropenModalBtn" 
           class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors shadow-md" >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        <span>New Ledger</span>
    </button>
</div>
    </div>

     

    <!-- Type Filter Tabs -->
    <div class="mb-6 overflow-x-auto">
        <ul class="flex flex-nowrap -mb-px text-sm font-medium text-center">
            <li class="me-2">
                <a href="{{ request()->fullUrlWithQuery(['type' => 'all']) }}" 
                   class="inline-block p-4 border-b-2 rounded-t-lg {{ !request('type') || request('type') == 'all' ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                    All
                </a>
            </li>
            <li class="me-2">
                <a href="{{ request()->fullUrlWithQuery(['type' => 'both']) }}" 
                   class="inline-block p-4 border-b-2 rounded-t-lg {{ request('type') == 'both' ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                    Both
                </a>
            </li>
            <li class="me-2">
                <a href="{{ request()->fullUrlWithQuery(['type' => 'customer']) }}" 
                   class="inline-block p-4 border-b-2 rounded-t-lg {{ request('type') == 'customer' ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                    Customers
                </a>
            </li>
            <li class="me-2">
                <a href="{{ request()->fullUrlWithQuery(['type' => 'supplier']) }}" 
                   class="inline-block p-4 border-b-2 rounded-t-lg {{ request('type') == 'supplier' ? 'border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                    Suppliers
                </a>
            </li>
        </ul>
    </div>

    <!-- Table Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                            <div class="flex items-center">
                                <span>Name</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </div>
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">
                            Type
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">
                            Contact
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($ledgers as $ledger)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 cursor-pointer" onclick="window.location='{{ route('ledgers.show', $ledger) }}'">
                        <td class="px-4 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center shadow-inner">
                                    <span class="text-blue-600 dark:text-blue-300 font-medium uppercase">
                                        {{ substr($ledger->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-300 transition-colors">
                                        {{ $ledger->name }}
                                        @if($ledger->email)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                        {{ $ledger->email ?? 'No email provided' }}
                                    </div>
                                    <div class="sm:hidden mt-1">
                                        @php
                                            $typeColors = [
                                                'customer' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                'supplier' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                                'both' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            ];
                                            $colorClass = $typeColors[strtolower($ledger->type)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                        @endphp
                                        <span class="px-2 py-0.5 inline-flex text-xs leading-4 font-semibold rounded-full {{ $colorClass }} capitalize">
                                            {{ strtolower($ledger->type) }}
                                        </span>
                                    </div>
                                    <div class="sm:hidden mt-1 flex items-center text-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-gray-500 dark:text-gray-400">{{ $ledger->phone ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                       <td class="px-4 py-3 whitespace-nowrap hidden sm:table-cell">
    @php
        $typeColors = [
            'customer' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'supplier' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            'both'     => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        ];
        $colorClass = $typeColors[strtolower($ledger->type)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
    @endphp

    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }} capitalize flex items-center">
        {{ strtolower($ledger->type) }}
        @if(strtolower($ledger->type) === 'customer')
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        @elseif(strtolower($ledger->type) === 'supplier')
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
            </svg>
        @endif
    </span>
</td>
<td class="px-4 py-4 whitespace-nowrap hidden sm:table-cell">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $ledger->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-xs mt-1">
                                {{ $ledger->address ?? 'No address provided' }}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row items-center justify-between px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
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
                <a href="{{ $ledgers->url(1) }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $ledgers->currentPage() == 1 ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &laquo;
                </a>

                <a href="{{ $ledgers->previousPageUrl() }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $ledgers->onFirstPage() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &lsaquo;
                </a>

                @foreach ($ledgers->getUrlRange(max(1, $ledgers->currentPage() - 2), min($ledgers->lastPage(), $ledgers->currentPage() + 2)) as $page => $url)
                    <a href="{{ $url }}" 
                       class="px-3 py-1 rounded-md text-sm font-medium {{ $page == $ledgers->currentPage() ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                        {{ $page }}
                    </a>
                @endforeach

                <a href="{{ $ledgers->nextPageUrl() }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ !$ledgers->hasMorePages() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &rsaquo;
                </a>

                <a href="{{ $ledgers->url($ledgers->lastPage()) }}" 
                   class="px-3 py-1 rounded-md text-sm font-medium {{ $ledgers->currentPage() == $ledgers->lastPage() ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    &raquo;
                </a>
            </div>

            <!-- Showing results info -->
            <div class="text-sm text-gray-700 dark:text-gray-300 mt-4 sm:mt-0">
                Showing <span class="font-medium">{{ $ledgers->firstItem() }}</span> to 
                <span class="font-medium">{{ $ledgers->lastItem() }}</span> of 
                <span class="font-medium">{{ $ledgers->total() }}</span> results
            </div>
        </div>
    </div>
</div>

<x-ledger.create-model />


<script>
document.addEventListener('DOMContentLoaded', function () {

    const ledgeropenModalBtn = document.getElementById('ledgeropenModalBtn');
    const ledgermodalOverlay = document.getElementById('ledgermodalOverlay');
    const ledgercloseModalBtn = document.getElementById('ledgercloseModalBtn');
    const ledgercancelBtn = document.getElementById('ledgercancelBtn');
    const form = document.getElementById('create-ledger-form');

    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const spinner = document.getElementById('spinner');

    // Open/Close modal
    function openModal() {
        ledgermodalOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        ledgermodalOverlay.style.display = 'none';
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

    ledgeropenModalBtn.addEventListener('click', openModal);
    ledgercloseModalBtn.addEventListener('click', closeModal);
    ledgercancelBtn.addEventListener('click', closeModal);
  
    // Generate random barcode
    generateBarcodeBtn.addEventListener('click', function () {
        const randomBarcode = 'BC' + Math.floor(100000000 + Math.random() * 900000000);
        barcodeInput.value = randomBarcode;
    });


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

   ledgermodalOverlay.addEventListener('click', function (e) {
        if (e.target === ledgermodalOverlay) {
            closeModal();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const countryDropdown = document.getElementById('country');
    const stateDropdown = document.getElementById('state');
    const cityDropdown = document.getElementById('city');

    const defaultCountry = 'India';
   const defaultstate = 'Tamil Nadu'; 



    fetch('https://countriesnow.space/api/v0.1/countries/positions')
        .then(res => res.json())
        .then(data => {
            data.data.forEach(country => {
                const option = document.createElement('option');
                option.value = country.name;
                option.textContent = country.name;
                if (country.name === defaultCountry) {
                    option.selected = true;
                }
                countryDropdown.appendChild(option);
            });

            const event = new Event('change');
            countryDropdown.dispatchEvent(event);
        });

    // Country change → load states
    countryDropdown.addEventListener('change', function () {
        const selectedCountry = this.value;
        // stateDropdown.innerHTML = '<option value="">Loading...</option>';
        // stateDropdown.disabled = true;
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
                stateDropdown.appendChild(option);
            });
            stateDropdown.disabled = false;
        });
    });

    // State change → load cities
    stateDropdown.addEventListener('change', function () {
        const selectedCountry = countryDropdown.value;
        const selectedState = this.value;
        // cityDropdown.innerHTML = '<option value="">Loading...</option>';
        // cityDropdown.disabled = true;

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
                cityDropdown.appendChild(option);
            });
            cityDropdown.disabled = false;
        });
    });
});
</script>




@endsection