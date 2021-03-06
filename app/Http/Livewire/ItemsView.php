<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\m_items;
use Illuminate\Support\Facades\DB;

class ItemsView extends Component
{
    public $datas1;

    public $form_title1 = 'Create Item';
    public $mysubmit1 = "createData1";
    public $dataid1;

    public $item_code;
    public $item_name;
    public $item_desc;
    public $item_unit;
    public $selling_price;
    public $item_lock=0;
    public $selection_category=0;
    public $categoriesdatas=[];
    public $selection_batchas='EXP';

    protected $listeners = ['editDataRow1' => 'dataEdit1'];

    
    public function mount(){
        

    }

    public function render()
    {
        $this->categoriesdatas = DB::table('m_categories')
                            ->where('company_id', session()->get('company_id'))
                            ->get();
        
        if ($this->categoriesdatas->count() >= 1 && $this->selection_category == 0) {
            $this->selection_category = $this->categoriesdatas->first()->id;
        }

        $this->formatField1();

        return view('livewire.items-view');
    }

    public function initField1(){
        $this->item_code = "";
        $this->item_name = "";
        $this->item_desc = "";
        $this->item_unit = "";
        $this->selling_price = "";
        $this->selection_category = 0;
        $this->item_lock = 0;
        $this->dataid1 = 0;
    }

    public function formatField1(){
        if ($this->item_name != '') {
            $this->item_name =  strtoupper($this->item_name);
        }
        if ($this->item_unit != '') {
            $this->item_unit =  strtoupper($this->item_unit);
        }
        
        
    }

    public function createData1(){
        $this->formatField1();

        DB::beginTransaction();

        $m_items = DB::insert('insert into m_items(company_id,show_id,category_id,name,`desc` ,unit,selling_price,`lock`,batch_as) values (?, (select IFNULL(max(show_id),1000000)+1 FROM m_items b where b.company_id = '.session()->get('company_id').'),?,?,?,?,?,?,?)', [
            session()->get('company_id'), 
            $this->selection_category,
            $this->item_name,
            $this->item_desc,
            strtoupper($this->item_unit),
            $this->selling_price,
            $this->item_lock,
            $this->selection_batchas
            ]);
        
        DB::commit();
        // $m_items = new m_items;
        // $m_items->company_id = session()->get('company_id');
        
        // $m_items->category_id = $this->selection_category;
        // $m_items->name = $this->item_name;
        // $m_items->desc = $this->item_desc;
        // $m_items->unit = strtoupper($this->item_unit);
        // $m_items->selling_price = $this->selling_price;
        // $m_items->batch_as = $this->selection_batchas;
        // $m_items->lock = $this->item_lock;
        // $m_items->save();

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

        $datas = m_items::find($this->dataid1);

        $datas->category_id = $this->selection_category;
        $datas->name = $this->item_name;
        $datas->desc = $this->item_desc;
        $datas->unit = strtoupper($this->item_unit);
        $datas->selling_price = $this->selling_price;
        $datas->batch_as = $this->selection_batchas;
        $datas->lock = $this->item_lock;
        $datas->save();
       
        $this->initField1();

        $this->emit('dataChanged1');

        session()->flash('message', 'Data successfully updated.');
    }

    public function dataEdit1($dataid1){

        $edit_data = m_items::find($dataid1);

        $this->selection_category = $edit_data->category_id;
        $this->item_code = $edit_data->id;
        $this->item_name = $edit_data->name;
        $this->item_desc = $edit_data->desc;
        $this->item_unit = $edit_data->unit;
        $this->selling_price = $edit_data->selling_price;
        $this->selection_batchas = $edit_data->batch_as;
        $this->item_lock = $edit_data->lock;
        

        $this->form_title1 = "Update Items";
        $this->mysubmit1 = "updateData1";
        $this->dataid1 = $dataid1;

        $this->formatField1();
        $this->render();
    }

    public function changeToCreate1(){
        
        $this->initField1();

        $this->form_title1 = "Create Item";
        $this->mysubmit1 = "createData1";
    }



}
