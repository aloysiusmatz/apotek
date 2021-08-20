<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\m_vendors;
use Illuminate\Support\Facades\DB;

class VendorsView extends Component
{
    public $datas1;

    public $form_title1 = 'Create Vendor';
    public $mysubmit1 = "createData1";
    public $dataid1;

    public $name='';
    public $address='';
    public $city='';
    public $country='';
    public $phone='';
    public $alt_phone1='';
    public $alt_phone2='';

    protected $listeners = ['editDataRow1' => 'dataEdit1'];

    public function mount(){
        
    }

    public function render()
    {
        
        $this->formatField1();

        return view('livewire.vendors-view');
    }

    public function initField1(){
        $this->name='';
        $this->address='';
        $this->city='';
        $this->country='';
        $this->phone='';
        $this->alt_phone1='';
        $this->alt_phone2='';
    }

    public function formatField1(){
        if ($this->name != '') {
            $this->name =  strtoupper($this->name);
        }
        
    }

    public function createData1(){
        $this->formatField1();

        $m_items = DB::insert('insert into m_vendors(company_id, show_id, name, address, city, country, phone, alt_phone1, alt_phone2) values (?, (select IFNULL(max(show_id),2000001)+1 FROM m_vendors b where b.company_id = '.session()->get('company_id').'),?,?,?,?,?,?,?)', [
            session()->get('company_id'), 
            $this->name,
            $this->address,
            $this->city,
            $this->country,
            $this->phone,
            $this->alt_phone1,
            $this->alt_phone2
        ]);
            
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

        $datas = m_vendors::find($this->dataid1);

        $datas->name = $this->name;
        $datas->address = $this->address;
        $datas->city = $this->city;
        $datas->country = $this->country;
        $datas->phone = $this->phone;
        $datas->alt_phone1 = $this->alt_phone1;
        $datas->alt_phone2 = $this->alt_phone2;
        $datas->save();
       
        $this->initField1();

        $this->emit('dataChanged1');

        session()->flash('message', 'Data successfully updated.');
    }

    public function dataEdit1($dataid1){

        $edit_data = m_vendors::find($dataid1);

        $this->name = $edit_data->name;
        $this->address = $edit_data->address;
        $this->city = $edit_data->city;
        $this->country = $edit_data->country;
        $this->phone = $edit_data->phone;
        $this->alt_phone1 = $edit_data->alt_phone1;
        $this->alt_phone2 = $edit_data->alt_phone2;
        
        $this->form_title1 = "Update Vendor";
        $this->mysubmit1 = "updateData1";
        $this->dataid1 = $dataid1;

        $this->formatField1();
        $this->render();
    }

    public function changeToCreate1(){
        
        $this->initField1();

        $this->form_title1 = "Create Vendor";
        $this->mysubmit1 = "createData1";
    }
}
