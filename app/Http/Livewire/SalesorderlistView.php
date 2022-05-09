<?php

namespace App\Http\Livewire;

use Exception;
use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Traits\GeneralFunctions;
use App\Traits\InventoryMovement;
use Illuminate\Support\Facades\DB;

class SalesorderlistView extends Component
{

    public $error_list=[];
    public $success_message='';
    public $results=[];
    public $sort_column=[];

    public $so_number='';
    public $item_id='';
    public $deliverydate_from='';
    public $deliverydate_to='';
    public $selection_dlv=0;

    public $modal1=false;
    public $modal1_title='';
    public $modal1_datas=[];
    public $modal1_so='';
    public $modal1_date='';
    // public $modal1_message_date='';
    public $soitem_qty;
    public $soitem_locbatch;
    public $soitem_dlv;
    public $latest_stock=[];
    public $modal1_shipto_address = '';
    public $modal1_shipto_city = '';
    public $modal1_shipto_country = '';
    public $modal1_shipto_postalcode = '';
    public $modal1_shipto_phone1 = '';
    public $modal1_shipto_phone2 = '';
    public $modal1_shipto_note = '';
    public $modal1_error_message = '';
    public $datas_do=[];

    public $modal2=false;

    public $modal3=false;
    public $modal3_title='';
    public $modal3_date;
    public $so_grandtotal=0;
    public $datas_so=[];

    public $modal4=false;
    public $modal4_title='';
    public $modal4_grandtotal=0;
    public $modal4_date;
    public $modal4_qty=[];
    public $modal4_price=[];
    public $modal4_disc=[];
    public $modal4_tax=[];
    public $modal4_error_message='';
    public $modal4_additem_query='';
    public $modal4_search_item_result=[];
    

    use InventoryMovement;
    use GeneralFunctions;
    
    public function render()
    {
        $this->modal4CheckItemInputField();
        $this->checkAddItemQuery();

        return view('livewire.salesorderlist-view');
    }

    public function clearFilter(){
        $this->so_number='';
        $this->item_id='';
        $this->deliverydate_from='';
        $this->deliverydate_to='';
        $this->selection_dlv=0;
    
    }

    public function searchSO(){
        
        $query = "
        select tsd.id as 'so_number', tsd.item_sequence , tsd.item_id , tsd.qty , tsd.final_delivery as 'dlv', 
        tsh.so_show_id, tsh.delivery_date, tsh.customer_id, mi.name as 'item_name', mi.show_id as 'item_show_id' , mc.show_id as 'customer_show_id', mc.name as 'customer_name'
        from t_so_d tsd, t_so_h tsh, m_items mi, m_customers mc 
        WHERE 
        tsd.id = tsh.id and
        tsd.item_id = mi.id and
        tsh.customer_id = mc.id and 
        tsh.company_id = '".session()->get('company_id')."' and
        tsh.deleted = 0
        ";

        if ($this->so_number!='') {
            $query = $query." and tsh.so_show_id like '%".$this->so_number."%' ";
        }
        if ($this->item_id!='') {
            $this->item_id = strtoupper($this->item_id);
            $query = $query." and (mi.show_id like '%".$this->item_id."%' or mi.name like '%".$this->item_id."%') ";
        }
        if ($this->deliverydate_from!='') {
            $query = $query." and (date(tsh.delivery_date)";

            if ($this->deliverydate_to!='') {
                $query = $query." between '".$this->deliverydate_from."' and '".$this->deliverydate_to."' )";
            }else {
                $query = $query." = '".$this->deliverydate_from."' )";
            }
        }elseif ($this->deliverydate_to!='') {
            $query = $query." and ( date(tsh.delivery_date) = '".$this->deliverydate_to."' )";
        }
        if ($this->selection_dlv!=2) {
            $query = $query." and tsd.final_delivery='".$this->selection_dlv."' ";
        }
        // dd($query);
        $datas = DB::select($query);
        $results=[];
        $index=0;
        foreach ($datas as $data) {
            $results[$index] = (array) $data;
            $index++;
        }

        $this->results = $results;
        // dd($results);
        
    }
    
