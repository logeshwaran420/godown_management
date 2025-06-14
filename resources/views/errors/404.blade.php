<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found | Inventory Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-gray-800">
    <div class="flex h-screen overflow-hidden" role="main">
        <x-layout.slidebar aria-label="Sidebar Navigation" />
        <main class="flex-1 flex flex-col overflow-y-auto" role="main">
            <div class="flex flex-col items-center justify-center h-full px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-md mx-auto">
                    <h1 class="text-9xl font-bold text-indigo-600">404</h1>
                    <h2 class="mt-6 text-2xl font-medium text-gray-900">Page not found</h2>
                    <p class="mt-4 text-gray-600">
                        Sorry, we couldn't find the page you're looking for.
                    </p>
                    <div class="mt-10">
                        <a href="{{ url('/') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                            Go back home
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @livewireScripts
</body>
</html>