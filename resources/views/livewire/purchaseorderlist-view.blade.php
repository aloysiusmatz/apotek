{{-- PAGES --}}
            
<div class="bg-gray-100 pb-2 overflow-auto h-screen w-full flex flex-col justify-between">
    
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 flex justify-between dark:border-gray-600">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
            Purchase Order List
        </h2>

        @if (session()->has('message'))
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
                Error
                <span class="float-right">
                  <svg wire:click="closeErrorNotif"
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
                {{ session('message') }}
              </div>
            </div>
        </div>
        @endif

        @if (session()->has('success'))
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
                  <svg wire:click="closeSuccessNotif"
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
                    <p>{{ session('success') }}</p>
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
                {{-- FILTER --}}
                <div class="w-full bg-white rounded-md py-2 px-2">
                    <div class="flex justify-between">
                        <div class="flex">
                            <x-input myclass="mt-1" type="text" name="po_number" wireprop="wire:model.lazy=po_number" disb="">
                                PO Number
                            </x-input>
                            <x-input myclass="mt-1 ml-2" type="text" name="item_id" wireprop="wire:model.lazy=item_id" disb="">
                                Item Number/ Name
                            </x-input>
                            <x-input myclass="mt-1 ml-2 w-36" type="date" name="deliverydate_from" wireprop="wire:model.lazy=deliverydate_from" disb="">
                                From Delivery Date
                            </x-input>
                            <x-input myclass="mt-1 ml-2 w-36" type="date" name="deliverydate_to" wireprop="wire:model.lazy=deliverydate_to" disb="">
                                To Delivery Date
                            </x-input>
                            <div class="mt-1 ml-2 w-36">
                                <label for="selection_dlv" class="block text-sm font-medium text-gray-700">Status</label>
                                <x-select wireprop="wire:model.defer=selection_dlv">
                                    <option value="0">Open</option>
                                    <option value="1">Closed</option>
                                    <option value="2">All</option>
                                </x-select>
                            </div>
                        </div>
                        
                        <div>
                            <button wire:click="clearFilter" class="rounded-md py-1 px-3 bg-gray-700 hover:bg-gray-600 shadow-md text-white text-sm">Clear Filter</button>
                        </div>
                    </div>
                    <button wire:click="searchPO" class="w-full mt-2 rounded-md py-1 px-3 bg-green-600 hover:bg-green-700 shadow-md text-white text-sm">Search</button>
                </div>
                {{-- END FILTER --}}

                {{-- TABLE_CONTENT --}}
                <div class="mt-2 w-full bg-white rounded-md py-2 px-2">
                    
                    <div class="max-h-100 overflow-scroll">
                        <table class="w-full table-auto mt-1">
                            <thead>
                                <tr class="text-gray-600 uppercase text-xs leading-normal">
                                    <th wire:click="sortBy(0)" class="sticky top-0 bg-gray-200 px-1 py-2 text-center cursor-pointer w-20" >PO No.</th>
                                    <th wire:click="sortBy(1)" class="sticky top-0 bg-gray-200 px-1 py-2 text-left cursor-pointer w-14" >PO Seq.</th>
                                    <th wire:click="sortBy(2)" class="sticky top-0 bg-gray-200 px-1 py-2 text-center cursor-pointer w-24">Dlv. Date</th>
                                    <th wire:click="sortBy(3)" class="sticky top-0 bg-gray-200 px-1 py-2 text-center cursor-pointer w-20" >Item No.</th>
                                    <th wire:click="sortBy(4)" class="sticky top-0 bg-gray-200 px-1 py-2 text-center cursor-pointer" >Item Name</th>
                                    <th wire:click="sortBy(5)" class="sticky top-0 bg-gray-200 px-1 py-2 text-right cursor-pointer w-28" >Qty</th>
                                    <th wire:click="sortBy(6)" class="sticky top-0 bg-gray-200 px-1 py-2 text-center cursor-pointer w-24" >Vendor No.</th>
                                    <th wire:click="sortBy(7)" class="sticky top-0 bg-gray-200 px-1 py-2 text-center cursor-pointer" >Vendor Name</th>
                                    <th wire:click="sortBy(8)" class="sticky top-0 bg-gray-200 px-1 py-2 text-center cursor-pointer w-28" >Status</th>
                                    <th class="sticky top-0 bg-gray-200 px-1 py-2 text-center w-20" >Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                
                                @foreach ($results as $result)
                                
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    
                                        <td class="px-1 py-2 text-center">
                                            {{ $result['po_show_id'] }}
                                        </td>
                                        <td class="px-1 py-2">
                                            {{ $result['item_sequence'] }}
                                        </td>
                                        <td class="px-1 py-2 text-center">
                                            {{ $result['delivery_date'] }}
                                        </td>
                                        <td class="px-1 py-2 text-center">
                                            {{ $result['item_show_id'] }}
                                        </td>
                                        <td class="px-1 py-2 text-center">
                                            {{ $result['item_name'] }}
                                        </td>
                                        <td class="px-1 py-2 text-right">
                                            {{ number_format($result['qty'],session()->get('qty_decimal'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}
                                        </td>
                                        <td class="px-1 py-2 text-center">
                                            {{ $result['vendor_show_id'] }}
                                        </td>
                                        <td class="px-1 py-2 text-center">
                                            {{ $result['vendor_name'] }}
                                        </td>
                                        <td class="px-1 py-2 text-center">
                                            @if ($result['dlv']==0)
                                                <span wire:click="showModal1({{ $result['po_number'] }}, {{ $result['po_show_id'] }})" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-full text-xs cursor-pointer">Open</span>
                                            @else
                                                <span wire:click="showModal1(-1,-1)" class="bg-green-500 text-white py-1 px-3 rounded-full text-xs">Closed</span>
                                            @endif
                                            
                                        </td>
                                        <td class="text-center">
                                            @if ($result['dlv']==0)
                                                <div class="flex item-center justify-center">
                                                    <div class="w-4  hover:text-purple-500 hover:scale-110 cursor-pointer" wire:click="showPO({{ $result['po_number'] }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </div>
                                                    <div class="w-2"></div>
                                                    <div class="w-4  hover:text-purple-500 hover:scale-110 cursor-pointer" wire:click="editPO({{ $result['po_number'] }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </div>
                                                    <div class="w-2"></div>
                                                    <div onclick="return confirm('Are you sure want to delete this data?') || event.stopImmediatePropagation()" class="w-4  hover:text-purple-500 hover:scale-110 cursor-pointer"  wire:click="deletePO({{ $result['po_number'] }},{{ $result['po_show_id'] }})" >
                                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex item-center justify-center">
                                                    <div class="w-4 hover:text-purple-500 hover:scale-110 cursor-pointer" wire:click="showPO({{ $result['po_number'] }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </div>
                                                    <div class="w-2"></div>
                                                    <div class="w-4 text-gray-300" wire:click="editPO(-1)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </div>
                                                    <div class="w-2"></div>
                                                    <div class="w-4 text-gray-300"  wire:click="deletePO(-1,-1)" >
                                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                
                                                    </div>
                                                </div>
                                            @endif
                                        </td> 
                                    </tr>
                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- END TABLE_CONTENT --}}
            </div>
        </div> 
            
    </x-content>
    {{-- END CONTENT --}}

    {{-- MODAL 1 --}}
    <x-jet-dialog-modal wire:model="modal1">
        <x-slot name="title">
            <div class="flex justify-between">
                <div>
                    <span class="text-gray-700">Goods Receipt {{ $modal1_title }}</span>
                </div>
                
                <div class="mt-1 flex">
                   
                </div>
            </div>
            
        </x-slot>
        
        <x-slot name="content">
            <div class="flex">
                <div class="grid justify-items-center">
                    <span class="justify-self-center place-self-center text-gray-700">Posting Date: </span>
                </div>
                <div>
                    <x-input myclass="w-32 ml-1" type="date" name="modal1_date" wireprop="wire:model=modal1_date" disb="">
                    </x-input>
                </div> 
                <div class="grid justify-items-center">
                    <span class="text-red-500 justify-self-center place-self-center ml-2">{{ $modal1_message_date }}</span>
                </div>               
            </div>
            @php
                $index = 0;
            @endphp
            @foreach ($modal1_datas as $data)
                <div class="mt-2 w-full rounded-md border grid grid-cols-12">
                    <div class="bg-gray-200 grid justify-items-center col-span-1">
                        <div class="justify-self-center place-self-center">
                            <span class="text-gray-700 text-xs font-bold">{{ $data['item_sequence'] }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-100 px-2 grid grid-cols-1 col-span-5">
                        <div>
                            <div>
                                <span class="text-gray-700 text-xs font-bold">{{ $data['item_show_id'] }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-700">{{ $data['item_name'] }} </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 px-2 pb-2 col-span-2">
                        <div>
                            <label class="text-gray-700 text-xs font-bold" for="qty">Qty</label>
                        </div>
                        <div class="mt-1">
                            <x-input-qty wireprop="wire:model.defer=poitem_qty.{{ $data['item_sequence'] }}" disb="" unit="{{ $data['item_unit'] }}"></x-input-qty> 
                        </div>
                    </div>
                    <div class="bg-gray-100 px-2 grid grid-cols-1 place-items-stretch col-span-3">
                        <div class="flex place-self-center">
                            <div class="flex items-center">
                              <input wire:model="poitem_dlv.{{ $data['item_sequence'] }}" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded" checked>
                            </div>
                            <div class="ml-1">
                              <label class="font-medium text-gray-700 text-xs font-bold">Final Delivery</label>
                            </div>
                        </div>                    
                    </div>
                    <div class="bg-gray-100 grid justify-items-center col-span-1">
                        <div class="justify-self-center place-self-center">
                            <svg wire:click="deleteGRItem({{ $index }})" onclick="return confirm('Are you sure want to delete?') || event.stopImmediatePropagation()" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current text-red-500 hover:text-red-600 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                @php
                    $index++;
                @endphp
            @endforeach
            
        </x-slot>
    
        <x-slot name="footer">
            <div class="flex justify-between">
                <x-jet-secondary-button wire:click="$toggle('modal1')" wire:loading.attr="disabled">
                    Close
                </x-jet-secondary-button>
                <button wire:click="receiptPO({{ $modal1_po }})" class="px-2 py-1 rounded bg-green-600 hover:bg-green-700 font-semibold text-white shadow-md" onclick="return confirm('Do you want to proceed?') || event.stopImmediatePropagation()">Receipt</button>
            </div>
            
    
        </x-slot>
    </x-jet-dialog-modal>
    {{-- END MODAL 1 --}}

    {{-- MODAL 2 --}}
    <x-jet-dialog-modal wire:model="modal2" maxWidth="5xl">
        <x-slot name="title">
            <div class="flex justify-between">
                <div class="">
                    <span class="text-gray-700">Edit PO {{ $modal2_title }}</span>
                    
                </div>
                
                <div class="mt-1 flex">
                   
                </div>
            </div>
            
        </x-slot>
        
        <x-slot name="content">
            <div class="flex justify-between">
                <div class="flex">
                    <div>
                        <x-input myclass="w-40 ml-1" type="date" name="modal2_delivery_date" wireprop="wire:model=modal2_delivery_date" disb="">
                            Delivery Date
                        </x-input>
                    </div>   
                    <div>
                        <x-input myclass="w-52 ml-1" type="text" name="modal2_vendor" wireprop="wire:model=modal2_vendor" disb="disabled">
                            Vendor
                        </x-input>
                    </div>   
                    <div>
                        <x-input myclass="w-52 ml-1" type="text" name="modal2_payment_terms" wireprop="wire:model=modal2_payment_terms" disb="">
                            Payment Terms
                        </x-input>
                    </div> 
                    
                </div>
                
                <div class="ml-5">
                    <span class="text-red-500 font-bold">{{ $modal2_message }}</span>    
                </div>           
            </div>
            @php
                $index = 0;
                
            @endphp
            @foreach ($modal2_datas as $data)
                @php
                    if($data['final_delivery']==0){
                        $disb = '';
                    }else{
                        $disb = 'disabled';
                    }

                    if($data['deleted']==1){
                        $disb = 'disabled';
                    }
                    
                @endphp
                <div class="mt-2 w-full bg-gray-100 rounded-md border flex justify-between w-full ">
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
                                    <x-input-qty wireprop="wire:model.lazy=modal2_poitem_qty.{{ $data['item_sequence'] }}" disb="{{ $disb }}" unit="{{ $data['item_unit'] }}"></x-input-qty>                            
                                </div>
                            </div>
                        </div>
                        {{-- price --}}
                        <div class="bg-gray-100 px-1 py-2 w-28">
                            <div>
                                <label class="text-gray-700 text-xs font-bold" for="price">Price/Unit</label>
                            </div>
                            <div class="mt-1">                            
                                <x-input-currency wireprop="wire:model.lazy=modal2_poitem_price.{{ $data['item_sequence'] }}" disb="{{ $disb }}"></x-input-currency>
                            </div>
                        </div>
                        {{-- discount --}}
                        <div class="bg-gray-100 px-1 py-2 w-24">
                            <div>
                                <label class="text-gray-700 text-xs font-bold" for="discount">Discount (%)</label>
                            </div>
                            <div class="mt-1">
                                <x-input-discount wireprop="wire:model.lazy=modal2_poitem_disc.{{ $data['item_sequence'] }}" disb="{{ $disb }}"></x-input-discount>
                            </div>
                        </div>
                        {{-- tax --}}
                        <div class="bg-gray-100 px-1 py-2 w-20">
                            <div>
                                <label class="text-gray-700 text-xs font-bold" for="tax">Tax (%)</label>
                            </div>
                            <div class="mt-1">
                                <x-input-tax wireprop="wire:model.lazy=modal2_poitem_tax.{{ $data['item_sequence'] }}" disb="{{ $disb }}"></x-input-tax>
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
                                            <span class="text-gray-700">{{ number_format($modal2_poitem_subtotal[$data['item_sequence']],session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator')) }}</span>
                                        </div>                                        
                                    </div>                                
                                </div>
                            </div>
                            
                        </div>
                        {{-- button --}}
                        <div class="bg-gray-100 px-1 py-2 w-9 grid justify-items-center">
                            <div class="justify-self-center place-self-center">
                                @if ($data['final_delivery']==0 && $data['deleted']==0)
                                    <svg wire:click="deleteItemEditPO({{ $index }})" onclick="return confirm('Are you sure want to delete?') || event.stopImmediatePropagation()" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current text-red-500 hover:text-red-600 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg wire:click="deleteItemEditPO({{ $index }})" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                   
                </div>
                @php
                    $index++;
                @endphp
            @endforeach
            
            <div class="w-full flex justify-between mt-2">
                <div>
                    <div class="flex">
                        <input wire:model.debounce.500ms="modal2_additem_query" type="text" name="modal2_additem_query" class="h-9 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 appearance-none" placeholder="Search item to add" autocomplete="off">
                    </div>
                    <div class="absolute z-10 w-96">
                        @if (count($modal2_search_item_result)>0)
                            @foreach ($modal2_search_item_result as $data)
                                <div wire:click="addItemEditPO({{ $data['id'] }})" class="border-b px-2 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs cursor-pointer">{{ $data['show_id'].'-'.$data['name'] }}</div>
                            @endforeach
                        @else
                            @if ($modal2_additem_query!='')
                                <div class="border-b px-2 py-2 bg-gray-100 hover:bg-gray-100 text-gray-700 text-xs">No Result</div>
                            @endif
                        
                        @endif
                        
                    </div>
                </div>
                <div>
                    <div>
                        <div class="flex justify-between">
                            <div class="flex place-items-center text-xs">
                                Shipping
                            </div>
                            <div class="ml-2">
                                
                                <x-input-currency wireprop="wire:model.debounce500ms=modal2_shipping_value"></x-input-currency>
                            </div>
                            
                        </div>
                        <div class="mt-2 flex justify-between">
                            <div class="flex place-items-center text-xs">
                                Others
                            </div>
                            <div class="ml-2">
                                
                                <x-input-currency wireprop="wire:model.debounce500ms=modal2_others_value"></x-input-currency>
                            </div>
                            
                        </div>
                    </div>
                    <div class="mt-2 flex justify-end">
                        <div>
                            <span class="text-xl font-mono text-gray-700">Grand Total:</span>
                            <p class="text-3xl font-bold text-gray-700">{{ session()->get('currency_symbol').' '.number_format($modal2_grand_total,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator')) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div>Note</div>
                <div>
                    <textarea wire:model.defer="modal2_note" class="text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 appearance-none" name="modal2_note" id="modal2_note" cols="30" rows="5"></textarea>
                </div>
            </div>
            <div class="mt-3">
                <div>Ship to</div>
                <div>
                    <div>
                        <input wire:model.defer="modal2_shipto_address" type="text" name="modal2_shipto_address" class="h-9 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 appearance-none" placeholder="Address">
                    </div>
                </div>
                <div class="flex">
                    <div class="w-1/4 mt-2">
                        <div>
                            <input wire:model.defer="modal2_shipto_city" type="text" name="modal2_shipto_city" class="h-9 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 appearance-none" placeholder="City">
                        </div>
                    </div>
                    <div class="w-1/4 mt-2 ml-2">
                        <div>
                            <input wire:model.defer="modal2_shipto_country" type="text" name="modal2_shipto_country" class="h-9 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 appearance-none" placeholder="Country">
                        </div>
                    </div>
                    <div class="w-1/4 mt-2 ml-2">
                        <div>
                            <input wire:model.defer="modal2_shipto_postalcode" type="text" name="modal2_shipto_postalcode" class="h-9 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 appearance-none" placeholder="Postal Code">
                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-1/4 mt-2">
                        <div>
                            <input wire:model.debounce.500ms="modal2_shipto_phone1" type="text" name="modal2_shipto_phone1" class="h-9 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 appearance-none" placeholder="Phone 1">
                        </div>
                    </div>
                    <div class="w-1/4 mt-2 ml-2">
                        <div>
                            <input wire:model.debounce.500ms="modal2_shipto_phone2" type="text" name="modal2_shipto_phone2" class="h-9 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 appearance-none" placeholder="Phone 2">
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <div class="flex justify-between">
                <x-jet-secondary-button wire:click="$toggle('modal2')" wire:loading.attr="disabled">
                    Close
                </x-jet-secondary-button>
                <button wire:click="saveEditPO({{ $modal2_po }})" class="px-2 py-1 rounded bg-green-600 hover:bg-green-700 font-semibold text-white shadow-md" onclick="return confirm('Do you want to proceed?') || event.stopImmediatePropagation()">Save</button>
            </div>
            
    
        </x-slot>
    </x-jet-dialog-modal>
    {{-- END MODAL 2 --}}

    {{-- MODAL 3 --}}
    <x-jet-dialog-modal wire:model="modal3" maxWidth="5xl">
        <x-slot name="title">
        </x-slot>
        
        <x-slot name="content">
            <div class="w-full text-gray-800">
                @if ($modal3)
                    {{-- PO HEADER --}}
                    <div>
                        <div class="flex justify-between">
                            <div>
                                <div class="font-bold text-xl">{{ $modal3_companies['company_desc'] }}</div>
                                <div class="mt-1">{{ $modal3_companies['address'] }}</div>
                                <div>{{ $modal3_companies['city'].', '.$modal3_companies['country'] }}</div>
                                <div>{{ $modal3_companies['phone'].', '.$modal3_companies['altphone'] }}</div>
                                
                            </div>
                            <div>
                                <div class="font-bold text-4xl">PURCHASE ORDER</div>
                                <div class="flex justify-end text-xl">PO# {{ $modal3_datas[0]['po_show_id'] }}</div>
                            </div>
                        </div>
                        <div class="mt-4 ">
                            <div>
                                <div class="flex">
                                    <div class="w-28">
                                        Order Date
                                    </div>
                                    <div>
                                        : {{ $modal3_datas[0]['created_at'] }}
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-28">
                                        Delivery Date
                                    </div>
                                    <div>
                                        : {{ $modal3_datas[0]['delivery_date'] }}
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="flex justify-between mt-5">
                            <div class="w-60">
                                <div class="bg-gray-200 flex justify-center font-bold">
                                    Vendor
                                </div>
                                <div>
                                    {{ $modal3_datas[0]['vendor_address'] }}
                                </div>
                                <div>
                                    {{ $modal3_datas[0]['vendor_city'].', '.$modal3_datas[0]['vendor_country'] }}
                                </div>
                                <div>
                                    {{ $modal3_datas[0]['vendor_phone1'].', '.$modal3_datas[0]['vendor_phone2'] }}
                                </div>
                            </div>
                            <div class="w-60">
                                <div class="bg-gray-200 flex justify-center font-bold">
                                    Ship To
                                </div>
                                <div>
                                    {{ $modal3_datas[0]['ship_to_address'].', '.$modal3_datas[0]['ship_to_postal_code'] }}
                                </div>
                                <div>
                                    {{ $modal3_datas[0]['ship_to_city'].', '.$modal3_datas[0]['ship_to_country']  }}
                                </div>
                                <div>
                                    {{ $modal3_datas[0]['ship_to_phone1'].', '.$modal3_datas[0]['ship_to_phone2']  }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- PO ITEM --}}
                    <div class="mt-5">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="bg-gray-200 w-12 text-left">No</th>
                                    <th class="bg-gray-200 text-left">Item Name</th>
                                    <th class="bg-gray-200 w-20 text-left">Qty</th>
                                    <th class="bg-gray-200 w-20 text-left">Unit</th>
                                    <th class="bg-gray-200 w-32 text-left">Price/Unit</th>
                                    <th class="bg-gray-200 w-32 text-left">Discount</th>
                                    <th class="bg-gray-200 w-20 text-left">Tax</th>
                                    <th class="bg-gray-200 w-32 text-right">Subtotal<br><span class="text-xs">(Tax not included)</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $taxtotal=0;
                                    $subtotal=0;
                                    $grandtotal=0;
                                @endphp
                                @foreach ($modal3_datas as $data)
                                    @php
                                        $total = ($data['qty']*$data['price_unit'])*((100-$data['discount'])/100);
                                        $subtotal += $total;
                                        $taxtotal += ($data['qty']*$data['price_unit'])*((100-$data['discount'])/100)*($data['tax']/100);
                                    @endphp
                                    <tr class="border-t">
                                        <td>{{ $data['item_sequence'] }}</td>
                                        <td class="pr-3">{{ $data['item_name'] }}</td>
                                        <td>{{ number_format($data['qty'] ,session()->get('qty_decimal'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}</td>
                                        <td>{{ $data['item_unit'] }}</td>
                                        <td>{{ session()->get('currency_symbol').' '.number_format($data['price_unit'] ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator')) }}</td>
                                        <td>{{ $data['discount'] }} %</td>
                                        <td>{{ $data['tax'] }} %</td>
                                        <td class="text-right">
                                            <div class="flex justify-between">
                                                <div>
                                                    {{ session()->get('currency_symbol') }}
                                                </div>
                                                <div>
                                                    {{ number_format($total ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                
                                
                            </tbody>
                        </table>
                    </div>
                    {{-- PO FOOTER --}}
                    <div>
                        <div class="flex justify-between mt-5">
                            <div>
                                <div class="font-bold">Note :</div>
                                <div class="mr-20">{{ $modal3_datas[0]['note'] }}</div>
                            </div>
                            <div>
                                <div class="flex">
                                    <div class="w-32">SUBTOTAL</div>
                                    <div>: {{ session()->get('currency_symbol') }}</div>
                                    <div class="text-right w-40">{{ number_format($subtotal ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-32">TAX</div>
                                    <div>: {{ session()->get('currency_symbol') }}</div>
                                    <div class="text-right w-40">{{number_format($taxtotal ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-32">SHIPPING</div>
                                    <div>: {{ session()->get('currency_symbol') }}</div>
                                    <div class="text-right w-40">{{ number_format($modal3_datas[0]['shipping_value'] ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-32">OTHERS</div>
                                    <div>: {{ session()->get('currency_symbol') }}</div>
                                    <div class="text-right w-40">{{ number_format($modal3_datas[0]['others_value'] ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}</div>
                                </div>
                                <hr>
                                <hr>
                                <hr>
                                <div class="flex">
                                    <div class="w-32 font-bold">GRAND TOTAL</div>
                                    <div class="font-bold">: {{ session()->get('currency_symbol') }}</div>
                                    @php
                                        $grandtotal = $subtotal + $taxtotal + $modal3_datas[0]['shipping_value'] + $modal3_datas[0]['others_value'];
                                    @endphp
                                    <div class="text-right font-bold w-40">{{number_format($grandtotal ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif                  
            </div>
            
            
        </x-slot>
    
        <x-slot name="footer">
            <div class="flex justify-between">
                
                <x-jet-secondary-button wire:click="$toggle('modal3')" wire:loading.attr="disabled">
                    Close
                </x-jet-secondary-button>

                @if ($modal3)
                    <a class="px-2 py-2 rounded-md bg-green-600 text-gray-200" href="/purchaseorder/print/{{ $modal3_datas[0]['po_show_id'] }}" target="_blank">
                        <div class="flex place-items-center">
                            <div>
                                <span>Print</span>
                            </div>
                            <div class="mx-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                            </div>
                            <div class="text-xs">
                                ({{ $modal3_datas[0]['print'] }})
                            </div>           
                        </div>
                    </a>
                @endif
                
            </div>
            
    
        </x-slot>
    </x-jet-dialog-modal>
    {{-- END MODAL 3 --}}
</div>

{{-- END PAGES --}}