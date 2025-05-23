@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center py-3 px-3">
        <h1 class="text-xl font-semibold">Ledger Details</h1> 
        <a href="{{ route('ledgers.create') }}"  class="bg-blue-600 text-white px-3 py-1 rounded">+ New</a>
    </div>

    <div class="relative overflow-x-auto">    
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="sticky top-0 bg-gray-50 dark:bg-gray-700 z-10">
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Type</th>
                    <th scope="col" class="px-6 py-3">Phone</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($ledgers as $ledger)
                <tr class="group bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $ledger->name }}
                    </th>
                    <td class="px-6 py-4">{{ $ledger->type }}</td>
                    <td class="px-6 py-4">{{ $ledger->phone }}</td>
                  <td class="px-6 py-4">
    <div class="invisible group-hover:visible flex space-x-1">
        <a href="{{ route('ledgers.edit', $ledger) }}" class="text-blue-600 hover:underline">Edit</a>
||
        <form action="{{ route('ledgers.destory', $ledger) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ledger?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:underline bg-transparent p-0 m-0 border-0 cursor-pointer">
                Delete
            </button>
        </form>
    </div>
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
     
    {{-- @dd($ledgers->filter(fn($ledger) => $ledger->type == "customer")); --}}
 {{-- <div class="mt-4">
            {{ $ledgers->links() }}
        </div> --}}
    </div>
</div>



@endsection
