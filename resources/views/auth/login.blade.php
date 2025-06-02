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
        <h2 class="text-2xl font-bold mb-6 text-center">Godown Management System</h2>
      </div>
 


<form action="{{ route('login.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label for="warehouse_id" class="block font-semibold mb-1">Warehouse:</label>
        <select id="warehouse_id" name="warehouse_id"
            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">-- Choose Warehouse --</option>
            @foreach($warehouses as $warehouse)
                <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                    {{ $warehouse->name }}
                </option>
            @endforeach
        </select>
        @error('warehouse_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block font-semibold mb-1">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter email"
            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block font-semibold mb-1">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter password"
            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
        class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 font-semibold">
        Login
    </button>
</form>













    </div>
  </div> 
l
</body>
</html>
