<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\companies;

class CompaniesTable extends Component
{
    public $companies;

    protected $listeners = ['companiesChanged' => '$refresh'];


    public function render()
    {
        $companies = DB::select('select * from companies');
        $this->companies = $companies;

        return <<<'blade'
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Company Code</th>
                        <th class="py-3 px-6 text-center">Description</th>
                        <th class="py-3 px-6 text-center">Status</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($companies as $company )
                            <tr class="border-b border-gray-200 hover:bg-gray-100" ">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    {{ $company->company_code }}
                                </td>
                                <td class="py-3 px-6 text-center whitespace-nowrap">
                                    {{ $company->company_desc }}
                                </td>
                                <td class="py-3 px-6 text-center whitespace-nowrap">
                                    
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" wire:click="editCompaniesRow({{$company->id}})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"  wire:click="deleteCompaniesRow({{$company->id}})" >

                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                       
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach    
                </tbody>
            </table>
        blade;
    }


    public function editCompaniesRow($companyid){
        
        $this->emit('editCompaniesRow', $companyid);
    }

    public function deleteCompaniesRow($companyid){
        
        $companies = companies::destroy($companyid);
        $this->emitSelf('companiesChanged');
        //$this->test();
    }

    public function test(){
        dd('test');
    }
}
