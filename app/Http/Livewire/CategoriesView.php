<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\m_categories;

class CategoriesView extends Component
{
    public $datas1;

    public $form_title1 = 'Create Category';
    public $mysubmit1 = "createData1";
    public $dataid1;

    public $category_name;

    protected $listeners = ['editDataRow1' => 'dataEdit1'];

    
    public function mount(){
        

    }

    public function render()
    {
        $this->formatField1();
        
        return view('livewire.categories-view');
    }

    public function initField1(){
        $this->category_name = "";
        $this->dataid1 = 0;
    }

    public function formatField1(){
        $this->category_name = strtoupper($this->category_name);
    }

    public function createData1(){
        $this->formatField1();

        $datas1 = new m_categories;
        $datas1->company_id = session()->get('company_id');
        $datas1->name = $this->category_name;
        $datas1->save();

        $this->emit('dataChanged1');

        $this->initField1();
        session()->flash('message', 'Data successfully created.');
    }

    public function updateData1(){
        $this->formatField1();

        if ($this->dataid1 == 0) {
            session()->flash('message', 'Please select a data to update');
            return;
        }

        $datas1 = m_categories::find($this->dataid1);

        $datas1->name = $this->category_name;
        $datas1->save();
       
        $this->initField1();

        $this->emit('dataChanged1');

        session()->flash('message', 'Data successfully updated.');
    }

    public function dataEdit1($dataid1){
        $edit_data = m_categories::find($dataid1);

        $this->category_name = $edit_data->name;
        
        $this->form_title1 = "Update Category";
        $this->mysubmit1 = "updateData1";
        $this->dataid1 = $dataid1;
     
        $this->formatField1();
        $this->render();
    }

    public function changeToCreate1(){
        
        $this->initField1();

        $this->form_title1 = "Create Category";
        $this->mysubmit1 = "createData1";
    }

}