    public function initModal1(){
        $this->modal1_title='';
        $this->modal1_datas=[];
        $this->modal1_so='';
        $this->modal1_date='';
        // $this->modal1_message_date='';
        $this->soitem_qty=[];
        $this->soitem_locbatch=[];
        $this->soitem_dlv=[];
        $this->latest_stock=[];
        $this->modal1_shipto_address = '';
        $this->modal1_shipto_city = '';
        $this->modal1_shipto_country = '';
        $this->modal1_shipto_postalcode = '';
        $this->modal1_shipto_phone1 = '';
        $this->modal1_shipto_phone2 = '';
        $this->modal1_shipto_note = '';
        $this->modal1_error_message = '';
        $this->datas_do=[];
    }

    public function initModal2(){

    }

    public function getSO($so_number){
        $this->datas_so = [];
        $this->so_grandtotal = 0;

        $query = "
        select a.*, b.so_show_id, b.delivery_date, c.show_id as 'item_show_id' , c.name as 'item_name', c.unit as 'item_unit'
        from t_so_d a
        LEFT JOIN t_so_h b on a.id = b.id
        LEFT JOIN m_items c on a.item_id = c.id
        where
        b.company_id ='".session()->get('company_id')."' and 
        a.id = '".$so_number."' and
        b.deleted = 0
        group by a.id, a.item_sequence
        for share
        ";
        $datas_so = DB::select($query);

        $index = 0;
        foreach ($datas_so as $data) {
            $this->datas_so[$index] = (array) $data;
            $this->datas_so[$index]['subtotal'] = $data->price_unit*$data->qty*((100-$data->discount)/100)*((100+$data->tax)/100);
            $this->datas_so[$index]['deleted'] = 0;
            $this->datas_so[$index]['new_line'] = 0;
            $this->so_grandtotal += $this->datas_so[$index]['subtotal'];
            $index++;
        }

    }

    public function getDO($so_number){
        $this->datas_do = [];

        $query = "
        select b.*, a.item_sequence, a.locbatch_split, a.item_id, c.show_id, c.name as 'item_name', c.unit as 'item_unit', 
        a.location_id, d.name 'location_name', a.batch, a.qty 
        from t_do_d a
        left join t_do_h b on a.id = b.id
        left join m_items c on a.item_id = c.id
        left join m_locations d on a.location_id = d.id
        where b.company_id = '".session()->get('company_id')."' and
        b.so_id = '".$so_number."' 
        ";
        $datas_do = DB::select($query);
        
        $index=0;
        foreach ($datas_do as $data_do) {
            $this->datas_do[$index] = (array)$data_do;
            $index++;
        }
        
    }
    
    public function showModal1($so_number, $so_show_id){
        $this->initModal1();
        if($so_number==-1){
            return false;
        }
        $this->modal1=true;
        $this->modal1_title = 'SO-'.$so_show_id;
        $this->modal1_so = $so_number;

        $query = "
        select a.*, c.show_id as 'item_show_id' , c.name as 'item_name', c.unit as 'item_unit', IFNULL(sum(d.qty),0) as 'issue_qty'
        from t_so_d a
        LEFT JOIN t_itmove_d d on a.id = d.so_id and a.item_sequence = d.so_item_sequence 
        LEFT JOIN t_so_h b on a.id = b.id
        LEFT JOIN m_items c on a.item_id = c.id
        where a.final_delivery = 0 and
        b.company_id ='".session()->get('company_id')."' and 
        a.id = '".$so_number."'
        group by a.id, a.item_sequence
        ";
        $datas = DB::select($query);

        $modal1_datas = [];
        $index=0;
        $latest_stock=[];
        foreach ($datas as $data) {
            $modal1_datas[$index] = (array) $data;
            $this->soitem_qty[$index][0] = $data->qty-$data->issue_qty;
            $this->soitem_dlv[$index] = 1;

            $latest_stock[$index] = $this->getEndingInvAllLocBatch($data->item_id , session()->get('company_id'));
            // dd($latest_stock[$index][0]['location_id']);
            $location_id = $latest_stock[$index][0]['location_id'];
            $batch = $latest_stock[$index][0]['batch'];

            $this->soitem_locbatch[$index][0] = $location_id.'-'.$batch;
            $index++;
        }
        
        $this->modal1_datas = $modal1_datas;
        $this->latest_stock = $latest_stock;

        $this->getDO($so_number);
        // dd($this->soitem_locbatch);
    }

