<div>
    {{-- PAGES --}}
            
<div class="bg-gray-100 pb-2 overflow-auto h-screen w-full flex flex-col justify-between">
    
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 flex justify-between dark:border-gray-600">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
           Dashboard
        </h2>

    </div>
    {{-- END NAVIGATION BAR --}}

    {{-- CONTENT --}}
    <x-content>
        <div class="flex grid grid-cols-12">
            <div class="col-span-6 px-1">
                <div class="w-full bg-white px-2 py-2 rounded-md">
                    <div class="">
                        Nearly Expired Item
                    </div>
                    <div class="max-h-64 overflow-scroll">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="text-gray-600 uppercase text-xs leading-normal">                                
                                    <th class="bg-gray-200 border px-1 py-2 text-center cursor-pointer" >Item</th>
                                    <th class="bg-gray-200 border px-1 py-2 text-center cursor-pointer">Location</th>
                                    <th class="bg-gray-200 border px-1 py-2 text-center cursor-pointer" >Batch</th>
                                    <th class="bg-gray-200 border px-1 py-2 text-right cursor-pointer" >Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($nearly_expired as $data)
                                   
                                    <tr class="border-b text-sm border-gray-200 hover:bg-gray-100 text-gray-700">
                                        <td class="px-1 py-1 text-center">
                                            {{ $data['item_show_id'].'-'.$data['item_name'] }}
                                        </td>
                                        <td class="px-1 py-1 text-center">
                                            {{ $data['location_name'] }}
                                        </td>
                                        <td class="px-1 py-1 text-center">
                                            {{ $data['batch'] }}
                                        </td>
                                        <td class="px-1 py-1 text-right">
                                            {{ number_format($data['qty'],0,',','.').' '.$data['item_unit'] }}
                                        </td>
                                        
                                    </tr>

                                @endforeach
                                
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-span-6 px-1 mt-1">
                <div class="w-full bg-white px-2 py-2 rounded-md">
                    <div class="">
                        Already Expired Item
                    </div>
                    
                    <div class="max-h-64 overflow-scroll">
                                         
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="text-gray-600 uppercase text-xs leading-normal">                                
                                    <th class="sticky top-0 bg-gray-200 border px-1 py-2 text-center" >Item</th>
                                    <th class="sticky top-0 bg-gray-200 border px-1 py-2 text-center">Location</th>
                                    <th class="sticky top-0 bg-gray-200 border px-1 py-2 text-center" >Batch</th>
                                    <th class="sticky top-0 bg-gray-200 border px-1 py-2 text-right" >Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($already_expired as $data)
                                   
                                    <tr class="border-b text-sm border-gray-200 hover:bg-gray-100 text-gray-700">
                                        <td class="px-1 py-1 text-center">
                                            {{ $data['item_show_id'].'-'.$data['item_name'] }}
                                        </td>
                                        <td class="px-1 py-1 text-center">
                                            {{ $data['location_name'] }}
                                        </td>
                                        <td class="px-1 py-1 text-center">
                                            {{ $data['batch'] }}
                                        </td>
                                        <td class="px-1 py-1 text-right">
                                            {{ number_format($data['qty'],0,',','.').' '.$data['item_unit'] }}
                                        </td>
                                        
                                    </tr>
                                    
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
            
    </x-content>
    {{-- END CONTENT --}}

   
</div>

{{-- END PAGES --}}
</div>
