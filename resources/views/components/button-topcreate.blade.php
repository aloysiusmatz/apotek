<button class="px-3 py-2 w-full rounded-md text-white font-semibold text-sm font-medium bg-gray-600 hover:bg-gray-500 mb-2" {{ $attributes->merge(['wire:click'=> '']) }}>
    {{ $slot }}
</button>