    public function addLocBatch($index){
        $count_subitem = count($this->soitem_qty[$index]);
        if ($count_subitem==0) {
            return false; //error karena tidak mungkin tidak punya qty
        }
        // dd($count_subitem);
        $this->soitem_qty[$index][$count_subitem] = 0;

        $location_id = $this->latest_stock[$index][0]['location_id'];
        $batch = $this->latest_stock[$index][0]['batch'];

        // $this->soitem_locbatch[$item_sequence][$count_subitem]['location_id'] = $location_id;
        // $this->soitem_locbatch[$item_sequence][$count_subitem]['batch'] = $batch;
        $this->soitem_locbatch[$index][$count_subitem] = $location_id.'-'.$batch;

        // dd($this->soitem_qty);
    }

    public function deleteLocBatch($index){
        $count_subitem = count($this->soitem_qty[$index]);
        if ($count_subitem<=1) {
            return false; //tidak bisa delete kalau item tinggal 1
        }

        array_splice($this->soitem_qty[$index], $count_subitem-1, 1);
        array_splice($this->soitem_locbatch[$index], $count_subitem-1, 1);
    }

    public function deleteSOItemModal1($index){
        $item_sequence = $this->modal1_datas[$index]['item_sequence'];
        
        // dd($this->soitem_locbatch);
        array_splice($this->modal1_datas, $index, 1);
        // dd($this->modal1_datas);
        array_splice($this->soitem_qty, $index, 1);
        // dd($this->soitem_qty);
        array_splice($this->soitem_locbatch, $index, 1);
        // dd($this->soitem_locbatch);
        array_splice($this->latest_stock, $index, 1);
        
    }

    public function saveGoodIssue($so_id){
        //cek input
        $this->modal1_error_message = '';
        if ($this->modal1_date == '') {
            $this->modal1_error_message = 'Please fill delivery date';
        }
        
        if ($this->modal1_error_message != '') {
            return false;
        }
        
        $so_item=[];
        $so_item_details=[];
        for ($i=0; $i < count($this->soitem_qty) ; $i++) { 
            $so_item[$i]['item_sequence'] = $this->modal1_datas[$i]['item_sequence'];
            $so_item[$i]['item_id'] = $this->modal1_datas[$i]['item_id'];
            $so_item[$i]['final_delivery'] = $this->soitem_dlv[$i];

            for ($j=0; $j < count($this->soitem_qty[$i]) ; $j++) { 
                $temp_locbatch = explode('-', $this->soitem_locbatch[$i][$j]);
                $so_item_details[$i][$j]['location_id'] = $temp_locbatch[0];
                $so_item_details[$i][$j]['batch'] = $temp_locbatch[1];
                $so_item_details[$i][$j]['qty'] = intval($this->soitem_qty[$i][$j]);
            } 
        }
        // dd($so_item, $so_item_details);
        
        $do_header['delivery_date'] = $this->modal1_date;
        $do_header['address'] = $this->modal1_shipto_address;
        $do_header['city'] = $this->modal1_shipto_city;
        $do_header['country'] = $this->modal1_shipto_country;
        $do_header['postalcode'] = $this->modal1_shipto_postalcode;
        $do_header['phone1'] = $this->modal1_shipto_phone1;
        $do_header['phone2'] = $this->modal1_shipto_phone2;
        $do_header['note'] = $this->modal1_shipto_note;

        $this->postDOGoodIssue($so_id, $do_header, auth()->user()->id, session()->get('company_id'), $so_item, $so_item_details); //$p_so_number, $p_delivery_date, $p_user, $p_company_id, $p_items_cart, $p_items_cart_details

        $this->modal1=false;
        $this->initModal1();

    }

    public function modal2Back(){
        $this->modal1 = true;
        $this->modal2 = false;
        $this->initModal2();
    }

    public function showModal2($so_number){
        //get DO lagi supaya refresh yang terakhir
        $this->getDO($so_number);

        if (count($this->datas_do) == 0) { //jika data DO tidak ada maka tidak usah munculkan modal2
            return false;
        }
        $this->modal1 = false;
        $this->modal2 = true;
        $this->initModal2();

    }

