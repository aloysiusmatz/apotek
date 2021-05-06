<button class="transition duration-200 ease-in-out bg-gray-600 hover:bg-gray-500 transform hover:-translate-y-1 hover:scale-95 px-3 py-1 w-full shadow-sm rounded-md text-white font-semibold text-sm" {{ $attributes->merge(['wire:click'=> '']) }}>
    {{ $slot }}
</button>