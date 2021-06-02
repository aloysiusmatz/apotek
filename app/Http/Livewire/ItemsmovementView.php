<?php

namespace App\Http\Livewire;

use auth;
use App\Models\m_items;
use Livewire\Component;
use App\Models\t_invstock;
use App\Models\t_itmove_d;
use App\Models\t_itmove_h;
use App\Models\m_locations;
use App\Models\t_pricehist;
use Illuminate\Support\Facades\DB;

class ItemsmovementView extends Component
{
    public $selected_movkey=0;
    public $selected_movkey_type='';
    public $selected_movkey_name='';
    public $selected_movkey_behaviour='';
    public $selection_movkeys=[];
    public $posting_date = '';
    public $desc='';
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
    public $error_list=[];
    public $show_item_search=false;
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
        ->where('active',1)
        ->get();

        if ($this->selected_movkey == 0) {
            $this->selected_movkey = $this->selection_movkeys->first()->id;
            $this->selected_movkey_type = $this->selection_movkeys->first()->type;
            $this->selected_movkey_behaviour = $this->selection_movkeys->first()->behaviour;
            $this->selected_movkey_name = $this->selection_movkeys->first()->name;
        }else{
            $this->selected_movkey_type = $this->selection_movkeys->firstWhere('id',$this->selected_movkey)->type;
            $this->selected_movkey_behaviour = $this->selection_movkeys->firstWhere('id',$this->selected_movkey)->behaviour;
            $this->selected_movkey_name = $this->selection_movkeys->firstWhere('id',$this->selected_movkey)->name;
        }
        
    }

    public function loadLocation(){
        
        $this->selection_to_locations = DB::table('m_locations')
                                        ->select('id','name')
                                        ->where('company_id', session()->get('company_id'))
                                        ->orderBy('name', 'asc')
                                        ->get();
        
        if ($this->selected_movkey_behaviour=='TRANS') {
            if ($this->from_location==0) {
                $this->from_location = $this->selection_to_locations->first()->id;
            }
        }
        if ($this->selected_movkey_behaviour=='GR' || $this->selected_movkey_behaviour=='GI'|| $this->selected_movkey_behaviour=='TRANS') {
            if ($this->to_location==0) {
                $this->to_location = $this->selection_to_locations->first()->id;
            }
        }
    }

    public function initField(){
        $selected_movkey=0;
        $selection_movkeys=[];
        $posting_date = '';
        $items_cart=[];
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
        $this->toogleSearchModal();
    }

    public function deleteItem($index){
        $this->saveItemDetail();

        array_splice($this->items_cart, $index, 1);
        array_splice($this->items_cart_details, $index, 1);
        
        $this->selected_cart = count($this->items_cart)-1;
        if ($this->selected_cart >= 0) {
            $this->showItemDetail();
        }
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

    public function add_error_message($message){
        $count = count($this->error_list);
        $this->error_list[$count] = [
            'message' =>
            $message
        ];
    }

    public function postItemMovement(){
        $error = false;
        $this->error_list=[];

        $this->saveItemDetail();

        //cek input
        if($this->posting_date==''){
            $this->add_error_message('Posting date cannot be empty');
        }
        if(count($this->items_cart)==0){
            $this->add_error_message('Select at least one item');
        }
        if ($this->selected_movkey_type=='INIT' && $this->items_cart_details[$index]['amount']==0) {
            $this->add_error_message('Amount must be greater than 0');
        }
        if ($this->selected_movkey_type=='PURC' || $this->selected_movkey_type=='OWOV' || $this->selected_movkey_type=='TRANS' || $this->selected_movkey_type=='SELL') {
            $this->items_cart_details[$index]['amount'] = 0;
        }

        //show error message
        if(count($this->error_list)>0){
            $error = true;
            return $error;
        }

        $posting_date = date_create($this->posting_date);
        $month = date_format($posting_date, 'n');
        $year = date_format($posting_date,'Y');
        
        $previous_date = date_modify($posting_date,'last day of previous month');
        $previous_month = date_format($previous_date,'n');
        $previous_year = date_format($previous_date,'Y');

        
        //cek stock
        if ($this->selected_movkey_behaviour == 'GI' || $this->selected_movkey_behaviour == 'TRANS') {
            $index=0;
            
            foreach ($this->items_cart as $item_cart) {
                if ($this->selected_movkey_behaviour == 'GI'){
                    $location_id = $this->items_cart_details[$index]['to_location'];
                    $batch = $this->items_cart_details[$index]['to_batch'];
                }elseif ($this->selected_movkey_behaviour == 'TRANS') {
                    $location_id = $this->items_cart_details[$index]['from_location'];
                    $batch = $this->items_cart_details[$index]['from_batch'];
                }
                $get_ending_inv = DB::table('t_invstock')
                                    ->where('item_id',$item_cart['id'])
                                    ->where('location_id',$location_id)
                                    ->where('batch',$batch)
                                    ->where('category', 'ending')
                                    ->orderBy('year','desc')
                                    ->orderBy('period','desc')
                                    ->limit(1)
                                    ->get();
                
                $ending_stock = $get_ending_inv->first()->qty;
                
                if ($ending_stock < $this->items_cart_details[$index]['qty']) {
                    $location_name = m_locations::find($this->items_cart_details[$index]['to_location'])->name;
                    
                    $this->add_error_message('Insufficient stock of item '.$item_cart['id'].'-'.$item_cart['name'].' location '.$location_name.', batch '.$this->items_cart_details[$index]['to_batch']);

                }
                $index++;
            }
        }

        //show error message
        if(count($this->error_list)>0){
            $error = true;
            return $error;
        }
        
        //start transaction
        DB::transaction(function () {
            $posting_date = date_create($this->posting_date);
            $month = date_format($posting_date, 'n');
            $year = date_format($posting_date,'Y');
            
            $previous_date = date_modify($posting_date,'last day of previous month');
            $previous_month = date_format($previous_date,'n');
            $previous_year = date_format($previous_date,'Y');
            
            //record item header
            $t_itmove_h = t_itmove_h::create([
                'posting_date' => $this->posting_date,
                'user_id' => auth()->user()->id,
                'company_id' => session()->get('company_id'),
                'movement_id' => $this->selected_movkey,
                'desc' => $this->desc
            ]);

            //record item detail
            $index=0;
            if ($this->selected_movkey_behaviour == 'GR') {
                foreach ($this->items_cart as $item_cart) {
                    $t_itmove_d[$index] = t_itmove_d::create([
                        'id' => $t_itmove_h->id,
                        'item_id' => $item_cart['id'],
                        'to_loc' => $this->items_cart_details[$index]['to_location'],
                        'to_batch' => $this->items_cart_details[$index]['to_batch'],
                        'qty' => $this->items_cart_details[$index]['qty'],
                        'amount' => $this->items_cart_details[$index]['amount']
                    ]);
                    $index++;
                }
                
            }elseif ($this->selected_movkey_behaviour == 'GI') {
                foreach ($this->items_cart as $item_cart) {
                    $t_itmove_d[$index] = t_itmove_d::create([
                        'id' => $t_itmove_h->id,
                        'item_id' => $item_cart['id'],
                        'from_loc' => $this->items_cart_details[$index]['to_location'],
                        'from_batch' => $this->items_cart_details[$index]['to_batch'],
                        'qty' => $this->items_cart_details[$index]['qty'],
                        'amount' => $this->items_cart_details[$index]['amount']
                    ]);
                    $index++;
                }
            }elseif ($this->selected_movkey_behaviour == 'TRANS') {
                foreach ($this->items_cart as $item_cart) {
                    $t_itmove_d[$index] = t_itmove_d::create([
                        'id' => $t_itmove_h->id,
                        'item_id' => $item_cart['id'],
                        'from_loc' => $this->items_cart_details[$index]['from_location'],
                        'to_loc' => $this->items_cart_details[$index]['to_location'],
                        'from_batch' => $this->items_cart_details[$index]['from_batch'],
                        'to_batch' => $this->items_cart_details[$index]['to_batch'],
                        'qty' => $this->items_cart_details[$index]['qty'],
                        'amount' => $this->items_cart_details[$index]['amount']
                    ]);
                    $index++;
                }
            }
            
            //record inventory stock
            $index=0;
            if ($this->selected_movkey_behaviour == 'GR') {
                foreach ($this->items_cart as $item_cart) {
                    $get_t_invstock = DB::table('t_invstock')
                                        ->where('item_id',$item_cart['id'])
                                        ->where('period',$month)
                                        ->where('year',$year)
                                        ->where('location_id',$this->items_cart_details[$index]['to_location'])
                                        ->where('batch',$this->items_cart_details[$index]['to_batch'])
                                        ->get();

                    $get_t_invstock_previous = DB::table('t_invstock')
                                        ->where('item_id',$item_cart['id'])
                                        ->where('period',$previous_month)
                                        ->where('year',$previous_year)
                                        ->where('location_id',$this->items_cart_details[$index]['to_location'])
                                        ->where('batch',$this->items_cart_details[$index]['to_batch'])
                                        ->where('category', 'ending')
                                        ->get();   

                    if(count($get_t_invstock)==0){
                        if (count($get_t_invstock_previous)==0) {
                            $qty = 0;
                        }else{
                            $qty = $get_t_invstock_previous->first()->qty;
                        }

                        $t_invstock = t_invstock::create([
                            'item_id' => $item_cart['id'],
                            'period' => $month ,
                            'year' => $year ,
                            'location_id' => $this->items_cart_details[$index]['to_location'] ,
                            'batch' => $this->items_cart_details[$index]['to_batch'] ,
                            'category' => 'begin' ,
                            'qty' => $qty
                        ]);
                        $t_invstock = t_invstock::create([
                            'item_id' => $item_cart['id'],
                            'period' => $month ,
                            'year' => $year ,
                            'location_id' => $this->items_cart_details[$index]['to_location'] ,
                            'batch' => $this->items_cart_details[$index]['to_batch'] ,
                            'category' => 'ending' ,
                            'qty' => $qty
                        ]);
                        
                    }
                    
                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $this->items_cart_details[$index]['to_location'] ,
                        'batch' => $this->items_cart_details[$index]['to_batch'] ,
                        'category' => $this->selected_movkey_name ,
                        'qty' => $this->items_cart_details[$index]['qty']
                    ]);

                    $update_ending = DB::update(
                        'update t_invstock set qty=qty+'.$this->items_cart_details[$index]['qty'].'
                        where item_id=? and period=? and year=? and location_id=? and batch=? and category=?',
                        [
                            $item_cart['id'],
                            $month,
                            $year,
                            $this->items_cart_details[$index]['to_location'],
                            $this->items_cart_details[$index]['to_batch'],
                            'ending'
                        ]
                    );

                    $index++;
                }
            }elseif ($this->selected_movkey_behaviour == 'GI') {
                foreach ($this->items_cart as $item_cart) {
                    $get_t_invstock = DB::table('t_invstock')
                                        ->where('item_id',$item_cart['id'])
                                        ->where('period',$month)
                                        ->where('year',$year)
                                        ->where('location_id',$this->items_cart_details[$index]['to_location'])
                                        ->where('batch',$this->items_cart_details[$index]['to_batch'])
                                        ->get();

                    $get_t_invstock_previous = DB::table('t_invstock')
                                        ->where('item_id',$item_cart['id'])
                                        ->where('period',$previous_month)
                                        ->where('year',$previous_year)
                                        ->where('location_id',$this->items_cart_details[$index]['to_location'])
                                        ->where('batch',$this->items_cart_details[$index]['to_batch'])
                                        ->where('category', 'ending')
                                        ->get();   

                    if(count($get_t_invstock)==0){
                        if (count($get_t_invstock_previous)==0) {
                            $qty = 0;
                        }else{
                            $qty = $get_t_invstock_previous->first()->qty;
                        }

                        $t_invstock = t_invstock::create([
                            'item_id' => $item_cart['id'],
                            'period' => $month ,
                            'year' => $year ,
                            'location_id' => $this->items_cart_details[$index]['to_location'] ,
                            'batch' => $this->items_cart_details[$index]['to_batch'] ,
                            'category' => 'begin' ,
                            'qty' => $qty
                        ]);
                        $t_invstock = t_invstock::create([
                            'item_id' => $item_cart['id'],
                            'period' => $month ,
                            'year' => $year ,
                            'location_id' => $this->items_cart_details[$index]['to_location'] ,
                            'batch' => $this->items_cart_details[$index]['to_batch'] ,
                            'category' => 'ending' ,
                            'qty' => $qty
                        ]);
                        
                    }
                    
                    $qty = $this->items_cart_details[$index]['qty']*-1; //GI nilai normalnya adalah negatif

                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $this->items_cart_details[$index]['to_location'] ,
                        'batch' => $this->items_cart_details[$index]['to_batch'] ,
                        'category' => $this->selected_movkey_name ,
                        'qty' => $qty
                    ]);

                    $update_ending = DB::update(
                        'update t_invstock set qty=qty+'.$qty.'
                        where item_id=? and period=? and year=? and location_id=? and batch=? and category=?',
                        [
                            $item_cart['id'],
                            $month,
                            $year,
                            $this->items_cart_details[$index]['to_location'],
                            $this->items_cart_details[$index]['to_batch'],
                            'ending'
                        ]
                    );
                    $index++;
                }
            }elseif ($this->selected_movkey_behaviour == 'TRANS') {
                foreach ($this->items_cart as $item_cart) {
                    //record "from"
                    $get_t_invstock_from = DB::table('t_invstock')
                                        ->where('item_id',$item_cart['id'])
                                        ->where('period',$month)
                                        ->where('year',$year)
                                        ->where('location_id',$this->items_cart_details[$index]['from_location'])
                                        ->where('batch',$this->items_cart_details[$index]['from_batch'])
                                        ->get();

                    $get_t_invstock_previous_from = DB::table('t_invstock')
                                        ->where('item_id',$item_cart['id'])
                                        ->where('period',$previous_month)
                                        ->where('year',$previous_year)
                                        ->where('location_id',$this->items_cart_details[$index]['from_location'])
                                        ->where('batch',$this->items_cart_details[$index]['from_batch'])
                                        ->where('category', 'ending')
                                        ->get();   

                    if(count($get_t_invstock_from)==0){
                        if (count($get_t_invstock_previous_from)==0) {
                            $qty = 0;
                        }else{
                            $qty = $get_t_invstock_previous_from->first()->qty;
                        }

                        $t_invstock = t_invstock::create([
                            'item_id' => $item_cart['id'],
                            'period' => $month ,
                            'year' => $year ,
                            'location_id' => $this->items_cart_details[$index]['from_location'] ,
                            'batch' => $this->items_cart_details[$index]['from_batch'] ,
                            'category' => 'begin' ,
                            'qty' => $qty
                        ]);
                        $t_invstock = t_invstock::create([
                            'item_id' => $item_cart['id'],
                            'period' => $month ,
                            'year' => $year ,
                            'location_id' => $this->items_cart_details[$index]['from_location'] ,
                            'batch' => $this->items_cart_details[$index]['from_batch'] ,
                            'category' => 'ending' ,
                            'qty' => $qty
                        ]);
                        
                    }
                    
                    $qty = $this->items_cart_details[$index]['qty']*-1;

                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $this->items_cart_details[$index]['from_location'] ,
                        'batch' => $this->items_cart_details[$index]['from_batch'] ,
                        'category' => $this->selected_movkey_name ,
                        'qty' => $qty
                    ]);

                    $update_ending = DB::update(
                        'update t_invstock set qty=qty+'.$qty.'
                        where item_id=? and period=? and year=? and location_id=? and batch=? and category=?',
                        [
                            $item_cart['id'],
                            $month,
                            $year,
                            $this->items_cart_details[$index]['from_location'],
                            $this->items_cart_details[$index]['from_batch'],
                            'ending'
                        ]
                    );

                    //record "to"
                    $get_t_invstock_to = DB::table('t_invstock')
                                        ->where('item_id',$item_cart['id'])
                                        ->where('period',$month)
                                        ->where('year',$year)
                                        ->where('location_id',$this->items_cart_details[$index]['to_location'])
                                        ->where('batch',$this->items_cart_details[$index]['to_batch'])
                                        ->get();

                    $get_t_invstock_previous_to = DB::table('t_invstock')
                                        ->where('item_id',$item_cart['id'])
                                        ->where('period',$previous_month)
                                        ->where('year',$previous_year)
                                        ->where('location_id',$this->items_cart_details[$index]['to_location'])
                                        ->where('batch',$this->items_cart_details[$index]['to_batch'])
                                        ->where('category', 'ending')
                                        ->get();   

                    if(count($get_t_invstock_to)==0){
                        if (count($get_t_invstock_previous_to)==0) {
                            $qty = 0;
                        }else{
                            $qty = $get_t_invstock_previous_to->first()->qty;
                        }

                        $t_invstock = t_invstock::create([
                            'item_id' => $item_cart['id'],
                            'period' => $month ,
                            'year' => $year ,
                            'location_id' => $this->items_cart_details[$index]['to_location'] ,
                            'batch' => $this->items_cart_details[$index]['to_batch'] ,
                            'category' => 'begin' ,
                            'qty' => $qty
                        ]);
                        $t_invstock = t_invstock::create([
                            'item_id' => $item_cart['id'],
                            'period' => $month ,
                            'year' => $year ,
                            'location_id' => $this->items_cart_details[$index]['to_location'] ,
                            'batch' => $this->items_cart_details[$index]['to_batch'] ,
                            'category' => 'ending' ,
                            'qty' => $qty
                        ]);
                        
                    }
                    
                    $qty = $this->items_cart_details[$index]['qty'];

                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $this->items_cart_details[$index]['to_location'] ,
                        'batch' => $this->items_cart_details[$index]['to_batch'] ,
                        'category' => $this->selected_movkey_name ,
                        'qty' => $qty
                    ]);

                    $update_ending = DB::update(
                        'update t_invstock set qty=qty+'.$qty.'
                        where item_id=? and period=? and year=? and location_id=? and batch=? and category=?',
                        [
                            $item_cart['id'],
                            $month,
                            $year,
                            $this->items_cart_details[$index]['to_location'],
                            $this->items_cart_details[$index]['to_batch'],
                            'ending'
                        ]
                    );


                    $index++;
                }
            }
          
            //add price history
            $index=0;
            if ($this->selected_movkey_behaviour == 'GR'){

                foreach ($this->items_cart as $item_cart) {
                    //get last price history of this item
                    $latest_record = DB::table('t_pricehist')
                                        ->where('item_id', $item_cart['id'])
                                        ->latest()->get();

                    if(count($latest_record) > 0){
                        $total_qty = $latest_record->first()->total_qty + $this->items_cart_details[$index]['qty'];
                        $total_amount = $latest_record->first()->total_amount + $this->items_cart_details[$index]['amount'];
                    }else {
                        $total_qty = $this->items_cart_details[$index]['qty'];
                        $total_amount = $this->items_cart_details[$index]['amount'];
                    }
                    
                    $cogs = $total_amount / $total_qty;

                    $t_pricehist = t_pricehist::create([
                        'posting_date' => $this->posting_date,
                        'movement_id' => $t_itmove_h->id,
                        'movement_key' => $this->selected_movkey,
                        'item_id' => $item_cart['id'],
                        'qty' => $this->items_cart_details[$index]['qty'],
                        'amount' => $this->items_cart_details[$index]['amount'],
                        'total_qty' => $total_qty,
                        'total_amount' => $total_amount,
                        'cogs' => $cogs
                    ]);
                    $index++;
                }

            }elseif ($this->selected_movkey_behaviour == 'GI') {
                foreach ($this->items_cart as $item_cart) {
                    //get last price history of this item
                    $latest_record = DB::table('t_pricehist')
                                        ->where('item_id', $item_cart['id'])
                                        ->latest()->get();

                    $qty = $this->items_cart_details[$index]['qty']*-1;
                    $amount = 0;

                    if(count($latest_record) > 0){
                        $total_qty = $latest_record->first()->total_qty + $qty;
                        if ($this->selected_movkey_type=='OWV') {
                            $amount = $latest_record->first()->cogs * $qty;
                        }elseif ($this->selected_movkey_type=='OWOV') {
                            $amount = 0;
                        }
                        
                        if ($total_qty==0) {
                            $total_amount = 0;
                        }else{
                            $total_amount = $latest_record->first()->total_amount + $amount;
                            if ($total_amount < 0) {
                                $total_amount = 0;
                            }
                        }
                        
                    }else {
                        //seharusnya tidak mungkin masuk kesini, karena stock harus ada baru bisa GI
                        $total_qty = $qty;
                        $total_amount = $amount;
                    }
                    
                    $cogs = $total_amount / $total_qty;

                    $t_pricehist = t_pricehist::create([
                        'posting_date' => $this->posting_date,
                        'movement_id' => $t_itmove_h->id,
                        'movement_key' => $this->selected_movkey,
                        'item_id' => $item_cart['id'],
                        'qty' => $qty,
                        'amount' => $amount,
                        'total_qty' => $total_qty,
                        'total_amount' => $total_amount,
                        'cogs' => $cogs
                    ]);

                    $amount_itmove_d = $amount*-1;
                    
                    $update_itmove_d = DB::update(
                        'update t_itmove_d set amount='.$amount_itmove_d.' where id=?',
                        [$t_itmove_h->id]
                    );
                    $index++;
                }
            }elseif ($this->selected_movkey_behaviour == 'TRANS') {
                # code...
            }
            
            
        });
        
    }
}