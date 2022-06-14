<?php

namespace App\Http\Livewire;

use App\Models\t_so_d;
use App\Models\t_so_h;
use Livewire\Component;
use App\Models\m_customers;
use Illuminate\Support\Facades\DB;


class SalesorderView extends Component
{

    public $error_list=[];
    public $success_message='';
    public $additem_query='';
    public $search_item_result=[];
    public $so_item=[];

    public $delivery_date='';
    public $customer_id='';
    public $customer_desc='';
    public $payment_terms ='';
    public $soitem_qty=[];
    public $soitem_price=[];
    public $soitem_disc=[];
    public $soitem_tax=[];
    public $grandtotal=0;
    

    public function render()
    {
        $this->checkAddItemQuery();
        $this->checkItemInputField();
        $this->calculateGrandTotal();
        
        return view('livewire.salesorder-view');
    }

    public function add_error_message($message){
        $count = count($this->error_list);
        $this->error_list[$count] = [
            'message' =>
            $message
        ];
    }

    public function closeNotif(){
        $this->error_list=[];  
    }

    public function checkAddItemQuery(){
        if($this->additem_query!=''){
            $this->searchAddItemQuery($this->additem_query);
        }else{
            $this->search_item_result=[];
        }
    } 

    public function checkItemInputField(){

        $cnt = 0;
        foreach ($this->soitem_qty as $data) {
            
            if ($this->soitem_qty[$cnt]=='') {
                $this->soitem_qty[$cnt] = 0;
            }
            if ($this->soitem_price[$cnt]=='') {
                $this->soitem_price[$cnt] = 0;
            }
            if ($this->soitem_disc[$cnt]=='') {
                $this->soitem_disc[$cnt] = 0;
            }
            if ($this->soitem_tax[$cnt]=='') {
                $this->soitem_tax[$cnt] = 0;
            }
            
            $this->so_item[$cnt]['qty'] = $this->soitem_qty[$cnt];
            $this->so_item[$cnt]['price_unit'] = $this->soitem_price[$cnt];
            $this->so_item[$cnt]['discount'] = $this->soitem_disc[$cnt];
            $this->so_item[$cnt]['tax'] = $this->soitem_tax[$cnt];
            $this->so_item[$cnt]['subtotal'] = 
            ($this->soitem_qty[$cnt]*$this->soitem_price[$cnt])*
            ((100-$this->soitem_disc[$cnt])/100)*
            ((100+$this->soitem_tax[$cnt])/100);
            
            $cnt += 1;
        }
    }

    public function searchAddItemReset(){
        $this->additem_query = '';
        $this->search_item_result=[];
    }

    public function calculateGrandTotal(){

        $this->grandtotal = 0;
        foreach ($this->so_item as $data) {
            $this->grandtotal += $data['subtotal'];
        }

    }

    public function searchAddItemQuery($keyword){
        
        $query = "
        select id, show_id, name
        from m_items
        where company_id = '".session()->get('company_id')."' and
        ( id like '%".$keyword."%' or name like '%".$keyword."%' )
        ";

        $search = DB::select($query);

        $result=[];
        $index=0;
        foreach ($search as $data) {
            $result[$index] = (array) $data;
            $index++;
        }
        
        $this->search_item_result = $result;

    }

    public function addItemSO($item_id){

        $m_items = DB::table('m_items')
                    ->where('id', $item_id)
                    ->where('company_id', session()->get('company_id'))
                    ->get();
        if(count($m_items)==0){
            return false;
        }else {
            $m_items = $m_items->first();
        }
        
        $index = count($this->so_item);
       
        $this->so_item[$index]['id'] = '';
        $this->so_item[$index]['item_sequence'] = $index+1;
        $this->so_item[$index]['item_id'] = $item_id;
        $this->so_item[$index]['qty'] = 0;
        $this->so_item[$index]['item_unit'] = $m_items->unit;
        $this->so_item[$index]['price_unit'] = $m_items->selling_price;
        $this->so_item[$index]['discount'] = 0;
        $this->so_item[$index]['tax'] = session()->get('default_tax');
        $this->so_item[$index]['final_delivery'] = 0; 
        $this->so_item[$index]['created_at'] = '';
        $this->so_item[$index]['updated_at'] = '';
        $this->so_item[$index]['item_show_id'] = $m_items->show_id;
        $this->so_item[$index]['item_name'] = $m_items->name;
        $this->so_item[$index]['subtotal'] = 0;
        $this->so_item[$index]['deleted'] = 0;

        $this->soitem_qty[$index] = $this->so_item[$index]['qty'];
        $this->soitem_price[$index] = $this->so_item[$index]['price_unit'];
        $this->soitem_disc[$index] = $this->so_item[$index]['discount'];
        $this->soitem_tax[$index] = $this->so_item[$index]['tax'];
        
        $this->searchAddItemReset();
    }

