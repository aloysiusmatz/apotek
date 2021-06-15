{{-- PAGES --}}
            
<div class="bg-gray-100 w-screen h-screen flex flex-col justify-between">
    
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 flex justify-between dark:border-gray-600 relative">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
            Report Item Summary
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
                {{ session('message') }}
              </div>
            </div>
        </div>
        @endif

    </div>
    {{-- END NAVIGATION BAR --}}

    {{-- CONTENT --}}
    <x-content>
        
        <div class="grid grid-cols-12">
            <div class="col-span-5">
                <div class="w-auto bg-white rounded-md py-2 px-2">
                    <div class="flex justify-between">
                        <div class="flex">
                            <x-input myclass="mt-1" type="text" name="item_id" wireprop="wire:model.lazy=item_id" disb="">
                                Item Number/ Name
                            </x-input>
                        </div>
                        
                        <div>
                            <button wire:click="clearFilter" class="rounded-md py-1 px-3 bg-gray-700 hover:bg-gray-600 shadow-md text-white text-sm">Clear Filter</button>
                        </div>
                    </div>
                    <button wire:click="search" class="w-full mt-2 rounded-md py-1 px-3 bg-green-600 hover:bg-green-700 shadow-md text-white text-sm">Search</button>
                </div>

                
            </div>
            <div class="col-span-5">

            </div>
            <div class="col-span-12">
                <div class="mt-2 w-full bg-white rounded-md py-2 px-2">
                    <div class=" flex justify-end text-sm">
                        @if (count($results)>0)
                            <div class="group cursor-pointer relative text-center">
                                <button wire:click="downloadReport" class="rounded px-1 py-1 bg-gray-700 hover:bg-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div class="opacity-0 bg-black text-white text-center text-xs rounded-lg py-2 absolute z-10 group-hover:opacity-100 bottom-full -left-20 ml-14 px-2 pointer-events-none">
                                Download Report
                                <svg class="absolute text-black h-2 w-full left-0 top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"><polygon class="fill-current" points="0,0 127.5,127.5 255,0"/></svg>
                                </div>
                            </div>
                        @endif
                        
                        <div class="px-2 py-1">
                            Total record: {{ count($results) }}
                        </div>
                        
                    </div>
                    <table class="w-full table-auto mt-1">
                        <thead>
                            <tr class="text-gray-600 uppercase text-xs leading-normal">                                
                                <th wire:click="sortBy(1)" class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-28" >Item Number</th>
                                <th wire:click="sortBy(2)" class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer">Name</th>
                                <th wire:click="sortBy(3)" class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-28" >Total Qty</th>
                                <th wire:click="sortBy(3)" class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-28" >Unit</th>
                                <th wire:click="sortBy(3)" class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-28" >Total COGS</th>
                                <th wire:click="sortBy(4)" class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-24" >COGS/Qty</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @php
                                $color = false;

                                $total_qty = 0;
                                $total_amount = 0;
                                $total_cogs = 0;
                            @endphp
                            @foreach ($results as $result)
                            @php
                                $total_qty += $result['total_qty'];
                                $total_amount += $result['total_amount'];
                                $total_cogs += $result['cogs_unit'];
                            @endphp
                            @if ($color)
                            <tr class="bg-gray-100">
                            @else
                            <tr class="">
                            @endif
                            
                                <td class="border border-gray-300 px-1">
                                    {{ $result['show_id'] }}
                                </td>
                                <td class="border border-gray-300 px-1">
                                    {{ $result['name'] }}
                                </td>
                                <td class="text-right border border-gray-300 px-1">
                                    {{ number_format($result['total_qty'],0,',','.')}}
                                </td>
                                <td class="border border-gray-300 px-1">
                                    {{ $result['unit'] }}
                                </td>
                                <td class="text-right border border-gray-300 px-1">
                                    {{ number_format($result['total_amount'],0,',','.')}}
                                </td>
                                <td class="text-right border border-gray-300 px-1">
                                    {{ number_format($result['cogs_unit'],0,',','.')}}
                                </td>                                 
                            </tr>
                            @php
                                if($color){
                                    $color=false;
                                }else{
                                    $color=true;
                                }
                            @endphp
                            @endforeach
                            <tr class="bg-yellow-300 font-bold">
                                <td colspan="2" class="px-2">Total</td>
                                <td class="text-right px-1">{{ number_format($total_qty,0,',','.') }}</td>
                                <td></td>
                                <td class="text-right px-1">{{ number_format($total_amount,0,',','.') }}</td>
                                <td class="text-right px-1">{{ number_format($total_cogs,0,',','.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div> 
            
    </x-content>
    {{-- END CONTENT --}}

  
</div>


{{-- END PAGES --}}