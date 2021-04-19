@extends('developer.master')

@section('content')
    {{-- PAGES --}}
            
    <div class="bg-gray-100 w-screen">
               

        {{-- NAVIGATION BAR --}}
        <div class="bg-white p-3 dark:border-gray-600 flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Companies
            </h2>

            @include("developer.companies.companies-nav")

        </div>
        {{-- END NAVIGATION BAR --}}

        {{-- CONTENT --}}
        <x-content>
            @livewire('companies-view')
        </x-content>
        {{-- END CONTENT --}}

        
    </div>


    {{-- END PAGES --}}
@endsection