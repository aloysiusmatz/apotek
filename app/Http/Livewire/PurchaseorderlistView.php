<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\m_vendors;
use App\Models\m_locations;
use App\Traits\InventoryMovement;
use Illuminate\Support\Facades\DB;

class PurchaseorderlistView extends Component
{
    public $error_list=[];
    public $success_message='';
    public $results=[];
    public $sort_column=[];

    public $po_number='';
    public $item_id='';
    public $deliverydate_to='';
    public $deliverydate_from='';
    public $selection_dlv=0;

    public $modal1=false;
    public $modal1_title='';
    public $modal1_datas=[];
    public $modal1_po='';
    public $modal1_date='';
    public $modal1_message_date='';
    public $poitem_qty;
    public $poitem_dlv;

    public $modal2=false;
    public $modal2_title='';
    public $modal2_datas=[];
    public $modal2_po='';
    public $modal2_delivery_date='';
    public $modal2_vendor='';
    public $modal2_payment_terms='';
    public $modal2_additem_query='';
    public $modal2_search_item_result=[];
    public $modal2_poitem_qty;
    public $modal2_poitem_price;
    public $modal2_poitem_disc;
    public $modal2_poitem_tax;
    public $modal2_message='';
    
    use InventoryMovement;

    public function mount(){
        $this->initSort();
    }

    public function render()
    {
        if ($this->modal1_date!='') {
            $this->modal1_message_date = '';
        }
        
        if($this->modal2_additem_query!=''){
            $this->searchAddItemQuery($this->modal2_additem_query);
        }else{
            $this->modal2_search_item_result=[];
        }

        return view('livewire.purchaseorderlist-view');
    }

    public function initModal1(){
        $this->modal1_title='';
        $this->modal1_datas=[];
        $this->modal1_po='';
        $this->modal1_date='';
        $this->modal1_message_date='';
        $this->poitem_qty=[];
        $this->poitem_dlv=[];
    }

    public function initModal2(){
        
        $this->modal2_title='';
        $this->modal2_datas=[];
        $this->modal2_po='';
        $this->modal2_delivery_date='';
        $this->modal2_vendor='';
        $this->modal2_payment_terms='';
        $this->modal2_additem_query='';
        $this->modal2_search_item_result=[];
        $this->modal2_poitem_qty=[];
        $this->modal2_poitem_price=[];
        $this->modal2_poitem_disc=[];
        $this->modal2_poitem_tax=[];
        $this->modal2_message='';
    }

    public function initSort(){
        if (count($this->sort_column)==0) {
            $this->sort_column[0]['order']='asc';
            $this->sort_column[0]['column']='po_number';

            $this->sort_column[1]['order']='asc';
            $this->sort_column[1]['column']='item_sequence';

            $this->sort_column[2]['order']='asc';
            $this->sort_column[2]['column']='delivery_date';

            $this->sort_column[3]['order']='asc';
            $this->sort_column[3]['column']='item_id';

            $this->sort_column[4]['order']='asc';
            $this->sort_column[4]['column']='item_name';

            $this->sort_column[5]['order']='asc';
            $this->sort_column[5]['column']='qty';

            $this->sort_column[6]['order']='asc';
            $this->sort_column[6]['column']='vendor_id';

            $this->sort_column[7]['order']='asc';
            $this->sort_column[7]['column']='vendor_name';

            $this->sort_column[8]['order']='asc';
            $this->sort_column[8]['column']='dlv';
        }

    }

