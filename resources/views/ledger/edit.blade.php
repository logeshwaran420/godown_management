@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center py-3 px-3">
        <h1 class="text-xl font-semibold">New Ledger</h1>
    </div>
    <form action="{{ route('ledgers.update',$ledger) }}" method="POST" class="max-w-3xl mx-auto space-y-6">
        @csrf
        @method('put')
                <div class="flex items-start">
            <label for="name" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Name</label>
            <div class="w-2/3">
                <input type="text" value="{{$ledger->name}}" id="name" name="name" placeholder="Enter a Name" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-start">
            <label for="phone" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Phone</label>
            <div class="w-2/3">
                <input type="text" id="phone" 
                name="phone"
                 value="{{ $ledger->phone }}"
                 class="w-full bg-gray-50 border border-gray-300 
                 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter a Phone">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-start">
            <label for="email" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Email</label>
            <div class="w-2/3">
                <input type="email" id="email" name="email" 
                value="{{ $ledger->email }}"

                 class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter a E-mail">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-start">
            <label for="address" class="w-1/3 pt-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
            <div class="w-2/3">
                <textarea id="address" name="address" rows="3" 
            
                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter a Address">{{ $ledger->address }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-start">
            <label for="type" class="w-1/3 text-sm font-medium text-gray-900 dark:text-white mt-2">Type</label>
            <div class="w-2/3">
                <select id="type" name="type" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
    <option value="" disabled {{ old('type', $ledger->type ?? '') == '' ? 'selected' : '' }}>Select type</option>
    <option value="supplier" {{ old('type', $ledger->type ?? '') == 'supplier' ? 'selected' : '' }}>Supplier</option>
    <option value="customer" {{ old('type', $ledger->type ?? '') == 'customer' ? 'selected' : '' }}>Customer</option>
</select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

       <div class="flex items-center gap-4">
    <div class="w-1/3"></div>
    <button type="submit" 
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Submit
    </button>
        <a href="{{ url()->previous() }}" 
            class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
            Back
        </a>
</div>

    </form>
</div>
@endsection
