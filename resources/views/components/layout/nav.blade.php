<nav class="flex-1 p-4 space-y-2" 
     x-data="{ 
        inventory: {{ request()->routeIs('inventory.*') ? 'true' : 'false' }},
        {{-- inward: {{ request()->routeIs('inward.*') ? 'true' : 'false' }},
        outward: {{ request()->routeIs('outward.*') ? 'true' : 'false' }}--}}
     }">

    <x-layout.nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
        Home
    </x-layout.nav-link>
  


<div>
    <button 
        @click="inventory = !inventory"
        class="w-full flex justify-between items-center px-2 py-1 rounded hover:bg-[#0a1a2f] {{ request()->routeIs('inventory.*') ? 'text-blue-500' : '' }}"
    >
        <span>Inventory</span>
        <svg :class="{ 'rotate-180': inventory }" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="inventory" x-cloak class="ml-4 mt-2 space-y-1">
        <x-layout.nav-link href="{{ route('inventory.items') }}" :active="request()->routeIs('inventory.items','inventory.items/*')">
            Items
        </x-layout.nav-link> 
        <x-layout.nav-link href="{{ route('inventory.categories') }}" :active="request()->routeIs('inventory.categories')">
            Categories
        </x-layout.nav-link> 
        
       
    </div>
</div>

 <x-layout.nav-link href="{{ route('inwards') }}" :active="request()->routeIs('inwards','inwards.create','inwards.show','inwards.edit')">
            Inward
        </x-layout.nav-link>

 <x-layout.nav-link href="{{ route('outwards') }}"
  :active="request()->routeIs('outwards','outwards.create','outwards.show')">
            Outward
        </x-layout.nav-link>



         <x-layout.nav-link href="{{ route('ledgers') }}" :active="request()->routeIs('ledgers')">
            Ledgers
        </x-layout.nav-link> 
  <x-layout.nav-link href="{{ route('movements') }}" :active="request()->routeIs('movements','movements.create','movements.show')">
       Movement
    </x-layout.nav-link>







</nav>
