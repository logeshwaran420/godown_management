<div class="min-h-screen w-full flex items-start justify-center bg-gray-900">

    <nav class="w-full max-w-xs mx-4 bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl"
         x-data="{ inventory: {{ request()->routeIs('inventory.*') ? 'true' : 'false' }} }">

        <!-- Home Link -->
        <x-layout.nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" class="group nav-item mt-3">
            <div class="flex items-center space-x-2 p-2 rounded-lg transition-all duration-200">
                <div class="icon-container bg-blue-500/10 p-1.5 rounded-md">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span class="text-gray-200">Home</span>
            </div>
        </x-layout.nav-link>

        <!-- Inventory Dropdown -->
        <div>
            <button
                @click="inventory = !inventory"
                class="w-full flex justify-between items-center p-2 rounded-lg hover:bg-white/5 transition-all duration-200 nav-item {{ request()->routeIs('inventory.*') ? 'bg-white/5' : '' }}">
                <div class="flex items-center space-x-2">
                    <div class="icon-container bg-purple-500/10 p-1.5 rounded-md">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-gray-200">Inventory</span>
                </div>
                <svg :class="{ 'rotate-180': inventory }"
                     class="w-3.5 h-3.5 text-gray-400 transition-transform"
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="inventory" x-collapse x-cloak class="ml-5 mt-1 space-y-1 border-l border-gray-700 pl-2">
                <x-layout.nav-link href="{{ route('inventory.items') }}" :active="request()->routeIs('inventory.items*')" class="nav-subitem">
                    <div class="flex items-center space-x-2 p-1.5 rounded-md transition-all duration-200">
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                        <span class="text-gray-300">Items</span>
                    </div>
                </x-layout.nav-link>
                <x-layout.nav-link href="{{ route('inventory.categories') }}" :active="request()->routeIs('inventory.categories*')" class="nav-subitem">
                    <div class="flex items-center space-x-2 p-1.5 rounded-md transition-all duration-200">
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                        <span class="text-gray-300">Categories</span>
                    </div>
                </x-layout.nav-link>
            </div>
        </div>

        <!-- Reusable Nav Items -->
        @php
            $navItems = [
                ['route' => 'inwards', 'label' => 'Inward', 'icon' => 'M19 13l-7 7-7-7m14-8l-7 7-7-7', 'color' => 'green'],
                ['route' => 'outwards', 'label' => 'Outward', 'icon' => 'M5 11l7-7 7 7M5 19l7-7 7 7', 'color' => 'red'],
                ['route' => 'ledgers', 'label' => 'Ledgers', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color' => 'yellow'],
                ['route' => 'movements', 'label' => 'Movement', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4', 'color' => 'cyan'],
            ];
        @endphp

        @foreach ($navItems as $item)
            <x-layout.nav-link href="{{ route($item['route']) }}" :active="request()->routeIs($item['route'] . '*')" class="nav-item">
                <div class="flex items-center space-x-2 p-2 rounded-lg transition-all duration-200">
                    <div class="icon-container bg-{{ $item['color'] }}-500/10 p-1.5 rounded-md">
                        <svg class="w-4 h-4 text-{{ $item['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="text-gray-200">{{ $item['label'] }}</span>
                </div>
            </x-layout.nav-link>
        @endforeach

        <!-- Style -->
        <style>
            .nav-item.active {
                background-color: rgba(255, 255, 255, 0.05);
                box-shadow: inset 3px 0 0 0 #3b82f6;
            }
            .nav-item.active .icon-container {
                background-color: rgba(59, 130, 246, 0.2);
            }
            .nav-subitem.active {
                background-color: rgba(255, 255, 255, 0.03);
            }
            .nav-subitem.active span {
                color: #fff;
                font-weight: 500;
            }
        </style>

    </nav>
</div>
