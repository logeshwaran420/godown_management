<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-800">

    
    <div class="flex h-screen">
    <x-layout.slidebar/>
       

    
        <main class="flex-1 flex flex-col">
         @yield('content')
         
        </main>
    </div>

    


    
</body>
</html>
