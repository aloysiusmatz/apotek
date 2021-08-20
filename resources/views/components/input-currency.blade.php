@props(['wireprop' => null, 'disb' => null])

<div class="relative">
    <div class="absolute left-2 flex h-9">
        <div class="grid">
            <div class="place-self-center text-xs">
                {{ session()->get('currency_symbol') }}
            </div>
        </div>
    </div>
    <input type="number" class="{{ $disb == 'disabled' ? 'cursor-not-allowed' : '' }} w-full rounded-md text-xs focus:border-gray-100 focus:ring focus:ring-gray-500 h-9 pl-6 pr-1" {{ $wireprop.' '.$disb}} >
</div>