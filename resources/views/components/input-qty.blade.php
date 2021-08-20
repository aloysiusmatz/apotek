@props(['wireprop' => null, 'disb' => null, 'unit'=>null])

<div class="relative">
    <div class="absolute right-2 flex h-9">
        <div class="grid">
            <div class="place-self-center text-xs">
                {{ $unit }}
            </div>
        </div>
    </div>

    <input type="number" class="{{ $disb == 'disabled' ? 'cursor-not-allowed' : '' }} w-full rounded-md text-xs focus:border-gray-100 focus:ring focus:ring-gray-500 h-9 pl-2 pr-8" {{ $wireprop.' '.$disb}} >
    
</div>
