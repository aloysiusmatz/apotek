{{-- PAGES --}}
            
<div class="bg-gray-100 pb-2 overflow-auto h-screen w-full">
                
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 flex justify-between dark:border-gray-600">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
            Other Movement
        </h2>

        <div class="flex">
            @if (session()->has('message'))
            <div class=" alert alert-success px-2 py-1 text-green-500 rounded-md text-sm text-center font-bold">
                {{ session('message') }}
            </div>
            @endif

            <button class="px-3 py-1 bg-green-600 hover:bg-green-500 shadow-sm rounded-md text-white font-semibold text-sm" wire:click="postItemMovement">
                Post
            </button>
        </div>
       
        
    </div>
    {{-- END NAVIGATION BAR --}}

    {{-- CONTENT --}}
    <x-content>
        <div class='flex grid grid-cols-12'>
            <div class="w-full col-span-6">
                {{-- HEADER --}}
                <div class="bg-white rounded-md p-2 shadow-md">
                    
                    <div class="w-1/2">
                        <label for="selected_movkey" class="block text-sm font-medium text-gray-700">Movement Key</label>
                        
                        <x-select wireprop="wire:model=selected_movkey">
                            @foreach ($selection_movkeys as $selection_movkey )
                                <option value="{{ $selection_movkey['id'] }}">{{ $selection_movkey['name'] }}</option>
                            @endforeach
                        </x-select>
                        
                    </div>
                    
                    <div class="mt-1">
                        <x-input myclass="w-1/2" type="date" name="posting_date" wireprop="wire:model.lazy=posting_date" disb="">
                            Posting Date
                        </x-input>
                    </div>
                    
                    <div class="mt-1">
                        <x-input myclass="" type="text" name="desc" wireprop="wire:model.lazy=desc" disb="">
                            Description
                        </x-input>
                    </div>
                    
                                        
                </div>
                {{-- END HEADER --}}

                {{-- ITEM --}}
                <div class="bg-white rounded-md shadow-md mt-2">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                                <th class="py-2 px-2 text-left cursor-pointer w-1/3" >Item Number</th>
                                <th class="py-2 px-2 text-left cursor-pointer flex justify-between" >
                                    <span class="py-1">Name</span>  
                                    <x-button-additem wireprop="wire:click=toogleSearchModal">Add</x-button-additem>
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

                                <td class=" py-2 px-2 w-1/3">
                                    <div class="flex">
                                        <div class="flex">
                                            <svg wire:click="deleteItem({{ $index }})" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current text-red-500 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                        
                                            <svg wire:click="showItem({{ $index }})" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 fill-current text-gray-600 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                              </svg>
                                        </div>
                                        <div class="ml-2">
                                            {{ $item_cart['show_id'] }}
                                        </div>
                                    </div>
                                    
                                </td>
                                <td class="py-2 px-2 text-left cursor-pointer">
                                    {{ $item_cart['name'] }}
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- END ITEM --}}

                {{-- ITEM DETAIL --}}
                @if ($selected_cart >= 0)
                    <div class="bg-white rounded-md p-2 shadow-md mt-2">
                        <div class="text-gray-600">
                            {{ ($selected_cart+1).'-'.$items_cart[$selected_cart]['show_id'].'-'.$items_cart[$selected_cart]['name'] }}
                        </div>

                        <x-input myclass="w-1/2 pr-2 mt-1" type="number" name="item_detail_qty" wireprop="wire:model.lazy=item_detail_qty" disb="">
                            Qty
                        </x-input>

                        <div class="flex justify-between mt-1">
                            @if ($selected_movkey_type == 'TRANS')
                            <div class="w-1/2 pr-2">
                                <label for="from_location" class="block text-sm font-medium text-gray-700">From Location</label>
                                
                                <x-select wireprop="wire:model.defer=from_location">
                                    {@foreach ($selection_to_locations as $selection_to_location )
                                        <option value="{{ $selection_to_location['id'] }}">{{ $selection_to_location['name'] }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            @endif

                            @if ($selected_movkey_type == 'TRANS')
                            <div class="w-1/2">
                                <label for="to_location" class="block text-sm font-medium text-gray-700">To Location</label>
                                
                                <x-select wireprop="wire:model.defer=to_location">
                                    @foreach ($selection_to_locations as $selection_to_location )
                                        <option value="{{ $selection_to_location['id'] }}">{{ $selection_to_location['name'] }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            @else
                            
                            <div class="w-1/2 pr-2">
                                <label for="to_location" class="block text-sm font-medium text-gray-700">Location</label>
                                
                                <x-select wireprop="wire:model.defer=to_location">
                                    @foreach ($selection_to_locations as $selection_to_location )
                                        <option value="{{ $selection_to_location['id'] }}">{{ $selection_to_location['name'] }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            @endif
                            
                        </div>

                        <div class="flex justify-between mt-1">
                            @if ($selected_movkey_type == 'TRANS')
                            <div class="w-1/2 mt-1 pr-2">
                                <x-input myclass="" type="text" name="from_batch" wireprop="wire:model.lazy=from_batch" disb="">
                                    From Batch
                                </x-input>
                            </div>
                            @endif
                            
                            @if ($selected_movkey_type == 'TRANS')
                            <div class="w-1/2 mt-1">
                                <x-input myclass="" type="text" name="to_batch" wireprop="wire:model.lazy=to_batch" disb="">
                                    To Batch
                                </x-input>
                            </div>
                            @else
                            <div class="w-1/2 mt-1 pr-2">
                                <x-input myclass="" type="text" name="to_batch" wireprop="wire:model.lazy=to_batch" disb="">
                                    Batch
                                </x-input>
                            </div>
                            @endif
                            
                        </div>
                        
                        @if ($selected_movkey_type=='INIT')
                            <x-input myclass="w-1/2 mt-1 pr-2" type="number" name="item_detail_amount" wireprop="wire:model.lazy=item_detail_amount" disb="">
                                Amount
                            </x-input>
                        @endif
                        

                    </div>
                @endif
                
                {{-- END ITEM DETAIL --}}
            </div>
            
            <div class="col-span-6 ml-2">
                @if (count($error_list) > 0 )
                    <div class="bg-white rounded-md p-2 shadow-md ">
                        <p class="text-gray-600">ERROR:</p>
                        @foreach ($error_list as $error)
                            <p class="text-red-500 text-sm">{{ $error['message'] }}</p>
                        @endforeach
                    </div>
                @endif
            
            </div>
        
        </div>          
    </x-content>
    {{-- END CONTENT --}}

    {{-- SEARCH MODAL --}}
    @if ($show_item_search)
        <div class="fixed z-30 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                                                    {{ $data_item->show_id }}
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
   {{-- END SEARCH MODAL --}}

</div>


{{-- END PAGES --}}