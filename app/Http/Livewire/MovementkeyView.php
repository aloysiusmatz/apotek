<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\movement_keys;
use Illuminate\Support\Facades\DB;

class MovementkeyView extends Component
{
    public $datas1;

    public $form_title1 = 'Create Movement Key';
    public $mysubmit1 = "createData1";
    public $dataid1;

    public $companiesdatas=[];
    public $selection_company='';
    public $trans_name='';
    public $active=1;
    public $selection_behaviour='GR';
    public $selection_type='INIT';

    protected $listeners = ['editDataRow1' => 'dataEdit1'];

    
    public function mount(){
        

    }

    public function render()
    {
        $this->companiesdatas = DB::table('companies')
                            ->get();
        
        if ($this->companiesdatas->count() >= 1 && $this->selection_company == 0) {
            $this->selection_company = $this->companiesdatas->first()->id;
        }

        $this->formatField1();

        return view('livewire.movementkey-view');
    }

    public function initField1(){
        $this->trans_name = '';
        $this->active = 1;
        $this->selection_behaviour = 'GR';
        $this->selection_type = 'INIT';
        $this->dataid1 = 0;
    }

    public function formatField1(){
        $this->trans_name =  strtoupper($this->trans_name);
    }

    public function createData1(){
        $this->formatField1();

        $datas1 = new movement_keys;
        $datas1->company_id = $this->selection_company;
        $datas1->name = $this->trans_name;
        $datas1->active = $this->active;
        $datas1->type = $this->selection_type;
        $datas1->behaviour = $this->selection_behaviour;
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

        $datas = movement_keys::find($this->dataid1);

        $datas->company_id = $this->selection_company;
        $datas->name = $this->trans_name;
        $datas->active = $this->active;
        $datas->type = $this->selection_type;
        $datas->behaviour = $this->selection_behaviour;
        $datas->save();
       
        $this->initField1();

        $this->emit('dataChanged1');

        session()->flash('message', 'Data successfully updated.');
    }

    public function dataEdit1($dataid1){

        $edit_data = movement_keys::find($dataid1);

        $this->selection_company = $edit_data->company_id;
        $this->trans_name = $edit_data->name;
        $this->active = $edit_data->active;
        $this->selection_type = $edit_data->type;
        $this->selection_behaviour = $edit_data->behaviour;
        
        $this->form_title1 = "Update Movement Key";
        $this->mysubmit1 = "updateData1";
        $this->dataid1 = $dataid1;

        $this->formatField1();
        $this->render();
    }

    public function changeToCreate1(){
        
        $this->initField1();

        $this->form_title1 = "Create Movement Key";
        $this->mysubmit1 = "createData1";
    }
}
