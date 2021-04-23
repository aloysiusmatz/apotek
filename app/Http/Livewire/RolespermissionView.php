<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolespermissionView extends Component
{
    public $datas1;

    public $rolename="";
    public $form_title1 = 'Create Role';
    public $mysubmit1 = "createData1";
    public $dataid1;

    public $permissionname="";
    public $form_title2 = 'Create Permission';
    public $mysubmit2 = "createData2";
    public $dataid2;

    public $form_title3 = 'Assign Permission to Role';
    public $mysubmit3 = "assignPermission";
    public $dataid3;

    public $rolesdatas;
    public $permissiondatas;
    public $selection_role=0;
    public $selection_permission=0;

    

    protected $listeners = ['editDataRow1' => 'dataEdit1',
                            'editDataRow2' => 'dataEdit2'];
    
    public function mount(){
        
        $this->rolesdatas = Role::all();
        $this->permissiondatas = Permission::all();

        $this->selection_role = $this->rolesdatas->first()->id;
        $this->selection_permission = $this->permissiondatas->first()->id;
    }

    public function render()
    {
        $this->rolesdatas = Role::all();
        $this->permissiondatas = Permission::all();

        return view('livewire.rolespermission-view');
    }

    public function initField1(){
        $this->rolename="";
    }

    public function createData1(){
    
        $role = Role::create(['name' => $this->rolename]);

        $this->initField1();

        $this->emit('dataChanged1');

        session()->flash('message', 'Data successfully created.');
    }

    public function updateData1(){
        $datas = Role::find($this->dataid1);

        $datas->name = $this->rolename;
        $datas->save();
       
        $this->initField1();

        $this->emit('dataChanged1');

        session()->flash('message', 'Data successfully updated.');
    }

    public function dataEdit1($dataid1){
        $edit_data = Role::find($dataid1);

        $this->rolename = $edit_data->name;

        $this->form_title1 = "Update Role";
        $this->mysubmit1 = "updateData1";
        $this->dataid1 = $dataid1;
     
        $this->render();
    }

    public function changeToCreate1(){
        
        $this->initField1();

        $this->form_title1 = "Create Role";
        $this->mysubmit1 = "createData1";
    }

// ******************************************************
//     // PERMISSION
// ******************************************************

    public function initField2(){
        $this->permissionname="";
    }

    public function createData2(){
    
        $role = Permission::create(['name' => $this->permissionname]);

        $this->initField2();

        $this->emit('dataChanged2');

        session()->flash('message', 'Data successfully created.');
    }

    public function updateData2(){
        $datas = Permission::find($this->dataid2);

        $datas->name = $this->permissionname;
        $datas->save();
       
        $this->initField2();

        $this->emit('dataChanged2');

        session()->flash('message', 'Data successfully updated.');
    }

    public function dataEdit2($dataid2){
        $edit_data = Permission::find($dataid2);
        $this->permissionname = $edit_data->name;

        $this->form_title2 = "Update Permission";
        $this->mysubmit2 = "updateData2";
        $this->dataid2 = $dataid2;
     
        $this->render();
    }

    public function changeToCreate2(){
        
        $this->initField2();

        $this->form_title2 = "Create Permission";
        $this->mysubmit2 = "createData2";
    }


// ******************************************************
//     // ROLES VS PERMISSION
// ******************************************************
    public function assignPermission(){

        $role = Role::find($this->selection_role);
        $permission = Permission::find($this->selection_permission);

        $role->givePermissionTo($permission);

        $this->emit('dataChanged3');

        session()->flash('message', 'Data successfully assigned.');
    }
}
