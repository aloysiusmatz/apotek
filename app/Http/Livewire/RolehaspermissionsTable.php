<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolehaspermissionsTable extends Component
{
    public $datas;
    public $search_data='';
    public $sortby=0;
    public $sortby_before=0;
    public $asc=true;


    protected $listeners = ['dataChanged3' => '$refresh'];


    public function render()
    {
        $query = "select a.*, b.name as role_name, c.name as permission_name from role_has_permissions a, roles b, permissions c ";
        $sort_query = "";

        if ($this->asc) {
            $sort_query = " asc";
        }else {
            $sort_query = " desc";
        }

        if ($this->search_data == "") {
            $query .= "where a.role_id=b.id and a.permission_id=c.id ";

            if ($this->sortby == 1) {
                $query .= "order by b.name". $sort_query;
            }elseif ($this->sortby == 2) {
                $query .= "order by c.name". $sort_query;
            }
            
        }else {
            $keywords = "%".$this->search_data."%";
            $query .= "where (b.name like '".$keywords."' or c.name like '".$keywords."') and a.role_id=b.id and a.permission_id=c.id ";
            if ($this->sortby == 1) {
                $query .= " order by b.name". $sort_query;
            }elseif ($this->sortby == 2) {
                $query .= " order by c.name". $sort_query;
            }
        }
        if ($this->sortby == 0) {
           $query.= "order by role_name asc";
        }
        // dd($query);
        $datas = DB::select($query);
        $this->datas = $datas;

        return <<<'blade'
            <div class="bg-white shadow-md rounded-md overflow-hidden">
                <div class="ml-2 mt-2">
                    
                    <p class="text-md font-bold"> Roles VS Permission</p>
                    
                </div>

                <x-search-table wireprop="wire:model.lazy=search_data"></x-search-table>
           
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                            <th class="py-2 px-6 text-center cursor-pointer" wire:click="sortBy(1)">Roles</th>
                            <th class="py-2 px-6 text-center cursor-pointer" wire:click="sortBy(2)">Permissions</th>
                            <th class="py-2 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                </table>
                <div class="max-h-56 overflow-y-scroll">
                    <table class="min-w-max w-full table-auto">
                        <tbody class="text-gray-600 text-sm font-light ">
                                @foreach ($datas as $data )
                                    <tr class="border-b border-gray-200 hover:bg-gray-100" ">
                                        <td class="py-1 px-6 text-center whitespace-nowrap">
                                            {{ $data->role_name }}
                                        </td>
                                        <td class="py-1 px-6 text-center whitespace-nowrap">
                                            {{ $data->permission_name }}
                                        </td>
                                        <td class="py-1 px-6 text-center">
                                            <div class="flex item-center justify-center">
                                                
                                                <div onclick="return confirm('Are you sure want to delete this data?') || event.stopImmediatePropagation()" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"  wire:click="deleteDataRow('{{$data->role_id}}','{{$data->permission_id}}')" >

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


    public function editDataRow($id){
        
        // $this->emit('editDataRow3', $id);
    }

    public function deleteDataRow($roleid, $permissionid){
         $role = Role::find($roleid);
         $permission = Permission::find($permissionid);

         $role->revokePermissionTo($permission);
        
        $this->render();
       
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
