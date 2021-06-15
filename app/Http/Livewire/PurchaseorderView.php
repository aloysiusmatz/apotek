<?php

namespace App\Http\Livewire;

use App\Models\m_items;
use Livewire\Component;
use App\Models\m_vendors;
use Illuminate\Support\Facades\DB;

class PurchaseorderView extends Component
{
    public $delivery_date;
    public $po_number;
    public $vendor;
    public $payment_terms;

    public $items_cart=[];
    public $selected_cart=-1;
    public $item_qty=0;
    public $item_discount=0;
    public $item_priceunit=0;
    public $item_tax=0;

    public $show_item_search=false;
    public $search_items='';
    public $data_items=[];
    public $items_found=false;

    public $show_vendor_search=false;
    public $search_vendor='';
    public $vendor_result=[];
    public $vendor_found=false;
    public $selected_vendor=[];

    public function render()
    {
        if ($this->search_items != '') {
            $this->searchItems();
        }else{
            $this->data_items=[];
            $this->items_found = true; //jika textbox search masih kosong tidak perlu ditampilkan "no item found"
        }

        if($this->search_vendor != ''){
            $this->searchVendor();
        }else{
            $this->vendor_result=[];
            $this->vendor_found = true;
        }
        
        if(count($this->selected_vendor) >=1 ){
            $this->vendor = $this->selected_vendor['id'].' - '.$this->selected_vendor['name'];
        }

        return view('livewire.purchaseorder-view');
    }

    public function toogleVendorModal(){
        if($this->show_vendor_search){
            $this->show_vendor_search = false;
        }else{
            $this->show_vendor_search = true;
        }
    }

    public function toogleSearchModal(){
        if ($this->show_item_search) {
            $this->show_item_search = false;
        }else{
            $this->show_item_search = true;
        }
    }
    
    public function searchVendor(){
        $this->vendor_found = true;

        $this->vendor_result = DB::table('m_vendors')
                            ->where('company_id', session()->get('company_id'))
                            ->where('name','like','%'.$this->search_vendor.'%')
                            ->orderBy('name', 'asc')
                            ->get();

        if ($this->vendor_result->count()==0) {
            $this->vendor_found = false;
        }
    }

    public function selectVendor($id){

        $m_vendors = DB::table('m_vendors')
                ->where('id',$id)
                ->get();
        
        $this->selected_vendor['id'] = $m_vendors->first()->id;
        $this->selected_vendor['name'] = $m_vendors->first()->name;
        $this->toogleVendorModal();
        $this->search_vendor='';
    }

    public function createVendor(){
        $m_vendors = new m_vendors;
        $m_vendors->company_id = session()->get('company_id');
        $m_vendors->name = $this->search_vendor;
        $m_vendors->save();

        $this->toogleVendorModal();
        $this->selected_vendor['id'] = $m_vendors->id;
        $this->selected_vendor['name'] = $m_vendors->name;
        $this->search_vendor = '';

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
                'discount' => 0,
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
                'discount' => 0,
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
            $this->items_cart[$this->selected_cart]['discount'] = $this->item_discount;
            $this->items_cart[$this->selected_cart]['tax'] = $this->item_tax;
            $this->items_cart[$this->selected_cart]['totalprice'] = ($this->item_qty*$this->item_priceunit)*((100-$this->item_discount)/100)*((100+$this->item_tax)/100);
        }
    }

    public function showItem(){
        $this->item_qty = $this->items_cart[$this->selected_cart]['qty'];
        $this->item_priceunit = $this->items_cart[$this->selected_cart]['priceunit'];
        $this->item_discount = $this->items_cart[$this->selected_cart]['discount'];
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
