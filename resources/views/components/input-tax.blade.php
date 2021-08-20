@props(['wireprop' => null, 'disb' => null])

<div>
    
    <input type="number" class="{{ $disb == 'disabled' ? 'cursor-not-allowed' : '' }} w-full rounded-md text-xs focus:border-gray-100 focus:ring focus:ring-gray-500 h-9 py-2" {{ $wireprop.' '.$disb}} >
    
</div>