    public function showSO($so_number){

        $this->getSO($so_number);
        
        if (count($this->datas_so)==0) {
            return false;
        }

        $this->modal3 = true;
        $this->modal3_title = 'Sales Order '.$this->datas_so[0]['so_show_id'];
        $this->modal3_date = $this->datas_so[0]['delivery_date'];
        
    }

    public function deleteSO($so_number){
        $this->getDO($so_number);
        if (count($this->datas_do)>0) {
            $this->addErrorMessage("Can't delete SO, because SO already have DO");
            return false;
        }

        try {
            DB::beginTransaction();
            DB::table('t_so_h')->delete($so_number);
            DB::commit();

            $this->addSuccessMessage('SO successfully deleted');
            $this->searchSO();
        } catch (\Exception $e) {
            throw $e;
        }
        
    }

    public function modal4CheckItemInputField(){
        if (!$this->modal4) {
            return false;
        }
        $modal4_grandtotal=0;
        $cnt = -1;
        foreach ($this->datas_so as $data) {
            $cnt += 1;
            if ($data['deleted']==1) {
                continue;
            }
            if ($this->modal4_qty[$cnt]=='') {
                $this->modal4_qty[$cnt] = 0;
            }
            if ($this->modal4_price[$cnt]=='') {
                $this->modal4_price[$cnt] = 0;
            }
            if ($this->modal4_disc[$cnt]=='') {
                $this->modal4_disc[$cnt] = 0;
            }
            if ($this->modal4_tax[$cnt]=='') {
                $this->modal4_tax[$cnt] = 0;
            }

            $this->datas_so[$cnt]['qty'] = $this->modal4_qty[$cnt];
            $this->datas_so[$cnt]['price_unit'] = $this->modal4_price[$cnt];
            $this->datas_so[$cnt]['discount'] = $this->modal4_disc[$cnt];
            $this->datas_so[$cnt]['tax'] = $this->modal4_tax[$cnt];
            $this->datas_so[$cnt]['subtotal'] = 
            ($this->modal4_qty[$cnt]*$this->modal4_price[$cnt])*
            ((100-$this->modal4_disc[$cnt])/100)*
            ((100+$this->modal4_tax[$cnt])/100);
            
            $modal4_grandtotal += $this->datas_so[$cnt]['subtotal'];

        }

        $this->modal4_grandtotal = $modal4_grandtotal;
    }

    public function editSO($so_number){
        $this->modal4_qty=[];
        $this->modal4_price=[];
        $this->modal4_disc=[];
        $this->modal4_tax=[];
        
        $this->getSO($so_number);
        if (count($this->datas_so)==0) {
            return false;
        }

        $this->getDO($so_number);
        if (count($this->datas_do)>0) {
            $this->addErrorMessage("Can't edit SO, because SO already have DO");
            return false;
        }

        //show modal edit SO
        $this->modal4=true;
        $this->modal4_title = 'Edit Sales Order '. $this->datas_so[0]['so_show_id'];
        $this->modal4_date = $this->datas_so[0]['delivery_date'];
        $index=0;
        foreach ($this->datas_so as $data) {
            $this->modal4_qty[$index] = $data['qty'];
            $this->modal4_price[$index] = $data['price_unit'];
            $this->modal4_disc[$index] = $data['discount'];
            $this->modal4_tax[$index] = $data['tax'];
            $index++;
        }

    }

    public function deleteItemEditSO($index){
        $this->datas_so[$index]['deleted'] = 1;

    }

