<?php

namespace App\Http\Livewire;

use App\Models\m_items;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PurchaseorderView extends Component
{
    public $items_cart=[];
    public $selected_cart=-1;
    public $item_qty=0;
    public $item_priceunit=0;
    public $item_tax=0;

    public $show_item_search=false;
    public $search_items='';
    public $data_items=[];
    public $items_found=false;

    public function render()
    {
        if ($this->search_items != '') {
            $this->searchItems();
        }else{
            $this->data_items=[];
            $this->items_found = true;
        }
        
        return view('livewire.purchaseorder-view');
    }

    public function toogleSearchModal(){
        if ($this->show_item_search) {
            $this->show_item_search = false;
        }else{
            $this->show_item_search = true;
        }
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
            $this->saveItem();
            $this->items_cart[$count] = [
                'id' => $id, 
                'name' => $m_items->name,
                'qty' => 1,
                'priceunit' => 0,
                'unit' => $m_items->unit,
                'tax' => 10,
                'totalprice' => 0
            ];
        }else{
            $this->items_cart[0] = [
                'id' => $id, 
                'name' => $m_items->name,
                'qty' => 1,
                'priceunit' => 0,
                'unit' => $m_items->unit,
                'tax' => 10,
                'totalprice' => 0
            ];
        }
        
        $this->search_items = '';
        $this->data_items = [];
        $this->items_found = true;
        $this->selected_cart = $count;
        
        // $this->setItemDetail();
        $this->showItem();
        $this->toogleSearchModal();
    }

    public function editItem($index){
        if ($this->selected_cart>=0) {
            $this->saveItem();
        }
        $this->selected_cart = $index;
        $this->showItem();
        
    }

    public function saveItem(){
        if ($this->selected_cart>=0) {
            $this->items_cart[$this->selected_cart]['qty'] = $this->item_qty;
            $this->items_cart[$this->selected_cart]['priceunit'] = $this->item_priceunit;
            $this->items_cart[$this->selected_cart]['tax'] = $this->item_tax;
            $this->items_cart[$this->selected_cart]['totalprice'] = ($this->item_qty*$this->item_priceunit)*(100+$this->item_tax)/100;
        }
    }

    public function showItem(){
        $this->item_qty = $this->items_cart[$this->selected_cart]['qty'];
        $this->item_priceunit = $this->items_cart[$this->selected_cart]['priceunit'];
        $this->item_tax = $this->items_cart[$this->selected_cart]['tax'];
    }

    public function deleteItem($index){
        if ($this->selected_cart>=0) {
            $this->saveItem();
        }
        array_splice($this->items_cart, $index, 1);
        $this->selected_cart = count($this->items_cart)-1;
        
    }

    public function loseSelected(){
        if ($this->selected_cart>=0) {
            $this->saveItem();
        }
        $this->selected_cart=-1;
    }

    public function add_error_message($message){
        $count = count($this->error_list);
        $this->error_list[$count] = [
            'message' =>
            $message
        ];
    }

}