    public function deleteItemSO($index){
        array_splice($this->so_item, $index, 1);
        $this->soitem_qty = [];
        $this->soitem_price = [];
        $this->soitem_disc = [];
        $this->soitem_tax = [];

        $cnt=0;
        foreach ($this->so_item as $data) {
            $this->so_item[$cnt]['item_sequence'] = $cnt+1;
            $this->soitem_qty[$cnt] = $this->so_item[$cnt]['qty'];
            $this->soitem_price[$cnt] = $this->so_item[$cnt]['price_unit'];
            $this->soitem_disc[$cnt] = $this->so_item[$cnt]['discount'];
            $this->soitem_tax[$cnt] = $this->so_item[$cnt]['tax'];
            $cnt += 1;
        }
    }

    public function saveSO(){
        $error = false;
        //check input
        if (count($this->so_item)==0) {
            $error = true;
            $this->add_error_message('Please add SO item');
        }
        if ($this->delivery_date == '') {
            $error = true;
            $this->add_error_message('Delivery date required');
        }
        if ($this->customer_id == ''){
            $error = true;
            $this->add_error_message('Customer ID required');
        }
        if ($this->customer_desc == '') {
            $error = true;
            $this->add_error_message('Customer desc required');
        }

        if ($error) {
            return false;
        }

        //write to database
        DB::beginTransaction();

        // $select_show_id = "select ifnull(max(so_show_id),4000000)+1 as id from t_so_h where company_id='".session()->get('company_id')."' for share";
        
        $select_show_id = DB::table('t_so_h')
                                ->select(DB::raw('ifnull(max(so_show_id),4000000)+1 as id'))
                                ->where('company_id', session()->get('company_id'))
                                ->sharedLock()
                                ->get();

        $show_id = DB::select($select_show_id)[0]->id;

        $select_customer = "select * from m_customers where company_id='".session()->get('company_id')."' and show_id='".$this->customer_id."' ";
        $customer = DB::select($select_customer);
        
        $customer_id='';
        if (count($customer) == 0) {
            
            $m_customers = m_customers::create([
                'company_id' => session()->get('company_id'),
                'show_id' => $this->customer_id,
                'tax_id' => '0000',
                'name' => $this->customer_desc,
                'address' => '',
                'city' => '',
                'country' => '',
                'phone' => '',
                'alt_phone1' => '',
                'alt_phone2' => ''
            ]);
            $customer_id = $m_customer->id;
        }else{
            // dd($customer);
            $customer_id = $customer[0]->id;
        }
            
        
        $t_so_h = t_so_h::create([
            'company_id' => session()->get('company_id'),
            'so_show_id' => $show_id,
            'delivery_date' => $this->delivery_date,
            'customer_id' => $customer_id,
            'customer_desc' => $this->customer_desc,
            'payment_terms' => $this->payment_terms,
            'grand_total' => $this->grandtotal,
            'deleted' => 0,
            'print' => 0,
            'ship_to_address' => '',
            'ship_to_country' => '',
            'ship_to_postal_code' => '',
            'ship_to_phone1' => '',
            'ship_to_phone2' => '',
            'shipping_value' => 0,
            'other_value' => 0,
            'note' => ''
        ]);

        foreach ($this->so_item as $data) {
            $t_so_d = t_so_d::create([
                'id' => $t_so_h->id,
                'item_sequence' => $data['item_sequence'],
                'item_id' =>  $data['item_id'],
                'qty' =>  $data['qty'],
                'price_unit' =>  $data['price_unit'],
                'discount' =>  $data['discount'],
                'tax' =>  $data['tax'],
                'final_delivery' =>  $data['final_delivery']
            ]);
        }
        
        $this->success_message = 'SO number '.$show_id.' created';

        DB::commit();

        $this->clearAllInput();
    }

    public function clearAllInput(){
        $this->so_item=[];
        $this->delivery_date='';
        $this->customer_id='';
        $this->customer_desc='';
        $this->payment_terms ='';
        $this->soitem_qty=[];
        $this->soitem_price=[];
        $this->soitem_disc=[];
        $this->soitem_tax=[];
        $this->grandtotal=0;
    }

   
}
