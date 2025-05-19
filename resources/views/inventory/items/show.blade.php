@extends('layouts.app')

@section('content')

<div class="w-full mx-auto bg-white px-4 py-6">

    <div class="flex justify-between items-center border-b px-6 py-4">
        <h2 class="text-xl font-semibold">Item Details</h2>
  
    </div>

<div class="grid grid-cols-1 md:grid-cols-4 border-b gap-4 p-6">
    <div>
        <label class="block text-sm font-medium text-gray-700">name</label>
       <input type="text" value="{{ $item->name }}" 
                       class="mt-1 block w-full border rounded px-3 py-2 ">
    </div>

     <div>
        <label class="block text-sm font-medium text-gray-700">barcode</label>
       <input type="text" value="{{ $item->barcode }}" 
                       class="mt-1 block w-full border rounded px-3 py-2 ">
    </div>
<div>
    <label class="block text-sm font-medium text-gray-700">Category</label>
    <select name="category_id" class="mt-1 block w-full border rounded px-3 py-2 bg-white" required>
 
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                @if (isset($item) && $item->category_id == $category->id) selected @endif>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

 <div>
        <label class="block text-sm font-medium text-gray-700">barcode</label>
       <input type="text" value="{{ $item->hsn_code }}" 
                       class="mt-1 block w-full border rounded px-3 py-2 ">
    </div>
 
</div> 

   <div class="px-6 py-2 pb-6">
        <h3 class="font-semibold text-lg mb-4">Quantity Details</h3>
   <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-400">
        <tr>
        
{{--               
                    <th class="border px-2 py-2">Slno</th>
                    <th class="border px-2 py-2">Bar Code</th>
                    <th class="border px-2 py-2">Category</th>
                    <th class="border px-2 py-2">Item</th>
                    <th class="border px-2 py-2">HSN Code</th> --}}
                    <th class="border px-2 py-2">Qty</th>
                    <th class="border px-2 py-2">Unit</th>
                    <th class="border px-2 py-2">Rate</th>
                     <th class="border px-2 py-2">Total price</th>
        </tr>
    </thead>
    <tbody>
 
       <tr 
        >
            {{-- <td class="border px-6 py-4 ">
                           1 </td>

                           <td class="border px-6 py-4">
                              {{ $item->barcode }}
             </td>
          
            
              <td class=" border px-6 py-4">
                {{ $item->category->name }}
            </td>
          <td class="border px-6 py-4">
                  {{ $item->name }}
             </td>
           <td class="border px-6 py-4">

                  {{ $item->hsn_code }}
            </td> --}}
          
            <td class="border px-6 py-4">
                
                  {{ $item->current_stock }}
            </td>
           
             <td class="border px-6 py-4">
                 {{ $item->unit->abbreviation }}
            </td>
            <td class="border px-6 py-4">
                 {{ $item->price }}
            </td>
            <td class="border px-6 py-4  text-gray-800">
    {{ number_format($item->current_stock * $item->price, 2) }}
</td>
        </tr>
    </tbody>
</table> 

       
    </div>

  {{--   <div class="mt-6 border-t px-6 py-4">
        <h3 class="font-semibold mb-2">Summary</h3>
        <div class="overflow-x-auto">
            <table class="min-w-max text-sm border">
                <tr>
                    <th class="border px-2 py-2 text-left">Total Qty</th>
                    <td class="border px-2 py-2" > {{ $inward->total_quantity }}</td>
                </tr>
            
                <tr>
                    <th class="border px-2 py-2 text-left">Total Amount</th>

                    <td class="border px-2 py-2" >{{number_format( $inward->total_amount,2)}}</td>
                </tr>
            </table>
        </div>
    </div> --}}
</div>



@endsection