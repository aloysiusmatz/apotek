
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
                    
                    <x-input myclass="" type="text" name="company_code" wireprop="wire:model.lazy=company_code" disb="">
                        Company Code
                    </x-input>
            
                    <x-input myclass="" type="text" name="company_desc" wireprop="wire:model.lazy=company_desc" disb="">
                        Company Description
                    </x-input>
            
                    <x-input myclass="" type="text" name="address" wireprop="wire:model.lazy=address" disb="">
                        Address
                    </x-input>
            
                    <x-input myclass="" type="text" name="npwp" wireprop="wire:model.lazy=npwp" disb="">
                        NPWP
                    </x-input>
            
                    <x-input myclass="" type="text" name="phone" wireprop="wire:model.lazy=phone" disb="">
                        Phone
                    </x-input>
            
                    <x-input myclass="" type="text" name="altphone" wireprop="wire:model.lazy=altphone" disb="">
                        Alt. Phone
                    </x-input>

                    <x-input myclass="" type="text" name="city" wireprop="wire:model.lazy=city" disb="">
                        City
                    </x-input>

                    <x-input myclass="" type="text" name="country" wireprop="wire:model.lazy=country" disb="">
                        Country
                    </x-input>

                    <x-input myclass="" type="text" name="postal_code" wireprop="wire:model.lazy=postal_code" disb="">
                        Postal Code
                    </x-input>

                    <x-input myclass="" type="text" name="currency" wireprop="wire:model.lazy=currency" disb="">
                        Currency
                    </x-input>

                    <x-input myclass="" type="text" name="currency_symbol" wireprop="wire:model.lazy=currency_symbol" disb="">
                        Currency Symbol
                    </x-input>

                    <x-input myclass="" type="text" name="default_tax" wireprop="wire:model.lazy=default_tax" disb="">
                        Default Tax
                    </x-input>

                    <x-input myclass="" type="text" name="decimal_display" wireprop="wire:model.lazy=decimal_display" disb="">
                        Decimal Display
                    </x-input>

                    <x-input myclass="" type="text" name="thousands_separator" wireprop="wire:model.lazy=thousands_separator" disb="">
                        Thousands Separator
                    </x-input>

                    <x-input myclass="" type="text" name="decimal_separator" wireprop="wire:model.lazy=decimal_separator" disb="">
                        Decimal Separator
                    </x-input>

                    <x-input myclass="" type="text" name="qty_decimal" wireprop="wire:model.lazy=qty_decimal" disb="">
                        Decimal Places for Qty
                    </x-input>
                    
                    <x-checkbox-active wireprop="wire:model=active">Active</x-checkbox-active>

                </x-form>

            </div>
        
        
        </div>          
    </x-content>
    {{-- END CONTENT --}}

    
</div>


{{-- END PAGES --}}






