<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\movement_keys;
use Illuminate\Support\Facades\DB;

class MovementkeyTable extends Component
{
    public $datas;
    public $search_data='';
    public $sortby=0;
    public $sortby_before=0;
    public $asc=true;


    protected $listeners = ['dataChanged1' => '$refresh'];


    public function render()
    {
        
        $sort_query = "";

        if ($this->asc) {
            $sort_query = "asc";
        }else {
            $sort_query = "desc";
        }
        
        $sort_column="companies.company_code";

        if ($this->sortby == 1) {
            $sort_column = 'companies.company_code';
        }elseif ($this->sortby == 2) {
            $sort_column = 'movement_keys.name';
        }elseif ($this->sortby == 3) {
            $sort_column = 'movement_keys.behaviour';
        }

        if ($this->search_data == "") {
            $datas = DB::table('movement_keys')
                        ->join('companies', 'movement_keys.company_id', '=', 'companies.id')
                        ->select('movement_keys.id as move_id', 'movement_keys.company_id', 'companies.company_code', 'movement_keys.name', 'movement_keys.behaviour', 'movement_keys.active')
                        ->orderBy($sort_column, $sort_query)
                        ->get();
                        
        }else {
            $keywords = "%".$this->search_data."%";
            $datas = DB::table('movement_keys')
                        ->join('companies', 'movement_keys.company_id', '=', 'companies.id')
                        ->select('movement_keys.id as move_id', 'movement_keys.company_id', 'companies.company_code', 'movement_keys.name', 'movement_keys.behaviour', 'movement_keys.active')
                        ->where('movement_keys.name', 'like', $keywords)
                        ->orWhere('companies.company_code', 'like', $keywords)
                        ->orderBy($sort_column, $sort_query)
                        ->get();
        }
        
        $this->datas = $datas; 
        // dd($datas);
        // $this->data_array = $datas->items();
        // $this->current_page = $datas->currentPage();
        // $this->total_pages = $datas->lastPage();

        return <<<'blade'
            <div class="bg-white shadow-md rounded-md overflow-hidden">
                

                <x-search-table wireprop="wire:model.lazy=search_data"></x-search-table>
                
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                            <th class="py-2 px-6 text-center cursor-pointer" wire:click="sortBy(1)">Companies</th>
                            <th class="py-2 px-6 text-center cursor-pointer" wire:click="sortBy(2)">Movement Keys</th>
                            <th class="py-2 px-6 text-center cursor-pointer" wire:click="sortBy(3)">Behaviour</th>
                            <th class="py-2 px-6 text-center cursor-pointer" >Status</th>
                            <th class="py-2 px-6 text-center cursor-pointer">Actions</th>
                        </tr>
                    </thead>
               
                    <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($datas as $data )
                                <tr class="border-b border-gray-200 hover:bg-gray-100" ">
                                    <td class="py-2 px-6 text-center whitespace-nowrap">
                                        {{ $data->company_code }}
                                    </td>
                                    <td class="py-2 px-6 text-center whitespace-nowrap">
                                        {{ $data->name }}
                                    </td>
                                    <td class="py-2 px-6 text-center whitespace-nowrap">
                                        {{ $data->behaviour }}
                                    </td>
                                    <td class="py-2 px-6 text-center whitespace-nowrap">
                                        @if($data->active==1)
                                            <span class="bg-green-400 text-white py-1 px-3 rounded-full text-xs">Active</span>
                                        @else
                                            <span class="bg-gray-400 text-white py-1 px-3 rounded-full text-xs">Not Active</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer" wire:click="editDataRow({{$data->move_id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>
                                            <div onclick="return confirm('Are you sure want to delete this data?') || event.stopImmediatePropagation()" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer"  wire:click="deleteDataRow({{$data->move_id}})" >

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


    public function editDataRow($id){
        
        $this->emit('editDataRow1', $id);
    }

    public function deleteDataRow($id){
        
        $data = movement_keys::destroy($id);
        
        $this->emitSelf('dataChanged1');
        
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
