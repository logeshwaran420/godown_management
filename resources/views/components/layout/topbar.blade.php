<header class="bg-white shadow p-4 flex justify-between items-center" x-data="{ open: false }">

    <div>
        <h1 class="text-xl font-semibold">Hello,</h1>
        <p class="text-sm text-gray-500">Demo Org</p>
    </div>

    <div class="flex items-center space-x-4 relative">
        <button class="bg-blue-600 text-white px-3 py-1 rounded">+ Add</button>

        <!-- User Avatar -->
        <img 
            @click="open = !open"
            class="inline w-8 h-8 rounded-full cursor-pointer" 
            src="https://www.gravatar.com/avatar/?d=mp" 
            alt="User" 
        />

        <!-- Dropdown -->
        <div 
            x-show="open" 
            @click.outside="open = false"
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
