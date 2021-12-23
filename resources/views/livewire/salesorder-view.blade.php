{{-- PAGES --}}
            
<div class="bg-gray-100 w-full h-screen flex flex-col justify-between">
    
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
        
        <div class="flex grid grid-cols-12">
            <div class="col-span-12">
                {{-- PO HEADER --}}
                <div class="bg-white rounded-md p-2 shadow-md">
                    <div class="flex">
                        <x-input myclass="w-40 ml-1" type="date" name="modal2_delivery_date" wireprop="wire:model=modal2_delivery_date" disb="">
                            Delivery Date (Est.)
                        </x-input>
                        <x-input myclass="w-40 ml-1" type="text" name="modal2_delivery_date" wireprop="wire:model=modal2_delivery_date" disb="">
                            Customer
                        </x-input>
                        <div class="ml-2 w-3/6">
                            <x-input myclass="" type="text" name="desc" wireprop="wire:model.lazy=payment_terms" disb="">
                                Payment Terms
                            </x-input>
                        </div>
                    </div>                    
                </div>
                {{-- END PO HEADER --}}

                {{-- PO ITEM --}}
                <div class="bg-white rounded-md mt-2 shadow-md max-h-96 overflow-y-auto">
                    {{-- <table class="w-full table-auto">
                        <thead>
                            <tr class="text-gray-600 uppercase text-xs leading-normal">
                                <th class="sticky top-0 bg-gray-200 py-2 px-2 text-left cursor-pointer w-10" >No</th>
                                <th class="sticky top-0 bg-gray-200 py-2 px-2 text-left cursor-pointer w-28" >Item Number</th>
                                <th class="sticky top-0 bg-gray-200 py-2 px-2 text-left cursor-pointer " >Name</th>
                                <th class="sticky top-0 bg-gray-200 py-2 px-2 text-left cursor-pointer w-28" >Qty</th>
                                <th class="sticky top-0 bg-gray-200 py-2 px-2 text-left cursor-pointer w-36" >Price/Unit</th>
                                <th class="sticky top-0 bg-gray-200 py-2 px-2 text-left cursor-pointer w-14" >Unit</th>
                                <th class="sticky top-0 bg-gray-200 py-2 px-2 text-left cursor-pointer w-20" >Disc (%)</th>
                                <th class="sticky top-0 bg-gray-200 py-2 px-2 text-left cursor-pointer w-20" >Tax (%)</th>
                                <th class="sticky top-0 bg-gray-200 py-2 px-2 text-left cursor-pointer w-36" >Total Price</th>
                                <th class="sticky top-0 bg-gray-200 py-2 px-2 text-left cursor-pointer w-20" >
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
                                <td colspan="9" class="text-center">no item selected</td>
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
                                    {{ $index+1 }}
                                </td>
                                <td class=" py-2 px-2 text-left cursor-pointer">
                                    {{ $item_cart['show_id'] }}
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
                                        
                                        <x-input-currency wireprop="wire:model.lazy=item_priceunit"></x-input-currency>
                                    @else
                                        {{ session()->get('currency_symbol').' '.number_format($item_cart['priceunit'],session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator')) }}
                                    @endif
                                </td>                                
                                <td class="py-2 px-2 text-left cursor-pointer">
                                    {{ $item_cart['unit'] }}
                                </td>
                                <td class="py-2 px-2 text-left cursor-pointer">
                                    @if ($selected_cart==$index)
                                    <input type="number" class="block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50" wire:model.lazy="item_discount">
                                    @else
                                        {{ $item_cart['discount'] }}
                                    @endif
                                </td>
                                <td class="py-2 px-2 text-left cursor-pointer">
                                    @if ($selected_cart==$index)
                                        <input type="number" class="block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 appearance-none" wire:model.lazy="item_tax">
                                    @else
                                        {{ $item_cart['tax'] }}&nbsp%
                                    @endif
                                </td>
                                <td class="py-2 px-2 text-left cursor-pointer">
                                    @if ($selected_cart==$index)
                                    {{ session()->get('currency_symbol').' '.number_format($item_qty*$item_priceunit*((100-$item_discount)/100)*(($item_tax+100)/100),session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator')) }}
                                    @else
                                    {{ session()->get('currency_symbol').' '.number_format($item_cart['totalprice'],session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator')) }}
                                    @endif
                                    
                                </td>
                                <td class="py-2 px-2 text-left">
                                    <div class="flex justify-end">
                                        @if ($selected_cart!=$index)
                                            <svg wire:click="editItem({{ $index }})" xmlns="http://www.w3.org/2000/svg" class=" h-5 w-5 fill-current text-gray-600 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        @else
                                            <svg wire:click="loseSelected" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
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
                    </table> --}}
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
            
            {{-- <p class="text-7xl font-mono">{{ session()->get('currency_symbol').' '.number_format($grandtotal,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator')) }}</p> --}}
        </div>
    </div>
    {{-- END FOOTER --}}

    
</div>
{{-- END PAGES --}}