    public function searchPO(){
        
        $query = "
        select tpd.id as 'po_number', tpd.item_sequence , tpd.item_id , tpd.qty , tpd.final_delivery as 'dlv', 
        tph.po_show_id, tph.delivery_date, tph.vendor_id, mi.name as 'item_name', mi.show_id as 'item_show_id' ,mv.name as 'vendor_name'
        from t_po_d tpd, t_po_h tph, m_items mi, m_vendors mv 
        WHERE 
        tpd.id = tph.id and
        tpd.item_id = mi.id and
        tph.vendor_id = mv.id and 
        tph.company_id = '".session()->get('company_id')."' and
        tph.deleted = 0
        ";

        if ($this->po_number!='') {
            $query = $query." and tph.po_show_id like '%".$this->po_number."%' ";
        }
        if ($this->item_id!='') {
            $this->item_id = strtoupper($this->item_id);
            $query = $query." and (mi.show_id like '%".$this->item_id."%' or mi.name like '%".$this->item_id."%') ";
        }
        if ($this->deliverydate_from!='') {
            $query = $query." and (date(tph.delivery_date)";

            if ($this->deliverydate_to!='') {
                $query = $query." between '".$this->deliverydate_from."' and '".$this->deliverydate_to."' )";
            }else {
                $query = $query." = '".$this->deliverydate_from."' )";
            }
        }elseif ($this->deliverydate_to!='') {
            $query = $query." and ( date(tph.delivery_date) = '".$this->deliverydate_to."' )";
        }
        if ($this->selection_dlv!=2) {
            $query = $query." and tpd.final_delivery='".$this->selection_dlv."' ";
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

    public function clearFilter(){
        $this->po_number='';
        $this->item_id='';
        $this->deliverydate_to='';
        $this->deliverydate_from='';
        $this->selection_dlv=0;
    }

    public function showModal1($po_number, $po_show_id){
        $this->initModal1();
        if($po_number==-1){
            return false;
        }
        $this->modal1=true;
        $this->modal1_title = 'PO-'.$po_show_id;
        $this->modal1_po = $po_number;

        $query = "
        select a.*, c.show_id as 'item_show_id' , c.name as 'item_name', IFNULL(sum(d.qty),0) as 'receipt_qty'
        from t_po_d a
        LEFT JOIN t_itmove_d d on a.id = d.po_id and a.item_sequence = d.po_item_sequence 
        LEFT JOIN t_po_h b on a.id = b.id
        LEFT JOIN m_items c on a.item_id = c.id
        where a.final_delivery = 0 and
        b.company_id ='".session()->get('company_id')."' and 
        a.id = '".$po_number."'
        group by a.id, a.item_sequence
        ";
        $datas = DB::select($query);
        
        $modal1_datas = [];
        $index=0;
        foreach ($datas as $data) {
            $modal1_datas[$index] = (array) $data;
            $this->poitem_qty[$data->item_sequence] = $data->qty-$data->receipt_qty;
            $this->poitem_dlv[$data->item_sequence] = 1;
            $index++;
        }
        
        $this->modal1_datas = $modal1_datas;

        // dd($this->modal1_datas);
    }

    public function receiptPO($po_number){
        if ($this->modal1_date=='') {
            $this->modal1_message_date = 'Please fill posting date';
            return false;
        }
        
        $location = m_locations::where('name', 'PURCHASE')->get();
        
        $items_cart = [];
        $index=0;
        foreach ($this->modal1_datas as $data) {
            $items_cart[$index]['id'] = $data['item_id'];
            $items_cart_details[$index]['item_sequence'] = $data['item_sequence'];
            $items_cart_details[$index]['qty'] = $this->poitem_qty[$data['item_sequence']];
            $items_cart_details[$index]['to_location'] = $location->first()->id;
            $items_cart_details[$index]['to_batch'] = '0';
            $items_cart_details[$index]['amount'] = $this->poitem_qty[$data['item_sequence']]*$data['price_unit'];
            $items_cart_details[$index]['final_delivery'] = $this->poitem_dlv[$data['item_sequence']];
            $index++;
        }
        
        $this->postPOGoodsReceipt($po_number, $this->modal1_date, auth()->user()->id, session()->get('company_id'), $items_cart, $items_cart_details);

        $this->modal1 = false;
        $this->searchPO();
        // dd($items_cart, $items_cart_details);
    }

    public function deleteGRItem($index){
        array_splice($this->modal1_datas, $index, 1);
    }

    public function editPO($po_number){
        $this->initModal2();

        if($po_number==-1){
            return false;
        }
        //cek deleted (in case PO deleted in another session)
        $t_po_h = DB::table('t_po_h')
                    ->where('id', $po_number)
                    ->where('company_id', session()->get('company_id'))
                    ->sharedLock()
                    ->get();
        if($t_po_h->count()>0){
            if ($t_po_h->first()->deleted==1) {
                session()->flash('message', 'PO aleready deleted');
                return false;
            }
        }else{
            session()->flash('message', 'PO not found');
            return false;
        }
        
    
        $query = "
        select a.*, b.show_id as 'item_show_id', b.name as 'item_name'
        from t_po_d a
        left join m_items b on a.item_id = b.id
        where a.id = '".$po_number."'
        order by a.item_sequence asc
        for share
        ";

        $t_po_d = DB::select($query);
        
        $index=0;
        foreach ($t_po_d as $data) {
            $modal2_datas[$index] = (array) $data;
            $modal2_datas[$index]['deleted'] = 0;
            $this->modal2_poitem_qty[$data->item_sequence] = $data->qty;
            $this->modal2_poitem_price[$data->item_sequence] = $data->price_unit;
            $this->modal2_poitem_disc[$data->item_sequence] = $data->discount;
            $this->modal2_poitem_tax[$data->item_sequence] = $data->tax;
            $index++;
        }
        
        $m_vendors = m_vendors::find($t_po_h->first()->vendor_id);
        
        $this->modal2 = true;
        $this->modal2_title = $t_po_h->first()->po_show_id;
        $this->modal2_po = $po_number;
        $this->modal2_delivery_date = $t_po_h->first()->delivery_date;
        $this->modal2_vendor = $m_vendors->show_id.'-'.$m_vendors->name;
        $this->modal2_payment_terms = $t_po_h->first()->payment_terms;
        $this->modal2_datas = $modal2_datas;
        
    }

    public function deleteItemEditPO($index){
        $po_id = $this->modal2_datas[$index]['id'];
        $item_sequence = $this->modal2_datas[$index]['item_sequence'];

        //cek apakah yang didelete ada di database atau yang baru ditambahkan
        $query = "
        select a.id, a.item_sequence
        from t_po_d a
        inner join t_po_h b on a.id = b.id
        where a.id = '".$po_id."' and
        a.item_sequence = '".$item_sequence."' and
        b.company_id = '".session()->get('company_id')."'
        for share
        ";

        $t_po = DB::select($query);

        if (count($t_po)>0) { //jika ada di database maka tandai delete
            if($this->modal2_datas[$index]['final_delivery']==0){
                $this->modal2_datas[$index]['deleted'] = 1;    
            }
        }else{ //jika belum ada di database maka hapus arraynya saja
            array_splice($this->modal2_datas, $index,1);
        }
        
    }

    public function addItemEditPO($item_id){

        $m_items = DB::table('m_items')
                    ->where('id', $item_id)
                    ->where('company_id', session()->get('company_id'))
                    ->get();
        if(count($m_items)==0){
            return false;
        }else {
            $m_items = $m_items->first();
        }

        $index = count($this->modal2_datas);
        $new_item_sequence = $this->modal2_datas[$index-1]['item_sequence']+1;
        $this->modal2_datas[$index]['id'] = $this->modal2_po;
        $this->modal2_datas[$index]['item_sequence'] = $new_item_sequence;
        $this->modal2_datas[$index]['item_id'] = $item_id;
        $this->modal2_datas[$index]['qty'] = 0;
        $this->modal2_datas[$index]['price_unit'] = 0;
        $this->modal2_datas[$index]['discount'] = 0;
        $this->modal2_datas[$index]['tax'] = 10;
        $this->modal2_datas[$index]['final_delivery'] = 0; 
        $this->modal2_datas[$index]['created_at'] = '';
        $this->modal2_datas[$index]['updated_at'] = '';
        $this->modal2_datas[$index]['item_show_id'] = $m_items->show_id;
        $this->modal2_datas[$index]['item_name'] = $m_items->name;
        $this->modal2_datas[$index]['deleted'] = 0;

        $this->modal2_poitem_qty[$new_item_sequence] = 0;
        $this->modal2_poitem_price[$new_item_sequence] = 0;
        $this->modal2_poitem_disc[$new_item_sequence] = 0;
        $this->modal2_poitem_tax[$new_item_sequence] = 10;

        $this->searchAddItemReset();
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

        $this->modal2_search_item_result = $result;

    }

    public function searchAddItemReset(){
        $this->modal2_additem_query='';
        $this->modal2_search_item_result = [];
    }

    public function saveEditPO(){
        //cek input
        $error = false;
        foreach ($this->modal2_datas as $data) {
            // if ($data['price_unit']==0) {
            //     $error = true;
            //     $this->modal2_message = 'Error: Price unit for PO item '.$data['item_sequence'].' cannot be 0';
            // }
            if ($this->modal2_poitem_qty[$data['item_sequence']]==0) {
                $error = true;
                $this->modal2_message = 'Error: Qty for PO item '.$data['item_sequence'].' cannot be 0';
            }
            
        }

        if ($error==false) {
            $this->modal2_message='';
        }else{
            return false;
        }


        //update or insert data
        $grand_total = 0;
        DB::beginTransaction();
        foreach ($this->modal2_datas as $data) {
            if ($data['final_delivery']==0) {
                DB::table('t_po_d')
                ->updateOrInsert(
                    ['id' => $this->modal2_po, 'item_sequence' => $data['item_sequence']],
                    [
                        'item_id' => $data['item_id'],
                        'qty' => $this->modal2_poitem_qty[$data['item_sequence']],
                        'price_unit' => $this->modal2_poitem_price[$data['item_sequence']],
                        'discount' => $this->modal2_poitem_disc[$data['item_sequence']],
                        'tax' => $this->modal2_poitem_tax[$data['item_sequence']],
                        'final_delivery' => $data['final_delivery'],
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );
            }
          
            $grand_total += 
            ($this->modal2_poitem_qty[$data['item_sequence']]*$this->modal2_poitem_price[$data['item_sequence']])*
            ((100-$this->modal2_poitem_disc[$data['item_sequence']])/100)*
            ((100+$this->modal2_poitem_tax[$data['item_sequence']])/100);
            
        }
       
        DB::table('t_po_h')
            ->where('id', $this->modal2_po)
            ->update([
                'delivery_date' => $this->modal2_delivery_date,
                'payment_terms' => $this->modal2_payment_terms,
                'grand_total' => $grand_total,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        DB::commit();

        $this->modal2=false;
        
        $this->searchPO();
    }

    public function deletePO($po_number, $po_show_id){
        //cek apakah PO sudah final delivery
        if ($po_number < 0) {
            return false;
        }
        //cek apakah PO sudah ada transaksi
        $transactions = $this->getPOTransactions($po_number, session()->get('company_id'));
        if(count($transactions)>0){
            session()->flash('message', 'PO aleready has some transactions');
            return false;
        }

        DB::beginTransaction();

        $delete = DB::table('t_po_h')
                    ->where('id', $po_number)
                    ->update(['deleted' => '1']);

        DB::commit();

        $this->searchPO();
        session()->flash('success', 'PO '.$po_show_id.' deleted');
    }

    
    public function closeSuccessNotif(){
        session()->forget('success');    
    }

    public function closeErrorNotif(){
        session()->forget('message');    
    }

    public function sortBy($column){    
        if ($this->sort_column[$column]['order']=='asc') {
            $column_to_sort = array_column($this->results,$this->sort_column[$column]['column']);
            array_multisort($column_to_sort,SORT_ASC,$this->results);
            $this->sort_column[$column]['order']='desc';

        }else{
            $column_to_sort = array_column($this->results,$this->sort_column[$column]['column']);
            array_multisort($column_to_sort,SORT_DESC,$this->results);
            $this->sort_column[$column]['order']='asc';
        }
    }
}
