{{-- PAGES --}}
            
<div class="bg-gray-100 w-screen">
                
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 dark:border-gray-600">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Items
        </h2>

        @include("pages.items.items-nav")
    </div>
    {{-- END NAVIGATION BAR --}}

    {{-- CONTENT --}}
    <x-content>
        <div class='flex grid grid-cols-12'>
            <div class="w-full col-span-8">
                
            </div>

            <div class="col-span-4 ml-2">
                
                {{-- ITEMS --}}
                <div>
                    @if ($mysubmit1=="updateData1")
                    <div>
                        <x-button-topcreate wire:click="changeToCreate1">Create Item</x-button-topcreate>
                    </div>
                    @endif

                    
                    @if (session()->has('message'))
                        <div class="mb-2 alert alert-success bg-green-500 px-2 py-3 text-white rounded-md">
                            {{ session('message') }}
                        </div>
                    @endif
                    

                    <x-form action="" mysubmit="{{ $mysubmit1 }}" bttype="submit" title="{{ $form_title1 }}" >
                        
                        <x-input myclass="" type="text" name="item_name" wireprop="wire:model.lazy=item_name">
                            Item Name
                        </x-input>

                    </x-form>

                </div>
                {{-- END ITEMS --}}

            
            </div>
        
        </div>          
    </x-content>


    {{-- END CONTENT --}}
</div>


{{-- END PAGES --}}