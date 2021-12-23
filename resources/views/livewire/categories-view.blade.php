{{-- PAGES --}}
            
<div class="bg-gray-100 pb-2 overflow-auto h-screen w-full">
                
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 flex justify-between dark:border-gray-600">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
            Categories
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
                @livewire('categories-table')
            </div>
            
            <div class="col-span-4 ml-2">
                
                {{-- ITEMS --}}
                <div>
                    
                    <x-form action="" mysubmit="{{ $mysubmit1 }}" bttype="submit" title="{{ $form_title1 }}" >
                        
                        <x-input myclass="" type="text" name="category_name" wireprop="wire:model.lazy=category_name" disb="">
                            Category Name
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