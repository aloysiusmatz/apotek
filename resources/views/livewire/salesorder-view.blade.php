{{-- PAGES --}}
            
<div class="bg-gray-100 w-full flex flex-col justify-between">
    
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 flex justify-between dark:border-gray-600">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
            Sales Order
        </h2>

        @if (count($error_list)>0)
        <div class=" w-auto shadow-lg rounded-lg bg-red-100 mx-auto p-4 notification-box flex absolute right-5">
            <div class="pr-2">
              <svg
                class="fill-current text-red-600"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
              >
                <path
                  class="heroicon-ui"
                  d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16zm0 9a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1zm0 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"
                />
              </svg>
            </div>
            <div>
              <div class="text-sm pb-2">
                Check your input
                <span class="float-right">
                  <svg wire:click="closeNotif"
                    class="fill-current text-gray-600 cursor-pointer"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    width="22"
                    height="22"
                  >
                    <path
                      class="heroicon-ui"
                      d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"
                    />
                  </svg>
                </span>
              </div>
              <div class="text-sm text-gray-600  tracking-tight ">
                @foreach ($error_list as $error )
                    <p>- {{ $error['message'] }}</p>
                @endforeach
              </div>
            </div>
        </div>
        @endif

        @if ($success_message!='')
        <div class=" w-auto shadow-lg rounded-lg bg-green-100 mx-auto p-4 notification-box flex absolute right-5">
            <div class="pr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
              <div class="pb-2">
                <span class="text-green-800">Success</span> 
                <span class="float-right">
                  <svg wire:click="closeSuccess"
                    class="fill-current text-gray-600 cursor-pointer"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    width="22"
                    height="22"
                  >
                    <path
                      class="heroicon-ui"
                      d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"
                    />
                  </svg>
                </span>
              </div>
              <div class="text-sm text-gray-600  tracking-tight ">
                    <p>{{ $success_message }}</p>
              </div>
            </div>
        </div>
        @endif
       
        
    </div>
    {{-- END NAVIGATION BAR --}}

    {{-- CONTENT --}}
    <x-content>
        
        <div class=" flex grid grid-cols-12">
            <div class="col-span-12">
                {{-- SO HEADER --}}
                <div class="bg-white rounded-md p-2 shadow-md">
                    <div class="flex justify-between">
                        <div class="flex">
                            <x-input myclass="w-40 ml-1" type="date" name="delivery_date" wireprop="wire:model=delivery_date" disb="">
                                Delivery Date (Est.)
                            </x-input>
                            <x-input myclass="w-40 ml-1" type="text" name="customer_id" wireprop="wire:model=customer_id" disb="">
                                Customer
                            </x-input>
                            <x-input myclass="w-56 ml-1" type="text" name="customer_desc" wireprop="wire:model=customer_desc" disb="">
                                Customer Desc
                            </x-input>
                            <x-input myclass="w-56 ml-1" type="text" name="payment_terms" wireprop="wire:model.lazy=payment_terms" disb="">
                                Payment Terms
                            </x-input>
                            
                        </div>

                        <button wire:click="saveSO" class="px-3 py-1 h-8 bg-green-600 hover:bg-green-500 shadow-md rounded-md text-white font-semibold text-sm">
                            Save SO
                        </button>     

                    </div>  
                </div>
                {{-- END SO HEADER --}}

                {{-- SO ITEM --}}
                <div>

                    {{-- SEARCH ITEM --}}
                    <div class="mt-2 w-48">
                        <input wire:model.debounce.500ms="additem_query" type="text" name="additem_query" class="h-9 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 appearance-none" placeholder="Search item to add" autocomplete="off">

                        @if (count($search_item_result)>0)
                        <div class="absolute z-10 w-96 p-2 bg-white rounded-md border">
                            @foreach ($search_item_result as $search_data)
                                <div wire:click="addItemSO({{ $search_data['id'] }})" class="px-2 py-2 rounded-md hover:bg-gray-200 text-gray-700 text-xs cursor-pointer">{{ $search_data['show_id'].'-'.$search_data['name'] }}</div>
                            @endforeach
                        </div>
                        @else
                        
                            @if ($additem_query!='')
                            <div class="absolute z-10 w-96 p-2 bg-white rounded-md border">
                                <div class="px-2 py-2 text-gray-700 text-xs">No Result</div>
                            </div>
                            @endif
                        
                        @endif
                    </div>
                    
                    {{-- ITEMS --}}
                    <div class="salesorder-content mt-1 pb-2">
                        @php
                            $index = -1;
                        @endphp
                        @foreach ($so_item as $data)
                        @php
                            $index += 1;
                        @endphp
                        <div class="mt-2 w-full bg-gray-100 rounded-md border flex justify-between w-full shadow-md">
                            <div class="flex">
                                {{-- item sequence --}}
                                <div class="bg-gray-200 grid justify-items-center w-12">
                                    <div class="justify-self-center place-self-center">
                                        <span class="text-gray-700 text-xs font-bold">{{ $data['item_sequence'] }}</span>
                                    </div>
                                </div>
                                {{-- name --}}
                                <div class="bg-gray-100 px-2 py-2 grid grid-cols-1 place-items-stretch ">
                                    <div>
                                        <div>
                                            <span class="text-gray-700 text-xs font-bold">{{ $data['item_show_id'] }}</span>
                                            @if ($data['final_delivery']==1)
                                                <span class="text-white bg-green-600 rounded-md text-xs px-2 py-1">Final Delivery</span>    
                                            @endif
                                            @if ($data['deleted']==1)
                                                <span class="text-white bg-red-500 rounded-md text-xs px-2 py-1">Deleted</span>    
                                            @endif
                                        </div>
                                        <div class="flex items-center mt-1">
                                            <span class="text-gray-700">{{ $data['item_name'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex">
                                {{-- qty --}}
                                <div class="bg-gray-100 px-1 py-2 w-28">
                                    <div>
                                        <label class="text-gray-700 text-xs font-bold" for="qty">Qty</label>
                                    </div>
                                    <div class="mt-1 flex">
                                        <div>
                                            <x-input-qty wireprop="wire:model.lazy=soitem_qty.{{ $index }}" disb="" unit="{{ $data['item_unit'] }}"></x-input-qty>                            
                                        </div>
                                    </div>
                                </div>
                                {{-- price --}}
                                <div class="bg-gray-100 px-1 py-2 w-28">
                                    <div>
                                        <label class="text-gray-700 text-xs font-bold" for="price">Price/Unit</label>
                                    </div>
                                    <div class="mt-1">                            
                                        <x-input-currency wireprop="wire:model.lazy=soitem_price.{{ $index }}" disb=""></x-input-currency>
                                    </div>
                                </div>
                                {{-- discount --}}
                                <div class="bg-gray-100 px-1 py-2 w-24">
                                    <div>
                                        <label class="text-gray-700 text-xs font-bold" for="discount">Discount (%)</label>
                                    </div>
                                    <div class="mt-1">
                                        <x-input-discount wireprop="wire:model.lazy=soitem_disc.{{ $index }}" disb=""></x-input-discount>
                                    </div>
                                </div>
                                {{-- tax --}}
                                <div class="bg-gray-100 px-1 py-2 w-20">
                                    <div>
                                        <label class="text-gray-700 text-xs font-bold" for="tax">Tax (%)</label>
                                    </div>
                                    <div class="mt-1">
                                        <x-input-tax wireprop="wire:model.lazy=soitem_tax.{{ $index }}" disb=""></x-input-tax>
                                    </div>
                                </div>
                                {{-- total --}}
                                <div class="bg-gray-100 px-1 py-2 min-w-40 grid grid-cols-1">
                                    <div>
                                        <div class="">
                                            <div class="flex justify-end">
                                                <div class="self-center">
                                                    <label class="text-gray-700 text-xs font-bold" for="tax">Total Price</label>
                                                </div>                                    
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="flex justify-end h-10">
                                                <div class="self-center">
                                                    <span class="text-gray-700">{{ number_format($data['subtotal'],session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator')) }}</span>
                                                </div>                                        
                                            </div>                                
                                        </div>
                                    </div>
                                    
                                </div>
                                {{-- button --}}
                                <div class="bg-gray-100 px-1 py-2 w-9 grid justify-items-center">
                                    <div class="justify-self-center place-self-center">
                                        @if ($data['final_delivery']==0 && $data['deleted']==0)
                                            <svg wire:click="deleteItemSO({{ $index }})" onclick="return confirm('Are you sure want to delete?') || event.stopImmediatePropagation()" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current text-red-500 hover:text-red-600 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg wire:click="deleteItemSO({{ $index }})" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        
                        </div>    
                        @endforeach
                    </div>
                  
                    
                    
                </div>
                
                {{-- END SO ITEM --}}
                
            </div>
        </div> 
            
    </x-content>
    {{-- END CONTENT --}}

    {{-- FOOTER --}}
    <div class="absolute bottom-0 footer-grandtotal h-32 bg-white flex justify-end">
        <div class="py-1 mr-2">
            <span class="text-2xl font-mono">Grand Total:</span>
            
            <p class="text-7xl font-mono">{{ session()->get('currency_symbol').' '.number_format($grandtotal,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator')) }}</p>
        </div>
    </div>
    {{-- END FOOTER --}}

    
</div>
{{-- END PAGES --}}