<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\m_items;

class ItemsView extends Component
{
    public $datas1;

    public $form_title1 = 'Create Item';
    public $mysubmit1 = "createData1";
    public $dataid1;

    public $item_code;
    public $item_name;
    public $item_desc;
    public $selling_price;
    public $item_lock=0;

    protected $listeners = ['editDataRow1' => 'dataEdit1'];

    
    public function mount(){
        

    }

    public function render()
    {

        return view('livewire.items-view');
    }

    public function initField1(){
        $this->item_code = "";
        $this->item_name = "";
        $this->item_desc = "";
        $this->selling_price = "";
        $this->item_lock = 0;
    }

    public function createData1(){
        
        $m_items = new m_items;
        $m_items->name = $this->item_name;
        $m_items->desc = $this->item_desc;
        $m_items->selling_price = $this->selling_price;
        $m_items->lock = $this->item_lock;
        $m_items->save();

        $this->emit('dataChanged1');

        $this->initField1();
        session()->flash('message', 'Data successfully created.');
    }

    public function updateData1(){
        $datas = m_items::find($this->dataid1);

        $datas->name = $this->item_name;
        $datas->desc = $this->item_desc;
        $datas->selling_price = $this->selling_price;
        $datas->lock = $this->item_lock;
        $datas->save();
       
        $this->initField1();

        $this->emit('dataChanged1');

        session()->flash('message', 'Data successfully updated.');
    }

    public function dataEdit1($dataid1){
        $edit_data = m_items::find($dataid1);

        $this->item_code = $edit_data->id;
        $this->item_name = $edit_data->name;
        $this->item_desc = $edit_data->desc;
        $this->selling_price = $edit_data->selling_price;
        $this->item_lock = $edit_data->lock;
        

        $this->form_title1 = "Update Items";
        $this->mysubmit1 = "updateData1";
        $this->dataid1 = $dataid1;
     
        $this->render();
    }

    public function changeToCreate1(){
        
        $this->initField1();

        $this->form_title1 = "Create Item";
        $this->mysubmit1 = "createData1";
    }

// ******************************************************
//     // 
// ******************************************************

    public function initField2(){
        // $this->permissionname="";
    }

    public function createData2(){
    
        // $role = Permission::create(['name' => $this->permissionname]);

        // $this->initField2();

        // $this->emit('dataChanged2');

        // session()->flash('message', 'Data successfully created.');
    }

    public function updateData2(){
        // $datas = Permission::find($this->dataid2);

        // $datas->name = $this->permissionname;
        // $datas->save();
       
        // $this->initField2();

        // $this->emit('dataChanged2');

        // session()->flash('message', 'Data successfully updated.');
    }

    public function dataEdit2($dataid2){
        // $edit_data = Permission::find($dataid2);
        // $this->permissionname = $edit_data->name;

        // $this->form_title2 = "Update Permission";
        // $this->mysubmit2 = "updateData2";
        // $this->dataid2 = $dataid2;
     
        // $this->render();
    }

    public function changeToCreate2(){
        
        // $this->initField2();

        // $this->form_title2 = "Create Permission";
        // $this->mysubmit2 = "createData2";
    }



}
