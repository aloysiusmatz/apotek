<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\m_items;

class ItemsTable extends Component
{
    use WithPagination;

    public $data_array;
    public $data_links;
    public $current_page;
    public $total_pages;
    // public $datas;
    public $search_data='';
    public $sortby=0;
    public $sortby_before=0;
    public $asc=true;


    protected $listeners = ['dataChanged1' => '$refresh'];


    public function render()
    {
        // $query = "select a.* from m_items a ";
        $sort_query = "";

        if ($this->asc) {
            $sort_query = "asc";
        }else {
            $sort_query = "desc";
        }
        
        // if ($this->search_data == "") {
        //     // $query .= "where a.id=b.id ";

        // }else {
        //     $keywords = "%".$this->search_data."%";
        //     $query .= "where a.name like '".$keywords."'";
            
        // }

        // if ($this->sortby == 1) {
        //     $query .= "order by a.id". $sort_query;
        // }elseif ($this->sortby == 2) {
        //     $query .= "order by a.name". $sort_query;
        // }elseif ($this->sortby == 3) {
        //     $query .= "order by a.selling_price". $sort_query;
        // }elseif ($this->sortby == 4) {
        //     $query .= "order by a.lock". $sort_query;
        // }



        // dd($query);
        // $datas = DB::select($query);
        
        $sort_column="";

        if ($this->sortby == 1) {
            $sort_column = 'id';
        }elseif ($this->sortby == 2) {
            $sort_column = 'name';
        }elseif ($this->sortby == 3) {
            $sort_column = 'selling_price';
        }elseif ($this->sortby == 4) {
            $sort_column = 'lock';
        }else{
            $sort_column = 'id';
        }

        if ($this->search_data == "") {
            $datas = DB::table('m_items')
                        ->where('company_id', session()->get('company_id'))
                        ->orderBy($sort_column, $sort_query)
                        ->paginate(15);
                        

        }else {
            $keywords = "%".$this->search_data."%";
            $datas = DB::table('m_items')
                        ->where('company_id', session()->get('company_id'))
                        ->where('name', 'like', $keywords)
                        ->orderBy($sort_column, $sort_query)
                        ->paginate(15);
        }
        
        $this->data_array = $datas->items();
        $this->current_page = $datas->currentPage();
        $this->total_pages = $datas->lastPage();

        
        // $this->data_links = $datas->links()->element();
        // dd($datas->links());
        // dd($this->data_array);
        // dd($this->current_page.' '.$datas->currentPage());
        // $this->datas = $datas;

        return <<<'blade'
            <div class="bg-white shadow-md rounded-md overflow-hidden">
                

                <x-search-table wireprop="wire:model.lazy=search_data"></x-search-table>
                
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                            <th class="py-2 px-6 text-center cursor-pointer" wire:click="sortBy(1)">Item Number</th>
                            <th class="py-2 px-6 text-center cursor-pointer" wire:click="sortBy(2)">Name</th>
                            <th class="py-2 px-6 text-center cursor-pointer" wire:click="sortBy(3)">Selling Price</th>
                            <th class="py-2 px-6 text-center cursor-pointer" wire:click="sortBy(4)">Lock</th>
                            <th class="py-2 px-6 text-center cursor-pointer">Actions</th>
                        </tr>
                    </thead>
               
                    <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($data_array as $data )
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-2 px-6 text-center whitespace-nowrap">
                                        {{ $data->show_id }}
                                    </td>
                                    <td class="py-2 px-6 text-center whitespace-nowrap">
                                        {{ $data->name }}
                                    </td>
                                    <td class="py-2 px-6 text-center whitespace-nowrap">
                                        {{ $data->selling_price }}
                                    </td>
                                    <td class="py-2 px-6 text-center whitespace-nowrap">
                                        @if($data->lock==0)
                                            <span class="bg-green-400 text-white py-1 px-3 rounded-full text-xs">Unlocked</span>
                                        @else
                                            <span class="bg-gray-400 text-white py-1 px-3 rounded-full text-xs">Locked</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-6 text-center">
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
                
                @if($total_pages>1)
                    <div class="m-2 flex justify-between">
                    
                        @if($current_page=='1')
                            <button name="btn_previous" id="btn_previous" class="px-2 py-2 bg-gray-100 rounded-md text-gray-200 text-sm shadow-sm" wire:click="previousPage">
                                Previous
                            </button>
                        @else
                            <button name="btn_previous" id="btn_previous" class="px-2 py-2 cursor-pointer bg-gray-100 rounded-md text-gray-600 text-sm shadow-sm" wire:click="previousPage">
                                Previous
                            </button>
                        @endif
                        
                        <div class="flex">
                            @for ($i=1;$i<=$total_pages;$i++)
                                @if($current_page==$i)
                                    <button class="mx-1 px-2 py-2 cursor-pointer bg-blue-400 rounded-md text-gray-100 text-sm shadow-sm" wire:click="gotoPage({{$i}})">
                                        {{ $i }}
                                    </button>
                                @else
                                    <button class="mx-1 px-2 py-2 cursor-pointer bg-gray-100 rounded-md text-gray-500 text-sm shadow-sm" wire:click="gotoPage({{$i}})">
                                        {{ $i }}
                                    </button>
                                @endif
                                
                            @endfor
                        </div>

                        @if($current_page==$total_pages)
                            <button name="btn_previous" id="btn_next" class="px-2 py-2 bg-gray-100 rounded-md text-gray-200 text-sm shadow-sm" >
                                Next
                            </button>
                        @else
                            <button name="btn_previous" id="btn_next" class="px-2 py-2 cursor-pointer bg-gray-100 rounded-md text-gray-600 text-sm shadow-sm" wire:click="nextPage">
                            Next
                            </button>
                        @endif
                        
                    </div>
                @endif
            </div>
            
        blade;
    }


    public function editDataRow($id){
        
        $this->emit('editDataRow1', $id);
    }

    public function deleteDataRow($id){
        
        $data = m_items::destroy($id);
        
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
