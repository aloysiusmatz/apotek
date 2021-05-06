{{-- PAGES --}}
            
<div class="bg-gray-100 w-screen">
                
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 flex justify-between dark:border-gray-600">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
            Items
        </h2>

        <div class="flex">
            @if (session()->has('message'))
            <div class=" alert alert-success px-2 py-1 text-green-500 rounded-md text-sm text-center font-bold">
                {{ session('message') }}
            </div>
            @endif

            @if ($mysubmit1=="updateData1")
                <div>
                    <x-button-topcreate wire:click="changeToCreate1">Create Item</x-button-topcreate>
                </div>
            @endif

        </div>
       
        
    </div>
    {{-- END NAVIGATION BAR --}}

    {{-- CONTENT --}}
    <x-content>
        <div class='flex grid grid-cols-12'>
            <div class="w-full col-span-8">
                @livewire('items-table')
            </div>
            
            <div class="col-span-4 ml-2">
                
                {{-- ITEMS --}}
                <div>
                    

                    
                    {{-- @if (session()->has('message'))
                        <div class="mb-2 alert alert-success bg-green-500 px-2 py-3 text-white rounded-md">
                            {{ session('message') }}
                        </div>
                    @endif --}}
                    

                    <x-form action="" mysubmit="{{ $mysubmit1 }}" bttype="submit" title="{{ $form_title1 }}" >
                        
                        <x-input myclass="" type="text" name="item_code" wireprop="wire:model.lazy=item_code" disb="disabled">
                            Item Code
                        </x-input>

                        <x-input myclass="" type="text" name="item_name" wireprop="wire:model.lazy=item_name" disb="">
                            Item Name
                        </x-input>

                        <x-textarea name="item_desc" wireprop="wire:model.lazy=item_desc">
                            Description
                        </x-textarea>

                        <x-input myclass="" type="text" name="selling_price" wireprop="wire:model.lazy=selling_price" disb="">
                            Selling Price
                        </x-input>

                        <x-checkbox-active wireprop="wire:model.lazy=item_lock">
                            Lock
                        </x-checkbox-active>
                    </x-form>

                </div>
                {{-- END ITEMS --}}

            
            </div>
        
        </div>          
    </x-content>


    {{-- END CONTENT --}}
</div>


{{-- END PAGES --}}