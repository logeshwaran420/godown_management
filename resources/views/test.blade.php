<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-blue-800 text-white">
                <div class="flex items-center justify-center h-16 px-4 border-b border-blue-700">
                    <h1 class="text-xl font-bold">WarehousePro</h1>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                    <nav class="space-y-1">
                        <a href="#" class="flex items-center px-4 py-3 bg-blue-700 rounded-lg text-white">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                        
                        <!-- Inventory Section -->
                        <div x-data="{ open: true }">
                            <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-blue-200 hover:bg-blue-700 hover:text-white rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-warehouse mr-3"></i>
                                    <span>Inventory</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'transform rotate-180': open }"></i>
                            </button>
                            <div x-show="open" class="mt-1 pl-8 space-y-1">
                              
                                <a href="#" class="block px-4 py-2 text-sm text-blue-200 hover:bg-blue-700 hover:text-white rounded-lg">
                                    <i class="fas fa-box mr-2"></i>Items
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-blue-200 hover:bg-blue-700 hover:text-white rounded-lg">
                                    <i class="fas fa-tags mr-2"></i>Categories
                                </a>
                              
                            </div>
                        </div>
                        
                        <!-- Other Menu Items -->
                        <a href="#" class="flex items-center px-4 py-3 text-blue-200 hover:bg-blue-700 hover:text-white rounded-lg">
                            <i class="fas fa-clipboard-list mr-3"></i>
                            Orders
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-blue-200 hover:bg-blue-700 hover:text-white rounded-lg">
                            <i class="fas fa-truck mr-3"></i>
                            Shipping
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-blue-200 hover:bg-blue-700 hover:text-white rounded-lg">
                            <i class="fas fa-chart-bar mr-3"></i>
                            Reports
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-blue-200 hover:bg-blue-700 hover:text-white rounded-lg">
                            <i class="fas fa-cog mr-3"></i>
                            Settings
                        </a>
                    </nav>
                    <div class="mt-auto pt-4 border-t border-blue-700">
                        <div class="flex items-center px-4 py-3">
                            <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            <div class="ml-3">
                                <p class="text-sm font-medium">John Doe</p>
                                <p class="text-xs text-blue-200">Admin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <button class="md:hidden text-gray-500 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="relative mx-4">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        <input class="w-full py-2 pl-10 pr-4 text-gray-700 bg-gray-100 border rounded-lg focus:outline-none focus:bg-white" type="text" placeholder="Search...">
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 focus:outline-none">
                        <i class="fas fa-bell"></i>
                    </button>
                    <button class="text-gray-500 focus:outline-none">
                        <i class="fas fa-question-circle"></i>
                    </button>
                    <span class="text-sm text-gray-500">Mon, June 2, 2025</span>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <!-- Secondary Navigation -->
                <div class="mb-6 bg-white rounded-lg shadow overflow-hidden">
                    <div class="flex border-b border-gray-200">
                        <a href="#" class="px-4 py-3 text-sm font-medium text-blue-600 border-b-2 border-blue-600">Dashboard</a>
                        <a href="#" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">Inventory</a>
                        <a href="#" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">Items</a>
                        <a href="#" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">Categories</a>
                        <a href="#" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">Inward</a>
                        <a href="#" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">Outward</a>
                        <a href="#" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">Ledgers</a>
                        <a href="#" class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">Movements</a>
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Inventory Dashboard</h2>
                    <p class="text-gray-600">Overview of your warehouse inventory operations</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Total Items Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Items</p>
                                <p class="text-2xl font-semibold text-gray-800">1,248</p>
                                <p class="text-sm text-green-500">+24 this week</p>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-boxes text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Categories</p>
                                <p class="text-2xl font-semibold text-gray-800">32</p>
                                <div class="flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-green-500 mr-1"></span>
                                    <p class="text-sm text-gray-500">Well organized</p>
                                </div>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-tags text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Inward Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Today's Inward</p>
                                <p class="text-2xl font-semibold text-gray-800">47</p>
                                <p class="text-sm text-blue-500">3 pending receipts</p>
                            </div>
                            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                                <i class="fas fa-arrow-down text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Outward Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Today's Outward</p>
                                <p class="text-2xl font-semibold text-gray-800">32</p>
                                <p class="text-sm text-gray-500">5 awaiting dispatch</p>
                            </div>
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <i class="fas fa-arrow-up text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Inventory Distribution -->
                    <div class="bg-white rounded-lg shadow p-6 lg:col-span-1">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-800">Inventory Distribution</h3>
                            <select class="text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option>By Category</option>
                                <option>By Location</option>
                                <option>By Status</option>
                            </select>
                        </div>
                        <div class="h-64 flex items-center justify-center">
                            <!-- Placeholder for chart -->
                            <div class="w-40 h-40 rounded-full border-8 border-blue-500 border-t-green-500 border-r-yellow-500 border-b-red-500 relative">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="text-center">
                                        <p class="text-2xl font-bold">1,248</p>
                                        <p class="text-xs text-gray-500">Items</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span>
                                <span class="text-sm text-gray-600">Electronics (32%)</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                                <span class="text-sm text-gray-600">Furniture (25%)</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                                <span class="text-sm text-gray-600">Office Supplies (18%)</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                                <span class="text-sm text-gray-600">Other (25%)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Movement Trends -->
                    <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-800">Movement Trends</h3>
                            <select class="text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option>Last 7 Days</option>
                                <option>Last 30 Days</option>
                                <option>Last 90 Days</option>
                            </select>
                        </div>
                        <div class="h-64">
                            <!-- Placeholder for chart -->
                            <div class="h-full flex items-end space-x-2">
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-blue-500 rounded-t" style="height: 70%"></div>
                                    <p class="text-xs mt-1 text-gray-500">Mon</p>
                                </div>
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-blue-500 rounded-t" style="height: 50%"></div>
                                    <p class="text-xs mt-1 text-gray-500">Tue</p>
                                </div>
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-blue-500 rounded-t" style="height: 80%"></div>
                                    <p class="text-xs mt-1 text-gray-500">Wed</p>
                                </div>
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-blue-500 rounded-t" style="height: 60%"></div>
                                    <p class="text-xs mt-1 text-gray-500">Thu</p>
                                </div>
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-blue-500 rounded-t" style="height: 90%"></div>
                                    <p class="text-xs mt-1 text-gray-500">Fri</p>
                                </div>
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-green-500 rounded-t" style="height: 40%"></div>
                                    <p class="text-xs mt-1 text-gray-500">Sat</p>
                                </div>
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-green-500 rounded-t" style="height: 30%"></div>
                                    <p class="text-xs mt-1 text-gray-500">Sun</p>
                                </div>
                            </div>
                            <div class="flex justify-center mt-4 space-x-6">
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span>
                                    <span class="text-sm text-gray-600">Inward</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                                    <span class="text-sm text-gray-600">Outward</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-800">Recent Transactions</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center">
                            <div class="col-span-3 flex items-center">
                                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-3">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Inward #IN-2025-06-001</p>
                                    <p class="text-xs text-gray-500">Today, 10:42 AM</p>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-800">PRD-2048</p>
                                <p class="text-xs text-gray-500">120 units</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-800">A-12-B-4</p>
                                <p class="text-xs text-gray-500">Main Warehouse</p>
                            </div>
                            <div class="col-span-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Completed</span>
                            </div>
                            <div class="col-span-3 text-right">
                                <button class="text-sm text-blue-600 hover:text-blue-800">View Details</button>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center">
                            <div class="col-span-3 flex items-center">
                                <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 mr-3">
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Outward #OUT-2025-06-032</p>
                                    <p class="text-xs text-gray-500">Today, 09:15 AM</p>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-800">PRD-3921</p>
                                <p class="text-xs text-gray-500">5 units</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-800">A-08-B-2</p>
                                <p class="text-xs text-gray-500">Main Warehouse</p>
                            </div>
                            <div class="col-span-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Processing</span>
                            </div>
                            <div class="col-span-3 text-right">
                                <button class="text-sm text-blue-600 hover:text-blue-800">View Details</button>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center">
                            <div class="col-span-3 flex items-center">
                                <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 mr-3">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Movement #MV-2025-06-012</p>
                                    <p class="text-xs text-gray-500">Today, 08:30 AM</p>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-800">PRD-1002</p>
                                <p class="text-xs text-gray-500">2 units</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-800">A-12-B-4 → A-08-B-2</p>
                                <p class="text-xs text-gray-500">Location change</p>
                            </div>
                            <div class="col-span-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Completed</span>
                            </div>
                            <div class="col-span-3 text-right">
                                <button class="text-sm text-blue-600 hover:text-blue-800">View Details</button>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-3 border-t border-gray-200 text-right">
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">View all transactions</a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <button class="bg-white rounded-lg shadow p-6 hover:bg-blue-50 transition-colors">
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-4">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Add New Item</p>
                                <p class="text-xs text-gray-500">Register new inventory</p>
                            </div>
                        </div>
                    </button>
                    <button class="bg-white rounded-lg shadow p-6 hover:bg-green-50 transition-colors">
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 mr-4">
                                <i class="fas fa-arrow-down text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Record Inward</p>
                                <p class="text-xs text-gray-500">New stock arrival</p>
                            </div>
                        </div>
                    </button>
                    <button class="bg-white rounded-lg shadow p-6 hover:bg-orange-50 transition-colors">
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 mr-4">
                                <i class="fas fa-arrow-up text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Process Outward</p>
                                <p class="text-xs text-gray-500">Dispatch items</p>
                            </div>
                        </div>
                    </button>
                    <button class="bg-white rounded-lg shadow p-6 hover:bg-purple-50 transition-colors">
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 mr-4">
                                <i class="fas fa-exchange-alt text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Record Movement</p>
                                <p class="text-xs text-gray-500">Transfer between locations</p>
                            </div>
                        </div>
                    </button>
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine JS for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>