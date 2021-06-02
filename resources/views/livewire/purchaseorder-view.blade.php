{{-- PAGES --}}
            
<div class="bg-gray-100 w-screen h-screen flex flex-col justify-between">
    
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 flex justify-between dark:border-gray-600">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
            Purchase Order
        </h2>

        <div class="flex">
            @if (session()->has('message'))
            <div class=" alert alert-success px-2 py-1 text-green-500 rounded-md text-sm text-center font-bold">
                {{ session('message') }}
            </div>
            @endif

           
        </div>
       
        
    </div>
    {{-- END NAVIGATION BAR --}}

    {{-- CONTENT --}}
    <x-content>
        
        <div class="flex grid grid-cols-12">
            <div class="col-span-12">
                {{-- PO HEADER --}}
                <div class="bg-white rounded-md p-2 shadow-md">
                    <div class="flex justify-between">
                        
                        <div class="w-2/6">
                            <x-input myclass="" type="date" name="posting_date" wireprop="wire:model.lazy=posting_date" disb="">
                                Delivery Date (estimated)
                            </x-input>
                        </div>

                        <button class="px-3 py-1 h-8 bg-green-600 hover:bg-green-500 shadow-md rounded-md text-white font-semibold text-sm" wire:click="postItemMovement">
                            Save PO
                        </button>
                    </div>
                    
                    
                    <div class="flex mt-2">
                        <div class="w-3/6">
                            <x-input myclass="" type="text" name="desc" wireprop="wire:model.lazy=desc" disb="">
                                Vendor
                            </x-input>
                        </div>
                        <div class="ml-2 w-3/6">
                            <x-input myclass="" type="text" name="desc" wireprop="wire:model.lazy=desc" disb="">
                                Payment Terms
                            </x-input>
                        </div>
                    </div>
                    
                    
                                        
                </div>
                {{-- END PO HEADER --}}

                {{-- PO ITEM --}}
                <div class="bg-white rounded-md mt-2 shadow-md">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                                <th class="py-2 px-2 text-left cursor-pointer w-1/12" >Item Number</th>
                                <th class="py-2 px-2 text-left cursor-pointer w-3/12" >Name</th>
                                <th class="py-2 px-2 text-left cursor-pointer w-1/12" >Qty</th>
                                <th class="py-2 px-2 text-left cursor-pointer w-1/12" >Price/Unit</th>
                                <th class="py-2 px-2 text-left cursor-pointer w-1/12" >Unit</th>
                                <th class="py-2 px-2 text-left cursor-pointer w-1/12" >Tax</th>
                                <th class="py-2 px-2 text-left cursor-pointer w-1/12" >Total Price</th>
                                <th class="py-2 px-2 text-left cursor-pointer w-1/12" >
                                    <div class="w-full flex justify-end">
                                        <x-button-additem wireprop="wire:click=toogleSearchModal">Add</x-button-additem>
                                    </div>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @php
                                $index = -1;    
                            @endphp
                            @if (count($items_cart)==0)
                            <tr class="border-b border-gray-200">
                                <td>no item selected</td>
                            </tr>
                            @endif
                            @foreach ($items_cart as $item_cart)
                            @php
                                $index++;    
                            @endphp
                            @if ($selected_cart==$index)
                                <tr class="border-b border-gray-200 bg-blue-200">
                            @else
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                            @endif

                                <td class=" py-2 px-2 text-left cursor-pointer">
                                    {{ $item_cart['id'] }}
                                </td>
                                <td class="py-2 px-2 text-left cursor-pointer">
                                    {{ $item_cart['name'] }}
                                </td>
                                <td class="py-2 px-2 text-left cursor-pointer">
                                    @if ($selected_cart==$index)
                                    <input type="number" class="block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50" wire:model.lazy="item_qty">
                                    @else
                                        {{ $item_cart['qty'] }}
                                    @endif
                                </td>
                                <td class="py-2 px-2 text-left cursor-pointer">
                                    @if ($selected_cart==$index)
                                    <input type="number" class="block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50" wire:model.lazy="item_priceunit">
                                    @else
                                        {{ number_format($item_cart['priceunit'],0,',','.') }}
                                    @endif
                                </td>
                                <td class="py-2 px-2 text-left cursor-pointer">
                                    {{ $item_cart['unit'] }}
                                </td>
                                <td class="py-2 px-2 text-left cursor-pointer">
                                    @if ($selected_cart==$index)
                                    <input type="number" class="block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50" wire:model.lazy="item_tax">
                                    @else
                                        {{ $item_cart['tax'] }}&nbsp%
                                    @endif
                                </td>
                                <td class="py-2 px-2 text-left cursor-pointer">
                                    @if ($selected_cart==$index)
                                    {{ number_format($item_qty*$item_priceunit*($item_tax+100)/100,0,',','.') }}
                                    @else
                                    {{ number_format($item_cart['totalprice'],0,',','.') }}
                                    @endif
                                    
                                </td>
                                <td class="py-2 px-2 text-left">
                                    <div class="flex justify-end">
                                        @if ($selected_cart!=$index)
                                            <svg wire:click="editItem({{ $index }})" xmlns="http://www.w3.org/2000/svg" class=" h-5 w-5 fill-current text-gray-600 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        @else
                                            <svg wire:click="loseSelected" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        @endif
                                        
                                        <svg wire:click="deleteItem({{ $index }})" xmlns="http://www.w3.org/2000/svg" class="ml-3 h-5 w-5 fill-current text-red-500 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                        </svg>
                    
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- END PO ITEM --}}
                
            </div>
        </div> 
            
    </x-content>
    {{-- END CONTENT --}}

    {{-- FOOTER --}}
    <div class="h-32 bg-white flex justify-end">
        <div class="py-1 mr-2">
            <span class="text-2xl font-mono">Grand Total:</span>
            @php
                $index=-1;
                $grandtotal=0;
                foreach($items_cart as $item_cart){
                    $index++;
                    if ($selected_cart == $index){
                        $grandtotal += ($item_qty*$item_priceunit*($item_tax+100)/100);
                    }else{
                        $grandtotal += $item_cart['totalprice'];
                    }
                }
            @endphp
            <p class="text-7xl font-mono">{{ number_format($grandtotal,0,',','.') }}</p>
        </div>
    </div>
    {{-- END FOOTER --}}

    {{-- ITEM SEARCH MODAL --}}
    @if ($show_item_search)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!--
                Background overlay, show/hide based on modal state.

                Entering: "ease-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                Leaving: "ease-in duration-200"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!--
                Modal panel, show/hide based on modal state.

                Entering: "ease-out duration-300"
                    From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    To: "opacity-100 translate-y-0 sm:scale-100"
                Leaving: "ease-in duration-200"
                    From: "opacity-100 translate-y-0 sm:scale-100"
                    To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                -->
                <div class="inline-block align-top bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-top sm:max-w-lg sm:w-full">
                    {{-- CLOSE BUTTON --}}
                    <div class="w-full flex justify-end">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" wire:click="toogleSearchModal">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                    </div>
                    {{-- END CLOSE BUTTON --}}

                    <div class="flex justify-between p-2">
                        <div class="w-full">
                            <div class="relative">

                                <span class="absolute inset-y-0 left-2 flex items-center pl-1">
                                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            
                                <input type="text" class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:ring focus:ring-gray-200 focus:ring-opacity-50 focus:border-gray-300 sm:text-xs" placeholder="Search Items" wire:model.debounce.500ms="search_items" autofocus>
                            </div>
                        </div>
                        
                    </div>

                    <div class="px-2">
                        @if (count($data_items)>0)
                            <table class="w-full table-auto mt-2">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                                        <th class="py-2 px-2 text-left cursor-pointer w-1/3" >Item Number</th>
                                        <th class="py-2 px-2 text-left cursor-pointer" >Name</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach ($data_items as $data_item)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">

                                        <td class=" py-2 px-2 w-1/3">
                                            <div class="flex">
                                                <div class="cursor-pointer" wire:click="addItem({{ $data_item->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-2">
                                                    {{ $data_item->id }}
                                                </div>
                                            </div>
                                            
                                        </td>
                                        <td class=" py-2 px-2 text-left ">
                                            {{ $data_item->name }}
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    @if ($items_found==false)
                        <span>no items found</span>
                    @endif

                </div>
            </div>
        </div>
    @endif
    {{-- END ITEM SEARCH MODAL --}}

    {{-- VENDOR SEARCH MODAL --}}

    {{-- END VENDOR SEARCH MODAL --}}
</div>


{{-- END PAGES --}}