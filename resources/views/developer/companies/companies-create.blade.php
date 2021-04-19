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
            <x-form action="/developer/companies" method="POST" title="Create Company" >
                <x-input myclass="sm:col-span-1" type="text" name="company_code">
                    Company Code
                </x-input>

                <x-input myclass="sm:col-span-5" type="text" name="company_desc">
                    Company Description
                </x-input>

                <x-input myclass="sm:col-span-6" type="text" name="address">
                    Address
                </x-input>

                <x-input myclass="sm:col-span-4" type="text" name="npwp">
                    NPWP
                </x-input>

                <x-input myclass="sm:col-span-3" type="text" name="phone">
                    Phone
                </x-input>

                <x-input myclass="sm:col-span-3" type="text" name="altphone">
                    Alt. Phone
                </x-input>

                <x-slot name="button_type">create</x-slot>
            </x-form>
        </x-content>
        {{-- END CONTENT --}}

        
    </div>


    {{-- END PAGES --}}
@endsection