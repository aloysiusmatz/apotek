<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\m_vendors;
use Illuminate\Support\Facades\DB;

class VendorsTable extends Component
{
    public $datas;
    public $search_data='';
    public $sortby=0;
    public $sortby_before=0;
    public $asc=true;
    public $selected_data=0;

    protected $listeners = ['dataChanged1' => '$refresh'];

    public function render()
    {
        $query = "select a.* from m_vendors a ";
        $sort_query = "";

        if ($this->asc) {
            $sort_query = " asc";
        }else {
            $sort_query = " desc";
        }

        if ($this->search_data == "") {
            $query .= "where company_id = '".session()->get('company_id')."' ";

            if ($this->sortby == 1) {
                $query .= "order by a.show_id". $sort_query;
            }elseif ($this->sortby == 2) {
                $query .= "order by a.name". $sort_query;
            }elseif ($this->sortby == 3) {
                $query .= "order by a.city". $sort_query;
            }
            
        }else {
            $keywords = "%".$this->search_data."%";
            $query .= "where (a.show_id like '".$keywords."' or a.name like '".$keywords."') and company_id = '".session()->get('company_id')."' ";

            if ($this->sortby == 1) {
                $query .= "order by a.show_id". $sort_query;
            }elseif ($this->sortby == 2) {
                $query .= "order by a.name". $sort_query;
            }elseif ($this->sortby == 3) {
                $query .= "order by a.city". $sort_query;
            }
        }
        // dd($query);
        $datas = DB::select($query);
        $this->datas = $datas;

        return <<<'blade'
            <div class="bg-white shadow-md rounded-md overflow-hidden">

                <x-search-table wireprop="wire:model.debounce.500ms=search_data"></x-search-table>
                <div class="">
                <table class=" w-full">
                    <thead>
                        <tr class=" bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="w-4/12 py-2 px-5 text-center cursor-pointer" wire:click="sortBy(1)">Vendor ID</th>
                            <th class="w-5/12 py-2 px-6 text-center cursor-pointer" wire:click="sortBy(2)">Name</th>
                            <th class="w-2/12 py-2 px-6 text-center cursor-pointer" wire:click="sortBy(3)">City</th>
                            <th class="w-1/12 py-2 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody >               
                        @foreach ($datas as $data )
                            @if($selected_data==$data->id)
                            <tr class="w-full text-gray-600 text-sm font-light border-b bg-blue-200 border-gray-200 hover:bg-blue-100" >
                            @else
                            <tr class="w-full text-gray-600 text-sm font-light border-b border-gray-200 hover:bg-gray-100" >
                            @endif
                                <td class="w-4/12 py-2 px-6 text-center whitespace-nowrap cursor-pointer" wire:click="selectDataRow({{$data->id}})">
                                    {{ $data->show_id }}
                                </td>
                                <td class="w-5/12 py-2 px-6 text-center whitespace-nowrap">
                                    {{ $data->name }}
                                </td>
                                <td class="w-5/12 py-2 px-6 text-center whitespace-nowrap">
                                    {{ $data->city }}
                                </td>
                                <td class="w-1/12 py-2 px-6 items-center text-center">
                                    <div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer" wire:click="editDataRow({{$data->id}})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </div>
                                        <div onclick="return confirm('Are you sure want to delete this data?') || event.stopImmediatePropagation()" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer"  wire:click="deleteDataRow({{$data->id}})" >

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
            </div>

        blade;
    }


    public function selectDataRow($id){
        
        $this->selected_data=$id;
        $this->emit('selectDataRow', $id);
        $this->emit('clearView');
    }

    public function editDataRow($id){
        
        $this->selected_data=$id;
        $this->emit('selectDataRow', $id);
        $this->emit('editDataRow1', $id);
    }

    public function deleteDataRow($id){
        $this->selected_data=0;

        $data = m_vendors::destroy($id);
        
        $this->emitSelf('dataChanged1');
        $this->emit('selectDataRow', 0);
       
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
