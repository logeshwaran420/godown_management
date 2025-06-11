<header class="bg-white shadow p-4 flex justify-between items-center">
    <div class="flex items-center">
        <form id="search-form" class="relative group transition-all duration-300" onsubmit="return false;">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative" id="filter-container">
                <!-- Search Icon -->
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Filter Dropdown Button -->
                <div class="absolute inset-y-0 left-8 flex items-center pl-1">
                    <div class="relative">
                        <button 
                            id="filter-button"
                            type="button"
                            class="flex items-center text-gray-500 hover:text-blue-600 px-2 py-1 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500/30"
                        >
                            <span id="filter-label" class="text-xs font-medium px-1">Ledger</span>
                            <svg id="filter-arrow" class="w-4 h-4 ml-0.5 transition-transform duration-200 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div id="filter-dropdown" class="absolute z-20 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-lg py-1 hidden divide-y divide-gray-100">
                            <div class="px-3 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Search Type</div>
                            <div class="py-1">
                                <a href="#" data-type="ledger" class="block px-4 py-2 text-sm text-blue-700 bg-blue-50 cursor-default flex items-center">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Ledger
                                </a>
                                <a href="#" data-type="item" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    Item
                                </a>
                                <a href="#" data-type="category" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    Category
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Input -->
                <input 
                    type="text" 
                    id="simple-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-64 pl-24 pr-4 py-2.5 group-hover:w-80 focus:w-80 transition-all duration-300" 
                    placeholder="Search for ledgers..."
                    autocomplete="off"
                />

                <!-- Keyboard Shortcut Hint -->
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <kbd class="px-2 py-1 text-xs font-semibold text-gray-400 bg-gray-100 rounded border border-gray-200">/</kbd>
                </div>

                <!-- Search Results Dropdown -->
                <div id="search-results" class="absolute left-0 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg z-10 max-h-96 overflow-auto hidden divide-y divide-gray-100">
                    <!-- Results will be inserted here -->
                </div>
            </div>
        </form>
    </div>

    <!-- User Avatar -->
    <div class="flex items-center space-x-4 relative" id="avatar-container">
        <button id="avatar-button" class="flex items-center focus:outline-none">
            <img 
                class="inline w-8 h-8 rounded-full ring-2 ring-gray-300 hover:ring-blue-500 transition-all duration-200" 
                src="https://www.gravatar.com/avatar/?d=mp" 
                alt="User"
            />
            <svg class="w-4 h-4 ml-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div id="avatar-dropdown" class="absolute right-0 top-12 w-48 bg-white border border-gray-200 rounded-lg shadow-xl py-1 z-10 hidden divide-y divide-gray-100">
            <div class="px-4 py-3">
                <p class="text-sm font-medium text-gray-900 truncate">Logged in as</p>
                <p class="text-sm text-gray-500 truncate">{{ auth()->user()->email }}</p>
            </div>
            <div class="py-1">
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    const queryInput = document.getElementById('simple-search');
    const resultsContainer = document.getElementById('search-results');
    const filterButton = document.getElementById('filter-button');
    const filterDropdown = document.getElementById('filter-dropdown');
    const filterArrow = document.getElementById('filter-arrow');
    const filterLabel = document.getElementById('filter-label');
    const avatarButton = document.getElementById('avatar-button');
    const avatarDropdown = document.getElementById('avatar-dropdown');

    let results = [];
    let selectedIndex = -1;
    let loading = false;
    let filterType = 'ledger';

    function updateResultsDropdown() {
        resultsContainer.innerHTML = '';
        resultsContainer.classList.remove('hidden');

        if (loading) {
            resultsContainer.innerHTML = `
                <div class="p-4 flex flex-col items-center justify-center">
                    <div class="w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                    <p class="mt-2 text-sm text-gray-500">Searching...</p>
                </div>`;
            return;
        }

        if (results.length === 0 && queryInput.value.length >= 2) {
            resultsContainer.innerHTML = `
                <div class="p-4 flex flex-col items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No results found</p>
                </div>`;
            return;
        }

        const ul = document.createElement('ul');
        ul.className = 'py-1';

        results.forEach((result, index) => {
            const li = document.createElement('li');
            const a = document.createElement('a');
            let baseUrl = '';
            let icon = '';
            
            if (filterType === 'ledger') {
                baseUrl = '/ledgers/edit/';
                icon = `<svg class="w-4 h-4 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>`;
            } else if (filterType === 'item') {
                baseUrl = 'inventory/items/show/';
                icon = `<svg class="w-4 h-4 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>`;
            } else if (filterType === 'category') {
                baseUrl = 'inventory/categories/';
                icon = `<svg class="w-4 h-4 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>`;
            }
            
            a.href = baseUrl + result.id;
            a.className = 'flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100';
            if (index === selectedIndex) {
                a.classList.add('bg-blue-50');
            }
            
            a.innerHTML = `
                ${icon}
                <div class="truncate">
                    <div class="font-medium">${result.name}</div>
                    ${result.description ? `<div class="text-xs text-gray-500 truncate">${result.description}</div>` : ''}
                </div>
            `;
            
            a.addEventListener('click', (e) => {
                e.preventDefault();
                choose(result);
            });
            
            a.addEventListener('mouseenter', () => {
                selectedIndex = index;
                updateResultsDropdown();
            });
            
            li.appendChild(a);
            ul.appendChild(li);
        });

        resultsContainer.appendChild(ul);
    }

    function choose(result) {
        queryInput.value = result.name;
        hideResults();

        let baseUrl = '';
        if (filterType === 'ledger') {
            baseUrl = '/ledgers/show/';
        } else if (filterType === 'item') {
            baseUrl = 'inventory/items/show/';
        } else if (filterType === 'category') {
            baseUrl = 'inventory/categories/';
        }

        window.location.href = baseUrl + result.id;
    }

    function hideResults() {
        results = [];
        selectedIndex = -1;
        resultsContainer.classList.add('hidden');
    }

    function search() {
        const query = queryInput.value.trim();
        if (query.length < 2) {
            hideResults();
            return;
        }

        loading = true;
        updateResultsDropdown();

        fetch(`/search?q=${encodeURIComponent(query)}&type=${filterType}`)
            .then(res => res.json())
            .then(data => {
                results = data;
                selectedIndex = -1;
            })
            .catch(() => {
                results = [];
            })
            .finally(() => {
                loading = false;
                updateResultsDropdown();
            });
    }

    function selectNext() {
        if (results.length === 0) return;
        selectedIndex = (selectedIndex + 1) % results.length;
        updateResultsDropdown();
        scrollToSelected();
    }

    function selectPrev() {
        if (results.length === 0) return;
        selectedIndex = (selectedIndex - 1 + results.length) % results.length;
        updateResultsDropdown();
        scrollToSelected();
    }

    function scrollToSelected() {
        const selectedItem = resultsContainer.querySelector('a.bg-blue-50');
        if (selectedItem) {
            selectedItem.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }
    }

    queryInput.addEventListener('input', () => {
        setTimeout(search, 300);
    });

    queryInput.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectNext();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectPrev();
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (selectedIndex >= 0 && results[selectedIndex]) {
                choose(results[selectedIndex]);
            }
        } else if (e.key === 'Escape') {
            hideResults();
            queryInput.blur();
        }
    });

    filterButton.addEventListener('click', (e) => {
        e.stopPropagation();
        filterDropdown.classList.toggle('hidden');
        filterArrow.classList.toggle('rotate-180');
    });

    const filterLinks = filterDropdown.querySelectorAll('a[data-type]');
    filterLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            filterLinks.forEach(l => {
                l.classList.remove('text-blue-700', 'bg-blue-50');
                l.classList.add('text-gray-700', 'hover:bg-gray-100');
            });

            e.target.classList.add('text-blue-700', 'bg-blue-50');
            e.target.classList.remove('text-gray-700', 'hover:bg-gray-100');

            filterType = e.target.getAttribute('data-type');
            filterLabel.textContent = e.target.textContent.trim();
            filterDropdown.classList.add('hidden');
            filterArrow.classList.remove('rotate-180');

            if (filterType === 'ledger') {
                queryInput.placeholder = "Search for ledgers...";
            } else if (filterType === 'item') {
                queryInput.placeholder = "Search for items...";
            } else if (filterType === 'category') {
                queryInput.placeholder = "Search for categories...";
            }

            queryInput.value = '';
            hideResults();
            queryInput.focus();
        });
    });

    avatarButton.addEventListener('click', (e) => {
        e.stopPropagation();
        avatarDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('#search-form') && !e.target.closest('#search-results')) {
            hideResults();
        }

        if (!e.target.closest('#filter-container')) {
            filterDropdown.classList.add('hidden');
            filterArrow.classList.remove('rotate-180');
        }

        if (!e.target.closest('#avatar-container')) {
            avatarDropdown.classList.add('hidden');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === '/' && !queryInput.matches(':focus')) {
            e.preventDefault();
            queryInput.focus();
        }
    });

    // Initialize with ledger selected
    filterLinks[0].click();
</script>