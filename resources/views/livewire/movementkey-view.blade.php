{{-- PAGES --}}
            
<div class="bg-gray-100 w-screen">
                
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 flex justify-between dark:border-gray-600">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
            Movement Keys
        </h2>

        <div class="flex">
            @if (session()->has('message'))
            <div class=" alert alert-success px-2 py-1 text-green-500 rounded-md text-sm text-center font-bold">
                {{ session('message') }}
            </div>
            @endif

            @if ($mysubmit1=="updateData1")
                <div>
                    <x-button-topcreate wire:click="changeToCreate1">Create Movement Key</x-button-topcreate>
                </div>
            @endif

        </div>
       
        
    </div>
    {{-- END NAVIGATION BAR --}}

    {{-- CONTENT --}}
    <x-content>
        <div class='flex grid grid-cols-12'>
            <div class="w-full col-span-8">
                @livewire('movementkey-table')
            </div>
            
            <div class="col-span-4 ml-2">
                
                {{-- ITEMS --}}
                <div>
                    

                    
                    {{-- @if (session()->has('message'))
                        <div class="mb-2 alert alert-success bg-green-500 px-2 py-3 text-white rounded-md">
                            {{ session('message') }}
                        </div>
                    @endif --}}
                    

                    <x-form action="" mysubmit="{{ $mysubmit1 }}" bttype="submit" title="{{ $form_title1 }}" >
                        
                        <x-input myclass="" type="text" name="trans_name" wireprop="wire:model.lazy=trans_name" disb="">
                            Transcation Name
                        </x-input>

                        <div class="col-span-6">
                            <label for="selection_company" class="block text-sm font-medium text-gray-700">Companies</label>
                            
                            <x-select wireprop="wire:model.defer=selection_company">
                                @foreach ($companiesdatas as $companiesdata )
                                    <option value="{{ $companiesdata->id }}">{{ $companiesdata->company_code }}</option>
                                @endforeach
                            </x-select>
                        </div>

                        <div class="col-span-6">
                            <label for="selection_type" class="block text-sm font-medium text-gray-700">Type</label>
                            
                            <x-select wireprop="wire:model.defer=selection_type">
                                
                                <option value="INIT">Init</option>
                                <option value="PURC">Purchase</option>
                                <option value="OWV">Others with Value</option>
                                <option value="OWOV">Others without Value</option>
                                <option value="TRANS">Transfer</option>
                                <option value="SELL">Sell</option>
                                
                            </x-select>
                        </div>

                        <div class="col-span-6">
                            <label for="selection_behaviour" class="block text-sm font-medium text-gray-700">Behaviour</label>
                            
                            <x-select wireprop="wire:model.defer=selection_behaviour">
                                
                                <option value="GR">GR</option>
                                <option value="GI">GI</option>
                                <option value="TRANS">TRANS</option>
                                
                            </x-select>
                        </div>

                        <x-checkbox-active wireprop="wire:model.lazy=active">
                            Active
                        </x-checkbox-active>
                    </x-form>

                </div>
                {{-- END ITEMS --}}

            
            </div>
        
        </div>          
    </x-content>


    {{-- END CONTENT --}}
</div>


{{-- END PAGES --}}