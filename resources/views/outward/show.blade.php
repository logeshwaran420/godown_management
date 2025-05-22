@extends('layouts.app')

@section('content')

<div class="w-full mx-auto bg-white px-4 py-6">

    <div class="flex justify-between items-center border-b px-6 py-4">
        <h2 class="text-xl font-semibold">Movements Details</h2>


        <button type="button" 
        onclick="window.location='{{ route('outwards.edit',$outward) }}'"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    Edit
</button>
  
    </div>

  <div class="grid grid-cols-1 md:grid-cols-4 border-b gap-4 p-6">
    <div>
        <label class="block text-sm font-medium text-gray-700">Date</label>
        <div class="mt-1 text-sm text-base text-gray-900">
            {{ $outward->date }}
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Ledger</label>
        <div class="mt-1 text-base text-sm text-gray-900">
              {{ $outward->ledger->name }}
       </div>
    </div>
 
</div>


   <div class="px-6 py-2 pb-6">
        <h3 class="font-semibold text-lg mb-4">Outwards Item Details</h3>
    <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-400">
        <tr>
        
              
                    <th class="border px-2 py-2">Slno</th>
                    <th class="border px-2 py-2">Bar Code</th>
                    <th class="border px-2 py-2">Category</th>
                    <th class="border px-2 py-2">Item</th>
                    <th class="border px-2 py-2">HSN Code</th>
                    <th class="border px-2 py-2">Qty</th>
                    <th class="border px-2 py-2">Unit</th>
                    <th class="border px-2 py-2">Rate</th>
        </tr>
    </thead>
    <tbody>
         @foreach ($outward->details as $detail)
       <tr 
        >
        
             
       <td class="border px-6 py-4 ">
                           1 </td>

                           <td class="border px-6 py-4">
                              {{ $detail->item->barcode }}
             </td>
          
            
              <td class=" border px-6 py-4">
                {{ $detail->item->category->name }}
            </td>
          <td class="border px-6 py-4">
                  {{ $detail->item->name }}
             </td>
           <td class="border px-6 py-4">

                  {{ $detail->item->hsn_code }}
            </td>
          
            <td class="border px-6 py-4">
                
                  {{ $detail->quantity }}
            </td>
           
             <td class="border px-6 py-4">
                 {{ $detail->item->unit->abbreviation }}
            </td>
            <td class="border px-6 py-4">
                 {{ $detail->item->price }}
            </td>
           
        </tr>
             @endforeach 
    </tbody>
</table> 

    
    </div>

    <div class="mt-6 border-t px-6 py-4">
        <h3 class="font-semibold mb-2">Summary</h3>
        <div class="overflow-x-auto">
            <table class="min-w-max text-sm border">
               <tr>
                    <th class="border px-2 py-2 text-left">Total Qty</th>
                    <td class="border px-2 py-2" > {{ $outward->total_quantity }}</td>
                </tr> 
            
                <tr>
                    <th class="border px-2 py-2 text-left">Total Amount</th>

                    <td class="border px-2 py-2" > {{ number_format($outward->total_amount,2) }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>



@endsection