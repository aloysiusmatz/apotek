@extends('master.master')

@section('content')
    {{-- PAGES --}}
            
    <div class="bg-gray-100 w-screen">
                
        {{-- NAVIGATION BAR --}}
        <div class="bg-white p-3 dark:border-gray-600">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Items
            </h2>
            
        </div>
        {{-- END NAVIGATION BAR --}}

        {{-- CONTENT --}}
        <div class="bg-gray p-3 mt-2">
            <div class="bg-white rounded-sm p-3">
                <p class="text-lg font-bold"> Create Item</p>
                <hr class="border-gray-200 mt-2">

                <p class="mt-5">Item Name</p>
                <input type="text" class="mt-1 block w-1/2 rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">

                <div class="flex w-full">
                    <div class="w-1/5">
                        <p class="mt-5">COGS</p>
                        <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">
                    </div>
                    <div class="ml-5 w-1/5">
                        <p class="mt-5">Selling Price</p>
                        <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">
                    </div>
                </div>

                <p class="mt-5">Initial Qty</p>
                <input type="text" class="mt-1 block w-1/5 rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">

                <div class="flex w-full">
                    <div class="w-1/5">
                        <p class="mt-5">Category</p>
                        <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50" >
                            
                        </select>
                    </div>
                    <div class="ml-5 w-1/5">
                        <p class="mt-5">Location</p>
                        <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50" >
                            
                        </select>
                    </div>
                </div>


                <p class="mt-5">Item Description</p>
                <textarea class="mt-1 block w-1/2 rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50" cols="30" rows="5"></textarea>

                {{-- <x-jet-button class="mt-5">Create</x-button> --}}
                <x-button type="create"></x-button>
            </div>


        </div>
        {{-- END CONTENT --}}
    </div>


    {{-- END PAGES --}}
@endsection
    
 