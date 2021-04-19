
<div class="{{ $myclass.' col-span-6' }}" >
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $slot }}</label>
    @if (isset($wireprop))
        <input type="{{ $type }}" name="{{ $name }}" {{$wireprop}} class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">
    @else
        <input type="{{ $type }}" name="{{ $name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">
    @endif

</div>