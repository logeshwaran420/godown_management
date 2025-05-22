@extends('layouts.app')

@section('content')

<div class="w-full mx-auto bg-white px-4 py-6">

    <div class="flex justify-between items-center border-b px-6 py-4">
        <h2 class="text-xl font-semibold">Item Detail</h2>
        <button type="button" 
        onclick="window.location='{{ route('inventory.items.edit',$item) }}'"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    Edit
</button>
  
    </div>

<div class="grid grid-cols-1 md:grid-cols-4 border-b gap-4 p-6">
    <div>
        <label class="block text-sm font-medium text-gray-700">name</label>
              <div class="mt-1 text-sm text-base text-gray-900">
       {{ $item->name }}
        </div>
    </div>

     <div>
        <label class="block text-sm font-medium text-gray-700">barcode</label>
      
                       <div class="mt-1 text-sm text-base text-gray-900">
       {{ $item->barcode }}
        </div>
    </div>
<div>
    <label class="block text-sm font-medium text-gray-700">Category</label>
    <div class="mt-1 text-sm text-base text-gray-900">
       {{ $item->category->name }}
        </div>
      
    </select>
</div>

 <div>
        <label class="block text-sm font-medium text-gray-700">barcode</label>
    <div class="mt-1 text-sm text-base text-gray-900">
       {{ $item->hsn_code }}
        </div>
     </div>
 
</div> 

   <div class="px-6 py-2 pb-6 border-b">
        <h3 class="font-semibold text-lg mb-4">Total Quantity</h3>
   <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-400">
        <tr>

                    <th class="border px-2 py-2">Qty</th>
                    <th class="border px-2 py-2">Unit</th>
                    <th class="border px-2 py-2">Rate</th>
                     <th class="border px-2 py-2">Total price</th>
        </tr>
    </thead>
    <tbody>
 
       <tr 
        >
            
          
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
   ₹{{ number_format($item->current_stock * $item->price, 2) }}
</td>
        </tr>
    </tbody>
</table> 

       
    </div>

    <div class="px-6 py-2 pb-6 border-b">
        <h3 class="font-semibold text-lg mb-4">Total Quantity in warehouses</h3>
<div class="flex flex-wrap">
    @foreach($item->inventories as $index => $Inventory)
        <div class="w-full md:w-1/2 px-4 mb-6">
            <div class="border  shadow-sm p-4">
                <h3 class="font-semibold text-lg mb-4">
                    In ({{ $Inventory->warehouse->name }})
                </h3>
                <table class="min-w-full text-sm text-left text-gray-600 border border-gray-200">
                    <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                        <tr>
                            <th class="border px-2 py-2">Qty</th>
                            <th class="border px-2 py-2">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2">
                                {{ $Inventory->current_stock }}
                            </td>
                            <td class="border px-4 py-2">
                                ₹{{ number_format($Inventory->current_stock * $item->price, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>

    </div>

</div>



@endsection