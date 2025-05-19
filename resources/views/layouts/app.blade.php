<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" >
    <title>Inventory Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
     @livewireStyles
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
 
<body class=" bg-white font-sans text-gray-800">

    
    <div class="flex h-screen">
    <x-layout.slidebar/>
       

    
         <main class="flex-1 flex flex-col overflow-y-auto">
         @yield('content')
         
        </main>
    </div>

    


      @livewireScripts


<script>
    

      document.addEventListener('alpine:init', () => {
    Alpine.data('searchBar', () => ({
        query: '',
        results: [],
        openSearch: false,

        search() {
            if (this.query.length > 1) {
                fetch(`/search?q=${encodeURIComponent(this.query)}`)
                    .then(response => response.json())
                    .then(data => {
                        this.results = data;
                        this.openSearch = true;
                    });
            } else {
                this.openSearch = false;
            }
        }
    }));
});
    </script>

    
</body>
</html>
