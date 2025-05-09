@extends('layouts.app')


@section('content')

<x-layout.topbar/>
            <!-- Dashboard Content -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Sales Activity -->
                <div class="bg-white p-4 rounded shadow col-span-2">
                    <h2 class="text-lg font-semibold mb-4">Sales Activity</h2>
                    <div class="grid grid-cols-4 gap-4 text-center text-sm">
                        <div>
                            <p class="text-blue-600 text-xl font-bold">51</p>
                            <p>To Be Packed</p>
                        </div>
                        <div>
                            <p class="text-red-500 text-xl font-bold">40</p>
                            <p>To Be Shipped</p>
                        </div>
                        <div>
                            <p class="text-green-600 text-xl font-bold">52</p>
                            <p>To Be Delivered</p>
                        </div>
                        <div>
                            <p class="text-yellow-600 text-xl font-bold">97</p>
                            <p>To Be Invoiced</p>
                        </div>
                    </div>
                </div>

                <!-- Inventory Summary -->
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-lg font-semibold mb-4">Inventory Summary</h2>
                    <div class="text-sm space-y-2">
                        <div class="flex justify-between">
                            <span>Quantity in Hand</span>
                            <span class="font-bold">12746</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Quantity to be Received</span>
                            <span class="font-bold">62</span>
                        </div>
                    </div>
                </div>
            </div>



            @endsection