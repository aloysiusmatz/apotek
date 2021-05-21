<?php

namespace App\Http\Livewire;

use App\Models\m_items;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ItemsmovementView extends Component
{
    public $selected_movkey=0;
    public $selected_movkey_type='';
    public $selection_movkeys=[];
    public $posting_date = '';
    public $items_cart=[];
    public $search_items='';
    public $data_items=[];
    public $items_found=true;
    public $selected_cart=-1;
    public $selection_to_locations=[];
    public $selection_from_locations=[];
    public $item_detail_qty=1;
    public $from_location=0;
    public $to_location=0;
    public $from_batch=0;
    public $to_batch=0;
    public $item_detail_amount=0;
    public $items_cart_details=[];
    public $cnt=0;

    public function render()
    {
        if ($this->search_items != '') {
            $this->searchItems();
        }else{
            $this->data_items=[];
            $this->items_found = true;
        }

        $this->loadMovkey();
        $this->loadLocation();
    
        return view('livewire.itemsmovement-view');
    }

    public function loadMovkey(){
        $this->selection_movkeys = DB::table('movement_keys')
        ->whereIn('type', ['INIT','OWV','OWOV','TRANS'])
        ->get();

        if ($this->selected_movkey == 0) {
            $this->selected_movkey = $this->selection_movkeys->first()->id;
            $this->selected_movkey_type = $this->selection_movkeys->first()->type;
        }else{
            $this->selected_movkey_type = $this->selection_movkeys->firstWhere('id',$this->selected_movkey)->type;
            
        }
        
    }

    public function loadLocation(){
        
        $this->selection_to_locations = DB::table('m_locations')
                                        ->select('id','name')
                                        ->where('company_id', session()->get('company_id'))
                                        ->orderBy('name', 'asc')
                                        ->get();
            
    }

    public function initField(){
        $selected_movkey=0;
        $selection_movkeys=[];
        $posting_date = '';
        $items_cart=[];
    }

    public function searchItems(){
        $this->items_found = true;

        $this->data_items = DB::table('m_items')
                        ->where('company_id', session()->get('company_id'))
                        ->where('lock', 0)
                        ->where('name', 'like', '%'.$this->search_items.'%')
                        ->orderBy('name', 'asc')
                        ->get();
        
        if ($this->data_items->count()==0) {
            $this->items_found = false;
        }
        // dd($this->data_items->count());
    }

    public function addItem($id){

        $m_items = m_items::find($id);

        $count = count($this->items_cart);

        if ($count>=1) {
            $this->saveItemDetail();
            $this->items_cart[$count] = ['id' => $id, 'name' => $m_items->name];
        }else{
            $this->items_cart[0] = ['id' => $id, 'name' => $m_items->name];
        }
        
        $this->search_items = '';
        $this->data_items = [];
        $this->items_found = true;
        $this->selected_cart = $count;
        
        $this->setItemDetail();
        $this->showItemDetail();
    }

    public function deleteItem($index){
        array_splice($this->items_cart, $index, 1);
        // dd($this->items_cart);
    }

    public function showItem($index){
        $this->saveItemDetail();

        $this->selected_cart=$index;

        $this->showItemDetail();
        // dd($this->selected_cart=$index);
    }

    public function setItemDetail(){
        $this->items_cart_details[$this->selected_cart] = [
            'qty' => 1,
            'from_location' => '',
            'to_location' => '',
            'from_batch' => '',
            'to_batch' => '',
            'amount' => 1
        ];
        // dd($this->items_cart_details);
    }

    public function saveItemDetail(){
        $this->items_cart_details[$this->selected_cart] = [
            'qty' => $this->item_detail_qty,
            'from_location' => $this->from_location,
            'to_location' => $this->to_location,
            'from_batch' => $this->from_batch,
            'to_batch' => $this->to_batch,
            'amount' => $this->item_detail_amount
        ];
        // dd($this->items_cart_details);
    }

    public function showItemDetail(){

        $this->item_detail_qty = $this->items_cart_details[$this->selected_cart]['qty'];
        $this->from_location = $this->items_cart_details[$this->selected_cart]['from_location'];
        $this->to_location =$this->items_cart_details[$this->selected_cart]['to_location'];
        $this->from_batch =$this->items_cart_details[$this->selected_cart]['from_batch'];
        $this->to_batch = $this->items_cart_details[$this->selected_cart]['to_batch'];
        $this->item_detail_amount =$this->items_cart_details[$this->selected_cart]['amount'];
    
    }
}