<?php

namespace App\Traits;

use Exception;
use App\Models\t_do_d;
use App\Models\t_do_h;
use App\Models\t_so_h;
use App\Models\m_items;
use App\Models\t_invstock;
use App\Models\t_itmove_d;
use App\Models\t_itmove_h;
use App\Models\m_locations;
use App\Models\t_pricehist;
use App\Models\movement_keys;
use Illuminate\Support\Facades\DB;

/**
 * 
 */
trait InventoryMovement
{
    
    public function getEndingInv($item_id, $company_id, $location_id, $batch){
        
        $ending_inv = DB::table('t_invstock')
                        ->where('item_id',$item_id)
                        ->where('company_id', $company_id)
                        ->where('location_id',$location_id)
                        ->where('batch',$batch)
                        ->where('category', 'ending')
                        ->orderBy('year','desc')
                        ->orderBy('period','desc')
                        ->limit(1)
                        ->lockForUpdate()
                        ->get();
        
        if(count($ending_inv)==0){
            $ending['qty'] = 0;
            $ending['year'] = '';
            $ending['period'] = '';
        }else{
            $ending['qty'] = $ending_inv->first()->qty;
            $ending['year'] = $ending_inv->first()->year;
            $ending['period'] = $ending_inv->first()->period;
        }

        return $ending;
    }

    public function getEndingInvAllLocBatch($item_id, $company_id){
        $query = 
        "select a.*, b.period, b.year, b.qty, c.name as 'location_name' FROM (
            select ti.item_id, ti.company_id  , MAX(CONCAT(ti.`year`,LPAD(ti.period,2,0)) ) as 'max' , ti.location_id ,ti.batch
                from t_invstock ti 
                WHERE 
                ti.item_id = '".$item_id."' and 
                ti.company_id = '".$company_id."' AND
                ti.category = 'ending'
                GROUP BY ti.item_id , ti.company_id , ti.location_id , ti.batch) a
        inner join t_invstock b on 
        a.item_id = b.item_id and 
        a.company_id = b.company_id and 
        SUBSTRING(a.max, 5, 2) = b.period and 
        SUBSTRING(a.max, 1, 4) = b.`year` AND 
        a.location_id = b.location_id AND 
        a.batch = b.batch
        left join m_locations c on
        a.location_id = c.id
        where b.category = 'ending'";


        $endings = DB::select($query);
        
        $index=0;
        foreach ($endings as $ending) {
            $endings[$index] = (array) $ending;            
            $index++;
        }

