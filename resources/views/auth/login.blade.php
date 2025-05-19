<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Warehouse Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  @vite(["resources/css/app.css","resources/js/app.js"])
  @livewireStyles
</head>

<body class="bg-gradient-to-br from-purple-900 via-pink-900 to-indigo-900 min-h-screen flex items-center justify-center px-4">
<div class="bg-white rounded-xl shadow-lg flex flex-col md:flex-row w-full max-w-5xl overflow-hidden">
    <div class="w-full md:w-1/2 flex items-center justify-center p-6">
      <img src="{{ asset('/storage/media/box.jpg') }}" alt="Warehouse" class="max-h-[400px]" />
    </div>
    <div class="w-full md:w-1/2 p-8">
      <div class="flex flex-col items-center">
        {{-- <img src="https://lsc-india.com/wp-content/uploads/2021/08/LSC_logo.png" alt="LSC Logo" class="h-16 mb-2"> --}}
        <h2 class="text-2xl font-bold mb-6 text-center">Godown Management System</h2>
      </div>
     <livewire:login-form />
    </div>
  </div> 
l
</body>
</html>
