{{-- <form action="{{ $action }}" method="{{ $method }}"> --}}
   
<form action="{{ $action }}" wire:submit.prevent="{{ $mysubmit }}">
    @csrf
    <div class="shadow overflow-hidden rounded-md max-w-2xl min-w-1/4">
        <div class="bg-white p-3 ">
            <div class="col-span-6 flex justify-between">
                
                <p class="text-md font-bold"> {{ $title }}</p>
                
            </div>
            <div >
                <hr class="border-gray-200 mt-2">
            </div>

            <div class="grid grid-cols-6 gap-1 mt-3">
                {{ $slot }}
            </div>
            
        </div>

        <div class="px-4 py-2 bg-gray-100 text-right sm:px-6">
            
            <x-button type="{{ $bttype }}"></x-button>

        </div>
    </div>
</form>       