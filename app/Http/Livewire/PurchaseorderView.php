<?php

namespace App\Http\Livewire;

use App\Models\t_po_d;
use App\Models\t_po_h;
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
    public $error_list=[];
    public $success_message='';

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
            $this->vendor = $this->selected_vendor['show_id'].' - '.$this->selected_vendor['name'];
        }

        return view('livewire.purchaseorder-view');
    }

    public function initField(){
        $this->delivery_date='';
        $this->po_number='';
        $this->vendor='';
        $this->payment_terms='';
        $this->error_list=[];
    
        $this->items_cart=[];
        $this->selected_cart=-1;
        $this->item_qty=0;
        $this->item_discount=0;
        $this->item_priceunit=0;
        $this->item_tax=0;
    
        $this->selected_vendor=[];
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
        $this->selected_vendor['show_id'] = $m_vendors->first()->show_id;
        $this->selected_vendor['name'] = $m_vendors->first()->name;
        $this->toogleVendorModal();
        $this->search_vendor='';
    }

    public function createVendor(){
        

            // $select_show_id = "select IFNULL(max(show_id), 2000000)+1 as id from m_vendors b WHERE b.company_id='".session()->get('company_id')."' for share";

            // $show_id = DB::select($select_show_id)[0]->id;

            // $m_vendors = m_vendors::create([
            //     'company_id' => session()->get('company_id'),
            //     'show_id' => $show_id,
            //     'name' => $this->search_vendor
            // ]);
        
        DB::beginTransaction();

        $insert = DB::insert('insert into m_vendors(company_id, show_id, name) values (?, (select IFNULL(max(show_id), 2000000)+1 as id from m_vendors b WHERE b.company_id="'.session()->get('company_id').'"), ?)', [
            session()->get('company_id'), 
            $this->search_vendor
            ]);
        
        $m_vendors = DB::table('m_vendors')
                        ->where('company_id', session()->get('company_id'))
                        ->where('name', $this->search_vendor)
                        ->get();
        
        // dd($m_vendors);

        $this->toogleVendorModal();
        $this->selected_vendor['id'] = $m_vendors[0]->id;
        $this->selected_vendor['show_id'] = $m_vendors[0]->show_id;
        $this->selected_vendor['name'] = $m_vendors[0]->name;
        $this->search_vendor = '';
        
        DB::commit();

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
                'show_id' => $m_items->show_id,
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
                'show_id' => $m_items->show_id,
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

    public function closeNotif(){
        $this->error_list=[];   
    }

    public function closeSuccess(){
        $this->success_message='';
    }

    public function add_error_message($message){
        $count = count($this->error_list);
        $this->error_list[$count] = [
            'message' =>
            $message
        ];
    }

    public function savePO(){
        if ($this->selected_cart>=0) {
            $this->saveItem();
        }
        
        $error = false;
        //CEK INPUT
        if ($this->delivery_date == '') {
            $this->add_error_message("Delivery date can't be empty");
            $error = true;
        }
        if(count($this->selected_vendor) ==0 ){
            $this->add_error_message("Select a vendor");
            $error = true;
        }
        if ($this->payment_terms == ''){
            $this->add_error_message("Payment terms can't be empty");
            $error = true;
        }
        if(count($this->items_cart)==0){
            $this->add_error_message("Select at least 1 item");
            $error = true;
        }
        $index=0;
        foreach ($this->items_cart as $item) {
            if ($item['qty']==0 || $item['priceunit']==0) {
                $message = "Line no ".($index+1)." field qty or price can't be 0";
                $this->add_error_message($message);
                $error = true;
            }
            $index++;
        }
        if ($error) {
            return false;
        }
        
        DB::transaction(function () {

            $grand_total = 0;
            foreach ($this->items_cart as $item) {
                $grand_total += $item['totalprice'];
            }
            
            //PO HEADER
            $select_show_id = "select ifnull(max(po_show_id),3000000)+1 as id from t_po_h where company_id='".session()->get('company_id')."' for share";

            $show_id = DB::select($select_show_id)[0]->id;
            
            $t_po_h = t_po_h::create([
                'company_id' => session()->get('company_id'),
                'po_show_id' => $show_id,
                'delivery_date' => $this->delivery_date,
                'vendor_id' => $this->selected_vendor['id'],
                'payment_terms' => $this->payment_terms,
                'grand_total' => $grand_total,
                'deleted' => 0,
                'print' => 0
            ]);
            
            //PO ITEM
            $index=0;
            foreach ($this->items_cart as $item) {
                $t_po_d = t_po_d::create([
                    'id' => $t_po_h->id,
                    'item_sequence' => $index+1,
                    'item_id' => $item['id'],
                    'qty' => $item['qty'],
                    'price_unit' => $item['priceunit'],
                    'discount' => $item['discount'],
                    'tax' => $item['tax'],
                    'final_delivery' => 0
                ]);

                $index++;
            }
             
            $this->success_message = 'PO number '.$show_id.' created';
        });
        
        // dd($this->success_message);
        $this->initField();
        
    }

}