    public function saveEditSO(){
        $this->modal4_error_message='';

        //cek input
        $index=-1;
        foreach ($this->datas_so as $data) {
            $index++;
            if ($data['deleted']==1) {
                continue;
            }
            if ($this->modal4_qty[$index]<=0) {
                $this->modal4_error_message = "Item Sequence ".$data['item_sequence']." - Qty can't be 0";
            }
            if ($this->modal4_price[$index]<=0) {
                $this->modal4_error_message = "Item Sequence ".$data['item_sequence']." - Price can't be 0";
            }
        }
        if ($this->modal4_date=='') {
            $this->modal4_error_message = "Delivery date can't be empty";
        }
        if ($this->modal4_error_message!='') {
            return false;
        }

        try {
            DB::beginTransaction();
            $index=-1;
            // dd($this->datas_so);
            foreach ($this->datas_so as $data) {
                $index++;
                if ($data['deleted']==1 && $data['new_line']==0) {
                    DB::table('t_so_d')
                    ->where('id', $data['id'])
                    ->where('item_sequence', $data['item_sequence'])
                    ->delete();
                }elseif ($data['deleted']==0 && $data['new_line']==0) {
                    DB::table('t_so_d')
                    ->where('id', $data['id'])
                    ->where('item_sequence', $data['item_sequence'])
                    ->update([
                        'qty' => $this->modal4_qty[$index],
                        'price_unit'  => $this->modal4_price[$index],
                        'discount' => $this->modal4_disc[$index],
                        'tax' => $this->modal4_tax[$index],
                        'updated_at' => Carbon::now()
                        ]);
                }elseif ($data['new_line']==1) {
                    
                    if ($data['qty']<=0 || $data['price_unit']<=0) {
                        throw new Exception("Qty or Price can't be 0", 1); //harusnya sudah dicek diatas, tapi dicek lagi
                    }
                    
                    DB::table('t_so_d')->insert([
                        [   
                            'id' => $this->datas_so[0]['id'],
                            'item_sequence' => $data['item_sequence'],
                            'item_id' =>  $data['item_id'],
                            'qty' =>  $data['qty'],
                            'price_unit' =>  $data['price_unit'],
                            'discount' =>  $data['discount'],
                            'tax' =>  $data['tax'],
                            'final_delivery' =>  $data['final_delivery'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]
                    ]);
                }
            }
            DB::table('t_so_h')
            ->where('id', $this->datas_so[0]['id'])
            ->update([
                'grand_total' => $this->modal4_grandtotal,
                'updated_at' => Carbon::now()
            ]);

            DB::commit();

            $this->modal4=false;

        } catch (\Exception $e) {
            throw $e;
        }
        
    }

    public function addItemEditSO($item_id){

        $m_items = DB::table('m_items')
                    ->where('id', $item_id)
                    ->where('company_id', session()->get('company_id'))
                    ->get();

        if(count($m_items)==0){
            return false;
        }else {
            $m_items = $m_items->first();
        }

        $index = count($this->datas_so);
        $item_sequence = $this->datas_so[$index-1]['item_sequence']+1; //get the last number of item sequence and +1

        $this->datas_so[$index]['id'] = '';
        $this->datas_so[$index]['item_sequence'] = $item_sequence;
        $this->datas_so[$index]['item_id'] = $item_id;
        $this->datas_so[$index]['qty'] = 0;
        $this->datas_so[$index]['item_unit'] = $m_items->unit;
        $this->datas_so[$index]['price_unit'] = $m_items->selling_price;
        $this->datas_so[$index]['discount'] = 0;
        $this->datas_so[$index]['tax'] = session()->get('default_tax');
        $this->datas_so[$index]['final_delivery'] = 0; 
        $this->datas_so[$index]['created_at'] = '';
        $this->datas_so[$index]['updated_at'] = '';
        $this->datas_so[$index]['item_show_id'] = $m_items->show_id;
        $this->datas_so[$index]['item_name'] = $m_items->name;
        $this->datas_so[$index]['subtotal'] = 0;
        $this->datas_so[$index]['deleted'] = 0;
        $this->datas_so[$index]['new_line'] = 1;

        $this->modal4_qty[$index] = $this->datas_so[$index]['qty'];
        $this->modal4_price[$index] = $this->datas_so[$index]['price_unit'];
        $this->modal4_disc[$index] = $this->datas_so[$index]['discount'];
        $this->modal4_tax[$index] = $this->datas_so[$index]['tax'];

        $this->searchAddItemReset();
    }

    public function checkAddItemQuery(){
        if($this->modal4_additem_query!=''){
            $this->searchAddItemQuery($this->modal4_additem_query);
        }else{
            $this->modal4_search_item_result=[];
        }
    } 

    public function searchAddItemReset(){
        $this->modal4_additem_query = '';
        $this->modal4_search_item_result=[];
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
        
        $this->modal4_search_item_result = $result;

    }

    public function closeErrorNotif(){
        session()->forget('message');  
    }

    public function closeSuccessNotif(){
        session()->forget('success');  
    }

    public function addErrorMessage($message){
        session()->flash('message', $message);
    }
    
    public function addSuccessMessage($message){
        session()->flash('success', $message);
    }
}
