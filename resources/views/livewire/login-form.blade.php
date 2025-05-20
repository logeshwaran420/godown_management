<form wire:submit.prevent="login" class="space-y-4" method="post">
    @csrf

    <div>
      <label for="warehouse_id" class="block font-semibold mb-1">Warehouse:</label>
      <select id="warehouse_id" wire:model="warehouse_id"
          class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">-- Choose Warehouse --</option>
          @foreach($warehouses as $warehouse)
              <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
          @endforeach
      </select>
      @error('warehouse_id')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
  </div>
    <div>
        <label for="email" class="block font-semibold mb-1">Email:</label>
        <input type="email" id="email" wire:model="email" placeholder="Enter email"
            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block font-semibold mb-1">Password:</label>
        <input type="password" wire:model="password" id="password" placeholder="Enter password"
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
