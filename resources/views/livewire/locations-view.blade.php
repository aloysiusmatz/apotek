{{-- PAGES --}}
            
<div class="bg-gray-100 w-screen">
                
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 flex justify-between dark:border-gray-600">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
            Locations
        </h2>

        <div class="flex">
            @if (session()->has('message'))
            <div class=" alert alert-success px-2 py-1 text-green-500 rounded-md text-sm text-center font-bold">
                {{ session('message') }}
            </div>
            @endif

            @if ($mysubmit1=="updateData1")
                <div>
                    <x-button-topcreate wire:click="changeToCreate1">Create Location</x-button-topcreate>
                </div>
            @endif

        </div>
       
        
    </div>
    {{-- END NAVIGATION BAR --}}

    {{-- CONTENT --}}
    <x-content>
        <div class='flex grid grid-cols-12'>
            <div class="w-full col-span-8">
                @livewire('locations-table')
            </div>
            
            <div class="col-span-4 ml-2">
                
                {{-- ITEMS --}}
                <div>
                    
                    <x-form action="" mysubmit="{{ $mysubmit1 }}" bttype="submit" title="{{ $form_title1 }}" >
                        
                        <x-input myclass="" type="text" name="location_name" wireprop="wire:model.lazy=location_name" disb="">
                            Location Name
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