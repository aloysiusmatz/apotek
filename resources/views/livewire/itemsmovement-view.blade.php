{{-- PAGES --}}
            
<div class="bg-gray-100 w-screen">
                
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 flex justify-between dark:border-gray-600">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
            Items Movement
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
        <div class='flex grid grid-cols-12'>
            <div class="w-full col-span-6">
                <div class="bg-white rounded-md p-2">
                    
                </div>
            </div>
            
            <div class="col-span-6 ml-2">
                
                {{-- ITEMS --}}
                
                {{-- END ITEMS --}}

            
            </div>
        
        </div>          
    </x-content>


    {{-- END CONTENT --}}
</div>


{{-- END PAGES --}}