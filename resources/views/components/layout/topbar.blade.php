<header class="bg-white shadow p-4 flex justify-between items-center">
    <div class="flex items-center">
        <form id="search-form" class="relative group transition-all duration-300" onsubmit="return false;">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative" id="filter-container">

                <div class="absolute inset-y-0 left-0 flex items-center pl-1">
                    <div class="relative">
                        <button 
                            id="filter-button"
                            type="button"
                            class="flex items-center text-gray-500 hover:text-blue-600 px-2 py-1 rounded focus:outline-none"
                        >
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                            <svg id="filter-arrow" class="w-3 h-3 ml-1 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8l4 4 4-4"/>
                            </svg>
                        </button>

                        <div id="filter-dropdown" class="absolute z-20 mt-1 w-32 bg-white border border-gray-200 rounded shadow-lg hidden">
                            <a href="#" data-type="ledger" class="block px-4 py-2 text-sm text-blue-700 bg-blue-100 cursor-default">Ledger</a>
                            <a href="#" data-type="item" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-600 hover:text-white cursor-pointer">Item</a>
                            <a href="#" data-type="category" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-600 hover:text-white cursor-pointer">Category</a>
                        </div>
                    </div>
                </div>

                <input 
                    type="text" 
                    id="simple-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 pl-12 pr-3 py-2.5 group-hover:w-72 focus:w-72 transition-all duration-300" 
                    placeholder="Search Ledger (/)..."
                    autocomplete="off"
                />

                <!-- Only this container should be scrollable -->
                <div id="search-results" class="absolute left-0 mt-1 w-full bg-white border border-gray-200 rounded shadow-lg z-10 max-h-60 overflow-auto hidden"></div>
            </div>
        </form>
    </div>

    <!-- Avatar -->
    <div class="flex items-center space-x-4 relative" id="avatar-container">
        <img 
            id="avatar-button"
            class="inline w-8 h-8 rounded-full cursor-pointer" 
            src="https://www.gravatar.com/avatar/?d=mp" 
            alt="User"
        />

        <div id="avatar-dropdown" class="absolute right-0 top-12 w-40 bg-white border rounded shadow-lg py-2 z-10 hidden">
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="block px-4 py-2 text-md text-gray-700 hover:bg-gray-100">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</header>

<script>
    const queryInput = document.getElementById('simple-search');
    const resultsContainer = document.getElementById('search-results');
    const filterButton = document.getElementById('filter-button');
    const filterDropdown = document.getElementById('filter-dropdown');
    const filterArrow = document.getElementById('filter-arrow');
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
            resultsContainer.innerHTML = `<div class="p-4 text-gray-500 italic text-center select-none">Searching...</div>`;
            return;
        }

        if (results.length === 0 && queryInput.value.length >= 2) {
            resultsContainer.innerHTML = `<div class="p-4 text-gray-500 italic text-center select-none">No results found</div>`;
            return;
        }

        const ul = document.createElement('ul');
        ul.className = 'text-sm text-gray-700';

        results.forEach((result, index) => {
            const li = document.createElement('li');
            const a = document.createElement('a');
            let baseUrl = '';
            if (filterType === 'ledger') {
                baseUrl = '/ledgers/edit/';
            } else if (filterType === 'item') {
                baseUrl = 'inventory/items/show/';
            } else if (filterType === 'category') {
                baseUrl = '/categories/edit/';
            }
            a.href = baseUrl + result.id;
            a.textContent = result.name;
            a.className = 'block px-4 py-2 cursor-pointer truncate';
            if (index === selectedIndex) {
                a.classList.add('bg-blue-600', 'text-white');
            } else {
                a.classList.add('hover:bg-blue-600', 'hover:text-white');
            }
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
            baseUrl = '/ledgers/edit/';
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
        selectedIndex = (selectedIndex + 1) % results.length;
        updateResultsDropdown();
    }

    function selectPrev() {
        selectedIndex = (selectedIndex - 1 + results.length) % results.length;
        updateResultsDropdown();
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
            if (selectedIndex >= 0) choose(results[selectedIndex]);
        } else if (e.key === 'Escape') {
            hideResults();
        }
    });

    filterButton.addEventListener('click', () => {
        filterDropdown.classList.toggle('hidden');
        filterArrow.classList.toggle('rotate-180');
    });

    const filterLinks = filterDropdown.querySelectorAll('a');
    filterLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            filterLinks.forEach(l => {
                l.classList.remove('text-blue-700', 'bg-blue-100');
                l.classList.add('text-gray-700');
            });

            e.target.classList.add('text-blue-700', 'bg-blue-100');
            e.target.classList.remove('text-gray-700');

            filterType = e.target.getAttribute('data-type');
            filterDropdown.classList.add('hidden');
            filterArrow.classList.remove('rotate-180');

            if (filterType === 'ledger') {
                queryInput.placeholder = "Search Ledger (/)";
            } else if (filterType === 'item') {
                queryInput.placeholder = "Search Item (/)";
            } else if (filterType === 'category') {
                queryInput.placeholder = "Search Category (/)";
            }

            queryInput.value = '';
            hideResults();
        });
    });

    avatarButton.addEventListener('click', () => {
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
        if (e.key === '/') {
            e.preventDefault();
            queryInput.focus();
        }
    });
</script>
