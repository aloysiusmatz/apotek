
<div class="{{ $myclass.' col-span-6' }}" >
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $slot }}</label>
    @if (isset($wireprop))
        @if ($disb=="disabled")
            <input type="{{ $type }}" name="{{ $name }}" {{$wireprop}} class="bg-gray-100 text-gray-400 mt-1 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50" disabled>
        @else
            <input type="{{ $type }}" name="{{ $name }}" {{$wireprop}} class=" mt-1 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">
        @endif
        
    @else
        <input type="{{ $type }}" name="{{ $name }}" class="mt-1 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50 appearance-none" {{ $disb }}>
    @endif

</div>