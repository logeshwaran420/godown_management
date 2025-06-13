<button id="sidebarToggle" class="md:hidden fixed top-4 left-4 z-50 bg-gray-900 text-white p-2 rounded-md shadow-md">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M3 5h14a1 1 0 100-2H3a1 1 0 100 2zm14 4H3a1 1 0 000 2h14a1 1 0 000-2zm0 6H3a1 1 0 100 2h14a1 1 0 100-2z" clip-rule="evenodd" />
    </svg>
</button>

<aside id="sidebar" class="fixed md:static inset-y-0 left-0 w-64 transform -translate-x-full md:translate-x-0 md:min-h-screen bg-gray-900 text-white flex flex-col border-r border-[#1e2a3a] rounded-r-md md:rounded-none shadow-md transition-transform duration-300 ease-in-out z-40">
    
    <div class="p-4 text-lg font-bold border-b border-[#0a1a2f] tracking-wide text-center">
        INVENTORY
    </div>

    <x-layout.nav />

</aside>


<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });

    document.addEventListener('click', function (event) {
        if (
            !sidebar.contains(event.target) &&
            !toggleBtn.contains(event.target) &&
            window.innerWidth < 768
        ) {
            sidebar.classList.add('-translate-x-full');
        }
    });
</script>
