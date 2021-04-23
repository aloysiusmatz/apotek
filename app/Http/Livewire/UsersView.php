<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\users_active;

class UsersView extends Component
{
    public $datas;
    public $email;
    public $name;
    public $password;
    public $active=1;
    public $form_title = 'Create User';
    public $mysubmit = "createData";
    public $dataid;

    public $form_title2 = 'Assign Role';
    public $mysubmit2 = "createData2";
    
    public $form_title3 = 'Assign Permission';
    public $mysubmit3 = "createData3";

    public $rolesdatas;
    public $permissiondatas;
    public $selection_role;
    public $selection_permission;

    public $user_selected=0;

    protected $listeners = ['editDataRow' => 'dataEdit',
                            'selectDataRow' => 'setDataSelected'];

    public function mount(){
        
        $this->rolesdatas = Role::all();
        $this->permissiondatas = Permission::all();

        $rolesdatas = $this->rolesdatas;
        $permissiondatas = $this->permissiondatas;

        $this->selection_role = $rolesdatas->first()->id;
        $this->selection_permission = $permissiondatas->first()->id;
        // dd( $this->roledatas);
    }

    public function render()
    {
        
        $this->roledatas = Role::all();
        $this->permissiondatas = Permission::all();

        return view('livewire.users-view');
    }

    public function initField(){
        $this->email = "";
        $this->name = "";
        $this->password = "";
        $this->active = "1";
    }


    public function createData(){
    
        $datas = new User;
        $datas->email = $this->email;
        $datas->name = $this->name;
        $datas->password = Hash::make($this->password);
        $datas->save();

        $data_active = new users_active;
        $data_active->id = $datas->id;
        $data_active->email = $this->email;
        $data_active->active = $this->active;

        $data_active->save();

        $this->initField();

        $this->emit('dataChanged');

        session()->flash('message', 'Data successfully created.');
    }

    public function updateData(){
        $datas = User::find($this->dataid);
        $datas->email = $this->email;
        $datas->name = $this->name;
        $datas->save();

        $data_active = users_active::find($this->dataid);
        $data_active->active = $this->active;
        $data_active->save();
       
        $this->initField();

        $this->emit('dataChanged');

        session()->flash('message', 'Data successfully updated.');
    }

    public function dataEdit($dataid){
        $edit_data = User::find($dataid);
        $this->email = $edit_data->email;
        $this->name = $edit_data->name;
        
        $edit_data_active = users_active::find($dataid);
        $this->active = $edit_data_active->active;
        
        $this->form_title = "Update User";
        $this->mysubmit = "updateData";
        $this->dataid = $dataid;
     
        $this->render();
    }

    public function changeToCreate(){
        
        $this->initField();

        $this->form_title = "Create Users";
        $this->mysubmit = "createData";
    }

    public function setDataSelected($dataid){
        $this->user_selected = $dataid;
    }

    public function createData2(){
        if ($this->user_selected==0) {
            session()->flash('message', 'Select a user first');
        }else{

            $user = User::find($this->user_selected);
            $role = Role::find($this->selection_role);

            $user->assignRole($role);
            session()->flash('message', 'User '.$user->email.' assigned to role '. $role->name);

            $this->emit('dataChanged2');
        }
    }

    public function createData3(){
        if ($this->user_selected==0) {
            session()->flash('message', 'Select a user first');
        }else{
            $user = User::find($this->user_selected);
            $permission = Permission::find($this->selection_permission);
            $user->givePermissionTo($permission);
            session()->flash('message', 'User '.$user->email.' assigned to permission '. $permission->name);

            $this->emit('dataChanged3');
        }
    }
}