{{-- <form action="{{ $action }}" method="{{ $method }}"> --}}
   
<form action="{{ $action }}" wire:submit.prevent="{{ $mysubmit }}">
    @csrf
    <div class="shadow overflow-hidden rounded-md">
        <div class="bg-white p-3 ">
            <div class="col-span-6 flex justify-between">
                
                <p class="text-lg font-bold"> {{ $title }}</p>
                
            </div>
            <div >
                <hr class="border-gray-200 mt-2">
            </div>

            <div class="grid grid-cols-6 gap-6 mt-5">
                {{ $slot }}
            </div>
            
        </div>

        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">

            <x-button type="{{ $bttype }}"></x-button>
                    
        </div>
    </div>
</form>       