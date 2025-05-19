<header class="bg-white shadow p-4 flex justify-between items-center"
    x-data="{
        openAvatar: false, 
        openSearch: false, 
        openFilter: false,
        query: '',
        results: [],
        selectedIndex: -1,
        loading: false,

        focusSearch() { 
            this.openSearch = true; 
            this.$refs.searchInput.focus(); 
        },

        search() {
            if (this.query.length < 2) {
                this.results = [];
                this.openSearch = false;
                this.selectedIndex = -1;
                this.loading = false;
                return;
            }

            this.loading = true;

            // No type param sent, always search ledger
            fetch(`/search?q=${encodeURIComponent(this.query)}`)
                .then(res => res.json())
                .then(data => {
                    this.results = data;
                    this.openSearch = data.length > 0 || this.query.length >= 2;
                    this.selectedIndex = -1;
                })
                .catch(() => {
                    this.results = [];
                    this.openSearch = false;
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        highlight(index) {
            this.selectedIndex = index;
        },

        selectNext() {
            if (this.selectedIndex < this.results.length - 1) {
                this.selectedIndex++;
            } else {
                this.selectedIndex = 0;
            }
            this.scrollToSelected();
        },

        selectPrev() {
            if (this.selectedIndex > 0) {
                this.selectedIndex--;
            } else {
                this.selectedIndex = this.results.length - 1;
            }
            this.scrollToSelected();
        },

        chooseSelected() {
            if (this.selectedIndex >= 0 && this.selectedIndex < this.results.length) {
                this.choose(this.results[this.selectedIndex]);
            }
        },

        choose(result) {
            this.query = result.name;
            this.openSearch = false;
            this.selectedIndex = -1;
            window.location.href = `/ledgers/edit/${result.id}`;
        },

        closeDropdown() {
            this.openSearch = false;
            this.selectedIndex = -1;
        },

        scrollToSelected() {
            this.$nextTick(() => {
                const container = this.$refs.dropdown;
                if (!container) return;
                const items = container.querySelectorAll('a');
                if(items[this.selectedIndex]) {
                    items[this.selectedIndex].scrollIntoView({ block: 'nearest' });
                }
            });
        }
    }"
    @keydown.window.prevent.slash="focusSearch()"
>
    <!-- Search -->
    <div class="flex items-center">
        <form @submit.prevent class="relative group transition-all duration-300">
            <label for="simple-search" class="sr-only">Search Ledger</label>
            <div class="relative">
                <!-- Lens Dropdown -->
                <div class="absolute inset-y-0 start-0 flex items-center ps-1">
                    <div class="relative">
                        <button 
                            @click="openFilter = !openFilter" 
                            type="button" 
                            class="flex items-center text-gray-500 hover:text-blue-600 px-2 py-1 rounded focus:outline-none"
                        >
                            <!-- Search Icon -->
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                            <!-- Dropdown Arrow -->
                            <svg class="w-3 h-3 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8l4 4 4-4"/>
                            </svg>
                           <!-- Always show Ledger -->
                        </button>

                        <!-- Filter Dropdown -->
                        <div 
                            x-show="openFilter" 
                            @click.outside="openFilter = false"
                            x-transition
                            class="absolute z-20 mt-1 w-32 bg-white border border-gray-200 rounded shadow-lg"
                        >
                            <a href="#"
                               @click.prevent="openFilter = false; search()" 
                               class="block px-4 py-2 text-sm text-blue-700 bg-blue-100 cursor-default"
                               >
                                Ledger
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search Input -->
                <input 
                    type="text" 
                    id="simple-search" 
                    x-ref="searchInput"
                    x-model="query"
                    @input.debounce.300ms="search()"
                    @keydown.arrow-down.prevent="selectNext()"
                    @keydown.arrow-up.prevent="selectPrev()"
                    @keydown.enter.prevent="chooseSelected()"
                    @keydown.escape="closeDropdown()"
                    @click.outside="closeDropdown()"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 group-hover:w-72 focus:w-72 transition-all duration-300 ps-12 p-2.5" 
                    placeholder="Search Ledger (/)"
                    autocomplete="off"
                />

                <!-- Results Dropdown -->
                <div
                    x-show="openSearch"
                    x-transition
                    x-ref="dropdown"
                    class="absolute left-0 mt-1 w-full bg-white border border-gray-200 rounded shadow-lg z-10 max-h-60 overflow-auto"
                >
                    <!-- Loading Spinner -->
                    <template x-if="loading">
                        <div class="p-4 text-gray-500 italic text-center select-none">
                            Searching...
                        </div>
                    </template>

                    <!-- Results List -->
                    <template x-if="results.length > 0">
                        <ul class="text-sm text-gray-700 max-h-60 overflow-auto">
                            <template x-for="(result, index) in results" :key="result.id">
                                <li>
                                    <a 
                                        :href="`/ledgers/edit/${result.id}`"
                                        @click.prevent="choose(result)"
                                        @mouseenter="highlight(index)"
                                        :class="{
                                            'bg-blue-600 text-white': selectedIndex === index,
                                            'hover:bg-blue-600 hover:text-white': selectedIndex !== index
                                        }"
                                        class="block px-4 py-2 cursor-pointer truncate"
                                        x-text="result.name"
                                    ></a>
                                </li>
                            </template>
                        </ul>
                    </template>

                    <!-- No Results Found -->
                    <template x-if="results.length === 0 && query.length >= 2 && !loading">
                        <div class="p-4 text-gray-500 italic text-center select-none">
                            No results found
                        </div>
                    </template>
                </div>

            </div>
        </form>
    </div>

    <!-- Right Side Buttons -->
    <div class="flex items-center space-x-4 relative">
        <button class="bg-blue-600 text-white px-3 py-1 rounded">+ Add</button>

        <img 
            @click="openAvatar = !openAvatar"
            class="inline w-8 h-8 rounded-full cursor-pointer" 
            src="https://www.gravatar.com/avatar/?d=mp" 
            alt="User" 
        />

        <!-- Avatar Dropdown -->
        <div 
            x-show="openAvatar" 
            @click.outside="openAvatar = false"
            x-cloak
            class="absolute right-0 top-12 w-40 bg-white border rounded shadow-lg py-2 z-10"
        >
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
