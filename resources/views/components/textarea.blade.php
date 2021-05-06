<div class="col-span-6" >
    <label for={{ $name }} class="block text-sm font-medium text-gray-700">{{ $slot }}</label>
    <textarea name={{ $name }} id={{ $name }}  rows="4" class="mt-1 block text-xs w-full rounded-md border-gray-300 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50" {{ $wireprop }}></textarea>
</div>