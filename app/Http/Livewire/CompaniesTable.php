<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\companies;
use App\Models\companies_active;

class CompaniesTable extends Component
{
    public $companies;
    public $search_companies='';
    public $sortby=0;
    public $sortby_before=0;
    public $asc=true;


    protected $listeners = ['companiesChanged' => '$refresh'];


    public function render()
    {
        $query = "select a.*, b.active from companies a, companies_actives b ";
        $sort_query = "";

        if ($this->asc) {
            $sort_query = " asc";
        }else {
            $sort_query = " desc";
        }

        if ($this->search_companies == "") {
            $query .= "where a.id=b.id ";

            if ($this->sortby == 1) {
                $query .= "order by a.company_code". $sort_query;
            }elseif ($this->sortby == 2) {
                $query .= "order by a.company_desc". $sort_query;
            }  
            
        }else {
            $keywords = "%".$this->search_companies."%";
            $query .= "where (a.company_code like '".$keywords."' or company_desc like '".$keywords."') and a.id = b.id";
            if ($this->sortby == 1) {
                $query .= " order by a.company_code". $sort_query;
            }elseif ($this->sortby == 2) {
                $query .= " order by a.company_desc". $sort_quer;
            }
        }
        // dd($query);
        $companies = DB::select($query);
        $this->companies = $companies;

        return <<<'blade'
            <div class="bg-white shadow-md rounded-md overflow-hidden">

                <x-search-table wireprop="wire:model.lazy=search_companies"></x-search-table>
           
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left cursor-pointer" wire:click="sortBy(1)">Company Code</th>
                            <th class="py-3 px-6 text-center cursor-pointer" wire:click="sortBy(2)">Description</th>
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
                                        @if($company->active==1)
                                            <span class="bg-green-400 text-white py-1 px-3 rounded-full text-xs">Active</span>
                                        @else
                                            <span class="bg-gray-400 text-white py-1 px-3 rounded-full text-xs">Not Active</span>
                                        @endif
                                        
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer" wire:click="editCompaniesRow({{$company->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>
                                            <div onclick="return confirm('Are you sure want to delete this data?') || event.stopImmediatePropagation()" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer"  wire:click="deleteCompaniesRow({{$company->id}})" >

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
            </div>

        blade;
    }


    public function editCompaniesRow($companyid){
        
        $this->emit('editCompaniesRow', $companyid);
    }

    public function deleteCompaniesRow($companyid){
        
        $companies = companies::destroy($companyid);
        $companies_active = companies_active::destroy($companyid);

        $this->emitSelf('companiesChanged');
       
    }

    public function sortBy($sortby){
        $this->sortby = $sortby;
        
        if ($this->sortby_before==$sortby) {
            if ($this->asc) {
                $this->asc = false;
            }else {
                $this->asc = true;
            }
        }else {
            $this->asc = true;
        }

        $this->sortby_before = $sortby;
    }

}