        return $endings;
        // dd($ending);
    }

    public function getAllEndingInvAllLocBatch($company_id){
        $query = 
        "select a.*, b.period, b.year, b.qty, c.name as 'location_name', d.show_id as 'item_show_id', d.name as 'item_name', d.unit as 'item_unit' FROM (
            select ti.item_id, ti.company_id  , MAX(CONCAT(ti.`year`,LPAD(ti.period,2,0)) ) as 'max' , ti.location_id ,ti.batch
                from t_invstock ti 
                WHERE 
                ti.company_id = '".$company_id."' AND
                ti.category = 'ending'
                GROUP BY ti.item_id , ti.company_id , ti.location_id , ti.batch) a
        inner join t_invstock b on 
        a.item_id = b.item_id and 
        a.company_id = b.company_id and 
        SUBSTRING(a.max, 5, 2) = b.period and 
        SUBSTRING(a.max, 1, 4) = b.`year` AND 
        a.location_id = b.location_id AND 
        a.batch = b.batch AND
        b.qty > 0
        left join m_locations c on
        a.location_id = c.id
        inner join m_items d on
        a.item_id = d.id
        where b.category = 'ending'";


        $endings = DB::select($query);
        
        $index=0;
        foreach ($endings as $ending) {
            $endings[$index] = (array) $ending;            
            $index++;
        }

        return $endings;
        // dd($ending);
    }

    public function getMonthEndingInv($item_id, $company_id, $period , $year, $location_id, $batch){
        $ending_inv = DB::table('t_invstock')
                        ->where('item_id',$item_id)
                        ->where('company_id', $company_id)
                        ->where('period', $period)
                        ->where('year', $year)
                        ->where('location_id',$location_id)
                        ->where('batch',$batch)
                        ->where('category', 'ending')
                        ->lockForUpdate()
                        ->get();

        if(count($ending_inv)==0){
            $ending['qty'] = 0;
            $ending['year'] = '';
            $ending['period'] = '';
        }else{
            $ending['qty'] = $ending_inv->first()->qty;
            $ending['year'] = $ending_inv->first()->year;
            $ending['period'] = $ending_inv->first()->period;
        }

        return $ending;
    }

    public function latestPriceHistory($item_id, $company_id){
        $latest = DB::table('t_pricehist')
                    ->where('item_id', $item_id)
                    ->where('company_id', $company_id)
                    ->latest()->get();
        
        if(count($latest)>0){
            $result['found'] = true;
            $result['posting_date'] = $latest->first()->posting_date;
            $result['qty'] = $latest->first()->qty;
            $result['amount'] = $latest->first()->amount;
            $result['total_qty'] = $latest->first()->total_qty;
            $result['total_amount'] = $latest->first()->total_amount;
            $result['cogs'] = $latest->first()->cogs;
        }else{
            $result['found'] = false;
            $result['posting_date'] = '';
            $result['qty'] = 0;
            $result['amount'] = 0;
            $result['total_qty'] = 0;
            $result['total_amount'] = 0;
            $result['cogs'] = 0;
        }

        return $result;
    }

    public function getMonthlyMovement($item_id,$company_id,$period,$year,$location_id,$batch){
        $datas = DB::table('t_invstock')
                ->where('item_id',$item_id)
                ->where('company_id', $company_id)
                ->where('period', $period)
                ->where('year', $year)
                ->where('location_id',$location_id)
                ->where('batch',$batch)
                ->get();
        
        $results=[];
        $index=0;
        $order=1;
        foreach ($datas as $data) {
            $results[$index] = (array) $data;
            if ($data->category=="begin") {
                $results[$index]['order'] = 0; 
            }elseif ($data->category=="ending") {
                $results[$index]['order'] = 9999;
            }else{
                $results[$index]['order'] = $order;
                $order++;
            }
            
            $index++;
        }
        
        $column_to_sort = array_column($results,'order');
        array_multisort($column_to_sort,SORT_ASC,$results);
        
        return $results;
    }

    public function getMonthlyPriceHistory($item_id, $company_id, $period, $year){
        $posting_period = date_create($year.'-'.$period);
        $from_date = date_format($posting_period, 'Y-m-d');
        $to_date = date_format($posting_period, 'Y-m-t');

        $price_hist = DB::table('t_pricehist')
                    ->where('item_id', $item_id)
                    ->where('company_id', $company_id)
                    ->whereBetween('posting_date', [$from_date, $to_date])
                    ->orderBy('posting_date', 'asc')
                    ->get();

        
        $results=[];
        $index=0;
        foreach ($price_hist as $data) {
            $results[$index] = (array) $data;
            $index++;
        }
        // dd($results);
        return $results;
    }

    public function postPOGoodsReceipt($p_po_number, $p_posting_date, $p_user, $p_company_id, $p_items_cart, $p_items_cart_details){

        DB::beginTransaction();

        $movkey = DB::table('movement_keys')
                    ->where('type', 'PURC')
                    ->get();
        
        $movedesc = 'GR PO '.$p_po_number;
        
        $this->updatePOStatus($p_po_number, $p_items_cart_details);
        
        $itmoveh_id = $this->postItemMovement('PO', $p_po_number, $p_posting_date, $p_user, $p_company_id, $movkey->first()->id, $movedesc, $movkey->first()->behaviour, $p_items_cart, $p_items_cart_details);

        $this->postInventoryStock($p_posting_date, $p_company_id, $movkey->first()->id, $movkey->first()->behaviour, $p_items_cart, $p_items_cart_details);

        $this->postPriceHistory($itmoveh_id, $p_posting_date, $p_company_id, $movkey->first()->id, $movkey->first()->behaviour, $p_items_cart, $p_items_cart_details);

        DB::commit();
    }

    public function getPOTransactions($p_po_number,$p_company_id){
        $query = "
        select a.id, a.item_id, a.qty, a.amount, b.cancelled 
        from t_itmove_d a
        left join t_itmove_h b on a.id = b.id
        where a.po_id = '".$p_po_number."' and
        b.company_id = '".$p_company_id."' and
        a.qty > 0 and
        ( b.cancelled = 0 or b.cancelled is NULL )
        ";

        $datas = DB::select($query);
        
        $index = 0;
        foreach ($datas as $data) {
            $transactionsList[$index] = (array) $data;
            $index++;
        }

        return $transactionsList;
    }

    private function updatePOStatus($p_po_number, $p_items_cart_details){

        foreach ($p_items_cart_details as $data) {
            $update = DB::table('t_po_d')
                    ->where('id', $p_po_number)
                    ->where('item_sequence', $data['item_sequence'])
                    ->update(['final_delivery' => $data['final_delivery']]);
        }
        

    }

    public function postDOGoodIssue($p_so_number, $p_do_header, $p_user, $p_company_id, $p_so_item, $p_so_item_details){

        DB::beginTransaction();

        try{
            $movkey = DB::table('movement_keys')
            ->where('type', 'SELL')
            ->get();

            $so_show_id = t_so_h::find($p_so_number)->so_show_id;
            $movedesc = 'GI SO '.$so_show_id;

            $this->updateSOStatus($p_so_number, $p_so_item);

            for ($i=0; $i < count($p_so_item) ; $i++) { 
               for ($j=0; $j < count($p_so_item_details[$i]) ; $j++) { 

                    $items_cart=[];
                    $items_cart_details=[];
                    $items_cart[0]['id'] = $p_so_item[$i]['item_id'];
                    $items_cart_details[0]['item_sequence'] = $p_so_item[$i]['item_sequence'];
                    $items_cart_details[0]['qty'] = $p_so_item_details[$i][$j]['qty'];
                    $items_cart_details[0]['to_location'] = $p_so_item_details[$i][$j]['location_id'];
                    $items_cart_details[0]['to_batch'] = $p_so_item_details[$i][$j]['batch'];
                    $items_cart_details[0]['amount'] = '';
                    $items_cart_details[0]['final_delivery'] =$p_so_item[$i]['final_delivery'];

                    $noerror = $this->postInventoryStock($p_do_header['delivery_date'], $p_company_id, $movkey->first()->id, $movkey->first()->behaviour, $items_cart, $items_cart_details);
                    
                    if (!$noerror['status']) {
                        
                        throw new Exception($noerror['message'], 1);
                    }
                    
                    $itmoveh_id = $this->postItemMovement('SO', $p_so_number, $p_do_header['delivery_date'], $p_user, $p_company_id, $movkey->first()->id, $movedesc, $movkey->first()->behaviour, $items_cart, $items_cart_details);

                    $this->postPriceHistory($itmoveh_id, $p_do_header['delivery_date'], $p_company_id, $movkey->first()->id, $movkey->first()->behaviour, $items_cart, $items_cart_details);

               }
            }
            
            $this->postDOTable($p_so_number, $p_do_header, $p_company_id, $p_so_item, $p_so_item_details);

            // $this->postInventoryStock($p_delivery_date, $p_company_id, $movkey->first()->id, $movkey->first()->behaviour, $p_items_cart, $p_items_cart_details);

            // $itmoveh_id = $this->postItemMovement($p_po_number,$p_posting_date, $p_user, $p_company_id, $movkey->first()->id, $movedesc, $movkey->first()->behaviour, $p_items_cart, $p_items_cart_details);

            // $this->postPriceHistory($itmoveh_id, $p_posting_date, $p_company_id, $movkey->first()->id, $movkey->first()->behaviour, $p_items_cart, $p_items_cart_details);

            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        
        
    }

    private function postDOTable($p_so_number, $p_do_header, $p_company_id, $p_so_item, $p_so_item_details){

        //DO show ID
        // $select_show_id = "select ifnull(max(do_show_id),5000000)+1 as id from t_do_h where company_id='".session()->get('company_id')."' for share";
        $select_show_id = DB::table('t_do_h')
                                ->select(DB::raw('ifnull(max(do_show_id),5000000)+1 as id'))
                                ->where('company_id', session()->get('company_id'))
                                ->sharedLock()
                                ->get();
        $show_id = $select_show_id[0]->id;

        //record DO header
        $t_do_h = t_do_h::create([
            "company_id" => $p_company_id,
            "do_show_id" => $show_id,
            "so_id" => $p_so_number,
            "delivery_date" => $p_do_header['delivery_date'],
            "ship_to_address" => $p_do_header['address'],
            "ship_to_city" => $p_do_header['city'],
            "ship_to_country" => $p_do_header['country'],
            "ship_to_postal_code" => $p_do_header['postalcode'],
            "ship_to_phone1" => $p_do_header['phone1'],
            "ship_to_phone2" => $p_do_header['phone2'],
            "deleted" => 0,
            "print" => 0,
            "note" => $p_do_header['note']
        ]);

        // dd($p_so_item, $p_so_item_details);
        //record DO item
        for ($i=0; $i < count($p_so_item) ; $i++) { 
            // $so_item[$i]['item_sequence'] = $this->modal1_datas[$i]['item_sequence'];
            // $so_item[$i]['item_id'] = $this->modal1_datas[$i]['item_id'];
            // $so_item[$i]['final_delivery'] = $this->soitem_dlv[$i];

            for ($j=0; $j < count($p_so_item_details[$i]) ; $j++) { 
                $t_do_d = t_do_d::create([
                    'id' => $t_do_h->id,
                    'item_sequence' => $p_so_item[$i]['item_sequence'],
                    'locbatch_split' => $j+1,
                    'item_id' => $p_so_item[$i]['item_id'],
                    'location_id' => $p_so_item_details[$i][$j]['location_id'],
                    'batch' => $p_so_item_details[$i][$j]['batch'],
                    'qty' => $p_so_item_details[$i][$j]['qty']
                ]);
                // $temp_locbatch = explode('-', $this->soitem_locbatch[$i][$j]);
                // $so_item_details[$i][$j]['location_id'] = $temp_locbatch[0];
                // $so_item_details[$i][$j]['batch'] = $temp_locbatch[1];
                // $so_item_details[$i][$j]['qty'] = intval($this->soitem_qty[$i][$j]);
            } 
        }
        
    }

    private function updateSOStatus($p_so_number, $p_so_item){
        foreach ($p_so_item as $data) {
            $update = DB::table('t_so_d')
                    ->where('id', $p_so_number)
                    ->where('item_sequence', $data['item_sequence'])
                    ->update(['final_delivery' => $data['final_delivery']]);
        }
    }

    private function postItemMovement($p_POorSO, $p_POorSO_id, $p_posting_date, $p_user, $p_company_id, $p_movkey, $p_movedesc, $p_behaviour, $p_items_cart, $p_items_cart_details){
        
        //record item header
        $t_itmove_h = t_itmove_h::create([
            'posting_date' => $p_posting_date,
            'user_id' => $p_user,
            'company_id' => $p_company_id,
            'movement_id' => $p_movkey,
            'desc' => $p_movedesc
        ]);

        //record item detail
        $po_id = 0;
        $so_id = 0;
        if ($p_POorSO == 'PO') {
            $po_id = $p_POorSO_id;
        }elseif ($p_POorSO == 'SO') {
            $so_id = $p_POorSO_id;
        }
        $index=0;
        if ($p_behaviour == 'GR') {
            foreach ($p_items_cart as $item_cart) {

                $po_item_sequence = 0;
                $so_item_sequence = 0;
                if ($p_POorSO == 'PO') {
                    $po_item_sequence = $p_items_cart_details[$index]['item_sequence'];
                }elseif ($p_POorSO == 'SO') {
                    // $so_item_sequence = $p_items_cart_details[$index]['item_sequence'];
                }

                $t_itmove_d = t_itmove_d::create([
                    'id' => $t_itmove_h->id,
                    'item_id' => $item_cart['id'],
                    'to_loc' => $p_items_cart_details[$index]['to_location'],
                    'to_batch' => $p_items_cart_details[$index]['to_batch'],
                    'qty' => $p_items_cart_details[$index]['qty'],
                    'amount' => $p_items_cart_details[$index]['amount'],
                    'po_id' => $po_id,
                    'po_item_sequence' => $po_item_sequence,
                    'so_id' => $so_id,
                    'so_item_sequence' => $so_item_sequence
                ]);
                $index++;
            }
            
        }elseif ($p_behaviour == 'GI') {
            foreach ($p_items_cart as $item_cart) {
                $po_item_sequence = 0;
                $so_item_sequence = 0;
                if ($p_POorSO == 'PO') {
                    // $po_item_sequence = $p_items_cart_details[$index]['item_sequence'];
                }elseif ($p_POorSO == 'SO') {
                    $so_item_sequence = $p_items_cart_details[$index]['item_sequence'];
                }

                $t_itmove_d = t_itmove_d::create([
                    'id' => $t_itmove_h->id,
                    'item_id' => $item_cart['id'],
                    'from_loc' => $p_items_cart_details[$index]['to_location'],
                    'from_batch' => $p_items_cart_details[$index]['to_batch'],
                    'qty' => $p_items_cart_details[$index]['qty'],
                    'amount' => 0,
                    'po_id' => $po_id,
                    'po_item_sequence' => $po_item_sequence,
                    'so_id' => $so_id,
                    'so_item_sequence' => $so_item_sequence
                ]);
                $index++;
            }
        }elseif ($p_behaviour == 'TRANS') {
            foreach ($p_items_cart as $item_cart) {
                $t_itmove_d = t_itmove_d::create([
                    'id' => $t_itmove_h->id,
                    'item_id' => $item_cart['id'],
                    'from_loc' => $p_items_cart_details[$index]['from_location'],
                    'to_loc' => $p_items_cart_details[$index]['to_location'],
                    'from_batch' => $p_items_cart_details[$index]['from_batch'],
                    'to_batch' => $p_items_cart_details[$index]['to_batch'],
                    'qty' => $p_items_cart_details[$index]['qty'],
                    'amount' => $p_items_cart_details[$index]['amount']
                ]);
                $index++;
            }
        }

        return $t_itmove_h->id;
    }

    private function postInventoryStock($p_posting_date, $p_company_id, $p_movkey, $p_behaviour, $p_items_cart, $p_items_cart_details){
        $noerror['status'] = true;

        $posting_date = date_create($p_posting_date);
        $month = date_format($posting_date, 'n');
        $year = date_format($posting_date,'Y');
        
        $previous_date = date_modify($posting_date,'last day of previous month');
        $previous_month = date_format($previous_date,'n');
        $previous_year = date_format($previous_date,'Y');
        
        $selected_movkey = movement_keys::find($p_movkey);
        
        //record inventory stock
        $index=0;
        if ($p_behaviour == 'GR') {
            foreach ($p_items_cart as $item_cart) {
                
                $get_t_invstock = $this->getMonthEndingInv(
                    $item_cart['id'],
                    $p_company_id,
                    $month,
                    $year,
                    $p_items_cart_details[$index]['to_location'],
                    $p_items_cart_details[$index]['to_batch']
                );

                $get_t_invstock_previous = $this->getEndingInv(
                    $item_cart['id'],
                    $p_company_id,
                    $p_items_cart_details[$index]['to_location'],
                    $p_items_cart_details[$index]['to_batch']
                );

                if($get_t_invstock['period']==''){
                    
                    $qty = $get_t_invstock_previous['qty'];

                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'company_id' => $p_company_id,
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $p_items_cart_details[$index]['to_location'] ,
                        'batch' => $p_items_cart_details[$index]['to_batch'] ,
                        'category' => 'begin' ,
                        'qty' => $qty
                    ]);
                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'company_id' => $p_company_id,
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $p_items_cart_details[$index]['to_location'] ,
                        'batch' => $p_items_cart_details[$index]['to_batch'] ,
                        'category' => 'ending' ,
                        'qty' => $qty
                    ]);
                    
                }
                
                $t_invstock = t_invstock::create([
                    'item_id' => $item_cart['id'],
                    'company_id' => $p_company_id,
                    'period' => $month ,
                    'year' => $year ,
                    'location_id' => $p_items_cart_details[$index]['to_location'] ,
                    'batch' => $p_items_cart_details[$index]['to_batch'] ,
                    'category' => $selected_movkey->name ,
                    'qty' => $p_items_cart_details[$index]['qty']
                ]);

                $update_ending = DB::update(
                    'update t_invstock set qty=qty+'.$p_items_cart_details[$index]['qty'].'
                    where item_id=? and period=? and year=? and location_id=? and batch=? and category=?',
                    [
                        $item_cart['id'],
                        $month,
                        $year,
                        $p_items_cart_details[$index]['to_location'],
                        $p_items_cart_details[$index]['to_batch'],
                        'ending'
                    ]
                );

                $index++;
            }
        }elseif ($p_behaviour == 'GI') {
            foreach ($p_items_cart as $item_cart) {
                
                $get_t_invstock = $this->getMonthEndingInv(
                    $item_cart['id'],
                    $p_company_id,
                    $month,
                    $year,
                    $p_items_cart_details[$index]['to_location'],
                    $p_items_cart_details[$index]['to_batch']
                );

                $get_t_invstock_previous = $this->getEndingInv(
                    $item_cart['id'],
                    $p_company_id,
                    $p_items_cart_details[$index]['to_location'],
                    $p_items_cart_details[$index]['to_batch']
                );

                if($get_t_invstock['period']==''){
                    
                    $qty = $get_t_invstock_previous['qty'];

                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'company_id' => $p_company_id,
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $p_items_cart_details[$index]['to_location'] ,
                        'batch' => $p_items_cart_details[$index]['to_batch'] ,
                        'category' => 'begin' ,
                        'qty' => $qty
                    ]);
                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'company_id' => $p_company_id,
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $p_items_cart_details[$index]['to_location'] ,
                        'batch' => $p_items_cart_details[$index]['to_batch'] ,
                        'category' => 'ending' ,
                        'qty' => $qty
                    ]);
                    
                }
                if ($p_items_cart_details[$index]['qty'] > $get_t_invstock_previous['qty']){ //cek stok
                    
                    $temp_item = m_items::find($item_cart['id']);
                    $temp_location = m_locations::find($p_items_cart_details[$index]['to_location']);
                    $message = 'Insufficient stock of Item '. $temp_item->show_id . ' ('.$temp_item->name.'), Location ' . $temp_location->name . ', Batch '.$p_items_cart_details[$index]['to_batch'].'. Input qty: '.$p_items_cart_details[$index]['qty'].' , Available Stock: '.$get_t_invstock_previous['qty'];

                    $noerror['status'] = false;
                    $noerror['message'] = $message;
                    return $noerror;
                }

                $qty = $p_items_cart_details[$index]['qty']*-1; //GI nilai normalnya adalah negatif

                $t_invstock = t_invstock::create([
                    'item_id' => $item_cart['id'],
                    'company_id' => $p_company_id,
                    'period' => $month ,
                    'year' => $year ,
                    'location_id' => $p_items_cart_details[$index]['to_location'] ,
                    'batch' => $p_items_cart_details[$index]['to_batch'] ,
                    'category' => $selected_movkey->name ,
                    'qty' => $qty
                ]);

                $update_ending = DB::update(
                    'update t_invstock set qty=qty+'.$qty.'
                    where item_id=? and period=? and year=? and location_id=? and batch=? and category=?',
                    [
                        $item_cart['id'],
                        $month,
                        $year,
                        $p_items_cart_details[$index]['to_location'],
                        $p_items_cart_details[$index]['to_batch'],
                        'ending'
                    ]
                );
                $index++;
            }
        }elseif ($p_behaviour == 'TRANS') {
            foreach ($p_items_cart as $item_cart) {
                //record "from"
                $get_t_invstock_from = $this->getMonthEndingInv(
                    $item_cart['id'],
                    $p_company_id,
                    $month,
                    $year,
                    $p_items_cart_details[$index]['from_location'],
                    $p_items_cart_details[$index]['from_batch']
                );

                $get_t_invstock_previous_from = $this->getEndingInv(
                    $item_cart['id'],
                    $p_company_id,
                    $p_items_cart_details[$index]['from_location'],
                    $p_items_cart_details[$index]['from_batch']
                );

                if($get_t_invstock_from['period']==''){
                    
                    $qty = $get_t_invstock_previous_from['qty'];

                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'company_id' => $p_company_id,
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $p_items_cart_details[$index]['from_location'] ,
                        'batch' => $p_items_cart_details[$index]['from_batch'] ,
                        'category' => 'begin' ,
                        'qty' => $qty
                    ]);
                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'company_id' => $p_company_id,
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $p_items_cart_details[$index]['from_location'] ,
                        'batch' => $p_items_cart_details[$index]['from_batch'] ,
                        'category' => 'ending' ,
                        'qty' => $qty
                    ]);
                    
                }
                
                $qty = $p_items_cart_details[$index]['qty']*-1;

                $t_invstock = t_invstock::create([
                    'item_id' => $item_cart['id'],
                    'company_id' => $p_company_id,
                    'period' => $month ,
                    'year' => $year ,
                    'location_id' => $p_items_cart_details[$index]['from_location'] ,
                    'batch' => $p_items_cart_details[$index]['from_batch'] ,
                    'category' => $selected_movkey->name ,
                    'qty' => $qty
                ]);

                $update_ending = DB::update(
                    'update t_invstock set qty=qty+'.$qty.'
                    where item_id=? and period=? and year=? and location_id=? and batch=? and category=?',
                    [
                        $item_cart['id'],
                        $month,
                        $year,
                        $p_items_cart_details[$index]['from_location'],
                        $p_items_cart_details[$index]['from_batch'],
                        'ending'
                    ]
                );

                //record "to"
                $get_t_invstock_to = $this->getMonthEndingInv(
                    $item_cart['id'],
                    $p_company_id,
                    $month,
                    $year,
                    $p_items_cart_details[$index]['to_location'],
                    $p_items_cart_details[$index]['to_batch']
                );

                $get_t_invstock_previous_to = $this->getEndingInv(
                    $item_cart['id'],
                    $p_company_id,
                    $p_items_cart_details[$index]['to_location'],
                    $p_items_cart_details[$index]['to_batch']
                );

                if($get_t_invstock_to['period']==''){
                    
                    $qty = $get_t_invstock_previous_to['qty'];

                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'company_id' => $p_company_id,
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $p_items_cart_details[$index]['to_location'] ,
                        'batch' => $p_items_cart_details[$index]['to_batch'] ,
                        'category' => 'begin' ,
                        'qty' => $qty
                    ]);
                    $t_invstock = t_invstock::create([
                        'item_id' => $item_cart['id'],
                        'company_id' => $p_company_id,
                        'period' => $month ,
                        'year' => $year ,
                        'location_id' => $p_items_cart_details[$index]['to_location'] ,
                        'batch' => $p_items_cart_details[$index]['to_batch'] ,
                        'category' => 'ending' ,
                        'qty' => $qty
                    ]);
                    
                }
                
                $qty = $p_items_cart_details[$index]['qty'];

                $t_invstock = t_invstock::create([
                    'item_id' => $item_cart['id'],
                    'company_id' => $p_company_id,
                    'period' => $month ,
                    'year' => $year ,
                    'location_id' => $p_items_cart_details[$index]['to_location'] ,
                    'batch' => $p_items_cart_details[$index]['to_batch'] ,
                    'category' => $selected_movkey->name ,
                    'qty' => $qty
                ]);

                $update_ending = DB::update(
                    'update t_invstock set qty=qty+'.$qty.'
                    where item_id=? and period=? and year=? and location_id=? and batch=? and category=?',
                    [
                        $item_cart['id'],
                        $month,
                        $year,
                        $p_items_cart_details[$index]['to_location'],
                        $p_items_cart_details[$index]['to_batch'],
                        'ending'
                    ]
                );


                $index++;
            }
        }

        return $noerror;
    }

    private function postPriceHistory($itmoveh_id, $p_posting_date, $p_company_id, $p_movkey, $p_behaviour, $p_items_cart, $p_items_cart_details){

        $selected_movkey = movement_keys::find($p_movkey);
        
        $index=0;
        if ($p_behaviour == 'GR'){

            foreach ($p_items_cart as $item_cart) {
                
                $latest_record = $this->latestPriceHistory($item_cart['id'],$p_company_id);

                $qty = $p_items_cart_details[$index]['qty'];
                $total_qty = $latest_record['total_qty'] + $p_items_cart_details[$index]['qty'];
                
                if ($selected_movkey->type=='OWV') {
                    $amount = $latest_record['cogs'] * $qty;
                }elseif ($selected_movkey->type=='INIT'||$selected_movkey->type=='PURC') {
                    $amount = $p_items_cart_details[$index]['amount'];
                }elseif ($selected_movkey->type=='OWOV') {
                    $amount = 0;
                }

                $total_amount = $latest_record['total_amount'] + $amount;

                $cogs = $total_amount / $total_qty;

                $t_pricehist = t_pricehist::create([
                    'posting_date' => $p_posting_date,
                    'movement_id' => $itmoveh_id,
                    'movement_key' => $p_movkey,
                    'item_id' => $item_cart['id'],
                    'company_id' => $p_company_id,
                    'qty' => $p_items_cart_details[$index]['qty'],
                    'amount' => $p_items_cart_details[$index]['amount'],
                    'total_qty' => $total_qty,
                    'total_amount' => $total_amount,
                    'cogs' => $cogs
                ]);

                // $update_itmove_d = DB::table('t_itmove_d')
                //                     ->where('id',$itmoveh_id) 
                //                     ->update(
                //                         ['amount' => $amount]
                //                     );

                $update_m_items = DB::table('m_items')
                                    ->where('id', $item_cart['id'])
                                    ->where('company_id', $p_company_id)
                                    ->update([
                                            'total_qty' => $total_qty,
                                            'total_amount' => $total_amount
                                        ]);

                $index++;
            }

        }elseif ($p_behaviour == 'GI') {
            foreach ($p_items_cart as $item_cart) {
                
                $latest_record = $this->latestPriceHistory($item_cart['id'],$p_company_id);
                
                $qty = $p_items_cart_details[$index]['qty']*-1;
                
                $amount = 0;

                if($latest_record['found']){
                    
                    $total_qty = $latest_record['total_qty'] + $qty;
                    
                    if ($selected_movkey->type=='OWV' || $selected_movkey->type=='SELL' ) {
                        $amount = $latest_record['cogs'] * $qty;
                    }elseif ($selected_movkey->type=='OWOV') {
                        $amount = 0;
                    }
                    
                    if ($total_qty==0) {
                        $total_amount = 0; //memastikan supaya amount 0 jika qty 0
                    }else{
                        $total_amount = $latest_record['total_amount'] + $amount;
                        if ($total_amount < 0) {
                            $total_amount = 0;
                        }
                    }
                    
                }else {
                    //seharusnya tidak mungkin masuk kesini, karena stock harus ada baru bisa GI
                    $total_qty = $qty;
                    $total_amount = $amount;
                }
                
                if ($total_qty == 0){
                    $cogs = 0;
                }else{
                    $cogs = $total_amount / $total_qty;
                }
                
                
                $t_pricehist = t_pricehist::create([
                    'posting_date' => $p_posting_date,
                    'movement_id' => $itmoveh_id,
                    'movement_key' => $p_movkey,
                    'item_id' => $item_cart['id'],
                    'company_id' => $p_company_id,
                    'qty' => $qty,
                    'amount' => $amount,
                    'total_qty' => $total_qty,
                    'total_amount' => $total_amount,
                    'cogs' => $cogs
                ]);

                $amount_itmove_d = $amount*-1;
                
                $update_itmove_d = DB::table('t_itmove_d')
                                    ->where('id',$itmoveh_id)
                                    ->update(
                                        ['amount' => $amount_itmove_d]
                                    );

                $update_m_items = DB::table('m_items')
                                    ->where('id', $item_cart['id'])
                                    ->where('company_id', $p_company_id)
                                    ->update([
                                        'total_qty' => $total_qty,
                                        'total_amount' => $total_amount
                                    ]);

                $index++;
            }
        }elseif ($p_behaviour == 'TRANS') {
            # code...
        }
    }


}