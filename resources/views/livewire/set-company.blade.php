<div class="mt-2 ml-2">
    
    <x-form action="" mysubmit="setCompanySess" bttype="submit" title="Select Company" >
        <div class="col-span-6">
            <x-select wireprop="wire:model.defer=selection_company">
                @foreach ($companydatas as $companydata )
                    <option value="{{ $companydata->company_id }}">{{ $companydata->company_code }}</option>
                @endforeach
            </x-select>
        </div>
        
    </x-form>
</div>