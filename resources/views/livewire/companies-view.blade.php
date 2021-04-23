
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
        <div class='flex grid grid-cols-6'>
            <div class="w-full col-span-4 ">
            
                @livewire('companies-table')

            </div>

            <div class="col-span-2 ml-2">
    
                @if ($mysubmit=="updateCompanies")
                <div>
                    <x-button-topcreate wire:click="changeToCreate">Create</x-button-topcreate>
                </div>
                @endif

                
                @if (session()->has('message'))
                    <div class="mb-2 alert alert-success bg-green-500 px-2 py-3 text-white rounded-md   ">
                        {{ session('message') }}
                    </div>
                @endif
                

                <x-form action="" mysubmit="{{ $mysubmit }}" bttype="submit" title="{{ $form_title }}" >
                    
                    <x-input myclass="" type="text" name="company_code" wireprop="wire:model.lazy=company_code">
                        Company Code
                    </x-input>
            
                    <x-input myclass="" type="text" name="company_desc" wireprop="wire:model.lazy=company_desc">
                        Company Description
                    </x-input>
            
                    <x-input myclass="" type="text" name="address" wireprop="wire:model.lazy=address">
                        Address
                    </x-input>
            
                    <x-input myclass="" type="text" name="npwp" wireprop="wire:model.lazy=npwp">
                        NPWP
                    </x-input>
            
                    <x-input myclass="" type="text" name="phone" wireprop="wire:model.lazy=phone">
                        Phone
                    </x-input>
            
                    <x-input myclass="" type="text" name="altphone" wireprop="wire:model.lazy=altphone">
                        Alt. Phone
                    </x-input>
                    
                    <x-checkbox-active wireprop="wire:model=active">Active</x-checkbox-active>

                </x-form>

            </div>
        
        
        </div>          
    </x-content>
    {{-- END CONTENT --}}

    
</div>


{{-- END PAGES --}}






