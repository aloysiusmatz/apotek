<div class="flex items-start ml-1 mt-1">
    
    <div class="flex items-center h-5">
      <input id="comments"  name="comments" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded" {{ $wireprop }} checked>
    </div>
    <div class="ml-2 text-md">
      <label for="comments" class="font-medium text-gray-700">{{ $slot }}</label>
    </div>
</div>