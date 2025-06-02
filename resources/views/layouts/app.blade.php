<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Inventory Dashboard')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-white font-sans text-gray-800">

    <div class="flex h-screen overflow-hidden" role="main">
        <!-- Sidebar -->
        <x-layout.slidebar aria-label="Sidebar Navigation" />

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-y-auto" role="main">
            @yield('content')
        </main>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Custom Alpine.js for Search Bar -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('searchBar', () => ({
                query: '',
                results: [],
                openSearch: false,
                loading: false,

                async search() {
                    if (this.query.length > 1) {
                        this.loading = true;
                        try {
                            const response = await fetch(`/search?q=${encodeURIComponent(this.query)}`);
                            this.results = await response.json();
                            this.openSearch = true;
                        } catch (error) {
                            console.error('Search failed:', error);
                        }
                        this.loading = false;
                    } else {
                        this.openSearch = false;
                        this.results = [];
                    }
                }
            }));
        });
    </script>

    @stack('scripts')
</body>
</html>
