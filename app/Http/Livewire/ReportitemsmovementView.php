<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Exports\ItemMovementExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportitemsmovementView extends Component
{
    public $item_id='';
    public $movement_key='';
    public $from_posting_date='';
    public $to_posting_date='';
    public $from_create_date='';
    public $to_create_date='';

    public $results=[];

    public $sort_column=[];

    public $confirmingUserDeletion=true;
    public function render()
    {
        $this->initSort();
        // dd('here');
        return view('livewire.reportitemsmovement-view');
    }

    public function initSort(){
        if (count($this->sort_column)==0) {
            $this->sort_column[0]['order']='asc';
            $this->sort_column[0]['column']='posting_date';

            $this->sort_column[1]['order']='asc';
            $this->sort_column[1]['column']='show_id';

            $this->sort_column[2]['order']='asc';
            $this->sort_column[2]['column']='item_name';

            $this->sort_column[3]['order']='asc';
            $this->sort_column[3]['column']='movement_key';

            $this->sort_column[4]['order']='asc';
            $this->sort_column[4]['column']='qty';

            $this->sort_column[5]['order']='asc';
            $this->sort_column[5]['column']='loc';

            $this->sort_column[6]['order']='asc';
            $this->sort_column[6]['column']='batch';

            $this->sort_column[7]['order']='asc';
            $this->sort_column[7]['column']='created_at';
            
        }
    }

    public function closeNotif(){
        session()->forget('message');    
    }

    public function clearFilter(){
        $this->item_id='';
        $this->movement_key='';
        $this->from_posting_date='';
        $this->to_posting_date='';
        $this->from_create_date='';
        $this->to_create_date='';
    }

    public function cekInput(){
        $error = false;
        if($this->to_posting_date=='' && $this->from_posting_date==''){
            session()->flash('message', 'Posting date must be filled');
            $error = true;
        }
        return $error;
    }

    public function searchMovement(){

        $this->results = [];

        if ($this->cekInput()) {
            return $this->results;
        }
        
        $query = "select a.posting_date, b.item_id, c.show_id, c.name as 'item_name', d.name as 'movement_key', d.behaviour as 'movement_behaviour', b.qty, e.name as 'from_loc', f.name as 'to_loc', b.from_batch, b.to_batch, date(a.created_at) as created_at
                 from t_itmove_h a inner join t_itmove_d b on a.id = b.id
                 INNER  JOIN m_items c on b.item_id = c.id
                 INNER  JOIN movement_keys d on a.movement_id = d.id 
                 LEFT JOIN m_locations e on b.from_loc = e.id
                 LEFT JOIN m_locations f on b.to_loc = f.id
                 where 
                 a.company_id = '".session()->get('company_id')."' ";

        if($this->item_id != ''){
            $this->item_id = strtoupper($this->item_id);
            $query = $query."and (c.name like '%".$this->item_id."%' or c.show_id like '%".$this->item_id."%') ";
        }
        if ($this->movement_key != '') {
            $this->movement_key = strtoupper($this->movement_key);
            $query = $query. "and d.name like '%".$this->movement_key."%' ";
        }
        if ($this->from_posting_date != ''){
            $query = $query. "and ( date(a.posting_date) ";

            if ($this->to_posting_date != '') {
                $query = $query. "between '".$this->from_posting_date."' and '".$this->to_posting_date."' ) ";
            }else{
                $query = $query. "= '".$this->from_posting_date."' ) ";
            }
        }elseif ($this->to_posting_date != '') {
            $query = $query. "and ( date(a.posting_date) = '".$this->to_posting_date."') ";
        }

        if ($this->from_create_date != ''){
            $query = $query. "and ( date(a.created_at) ";

            if ($this->to_create_date != '') {
                $query = $query. "between '".$this->from_create_date."' and '".$this->to_create_date."' ) ";
            }else{
                $query = $query. "= '".$this->from_create_date."' ) ";
            }
        }elseif ($this->to_create_date != '') {
            $query = $query. "and ( date(a.created_at) = '".$this->to_create_date."') ";
        }
        
        // dd($query);

        $datas = DB::select($query);

        $results=[];
        $index=0;
        foreach ($datas as $data) {
            if ($data->movement_behaviour=='TRANS') {
                $results[$index]['posting_date'] = $data->posting_date;
                $results[$index]['show_id'] = $data->show_id;
                $results[$index]['item_name'] = $data->item_name;
                $results[$index]['movement_key'] = $data->movement_key;
                $results[$index]['show_id'] = $data->show_id;
                $results[$index]['item_name'] = $data->item_name;
                $results[$index]['movement_key'] = $data->movement_key;
                $results[$index]['qty'] = $data->qty;
                $results[$index]['loc'] = $data->to_loc;
                $results[$index]['batch'] = $data->to_batch;
                $results[$index]['created_at'] = $data->created_at;

                $index++;

                $results[$index]['posting_date'] = $data->posting_date;
                $results[$index]['show_id'] = $data->show_id;
                $results[$index]['item_name'] = $data->item_name;
                $results[$index]['movement_key'] = $data->movement_key;
                $results[$index]['show_id'] = $data->show_id;
                $results[$index]['item_name'] = $data->item_name;
                $results[$index]['movement_key'] = $data->movement_key;
                $results[$index]['qty'] = $data->qty*-1;
                $results[$index]['loc'] = $data->from_loc;
                $results[$index]['batch'] = $data->from_batch;
                $results[$index]['created_at'] = $data->created_at;

            }else{
                $results[$index]['posting_date'] = $data->posting_date;
                $results[$index]['show_id'] = $data->show_id;
                $results[$index]['item_name'] = $data->item_name;
                $results[$index]['movement_key'] = $data->movement_key;
                if ($data->movement_behaviour=='GR') {
                    $results[$index]['qty'] = $data->qty;
                    $results[$index]['loc'] = $data->to_loc;
                    $results[$index]['batch'] = $data->to_batch;
                }elseif ($data->movement_behaviour=='GI') {
                    $results[$index]['qty'] = $data->qty*-1;
                    $results[$index]['loc'] = $data->from_loc;
                    $results[$index]['batch'] = $data->from_batch;
                }
    
                $results[$index]['created_at'] = $data->created_at;
            }
            

            $index++;
        }

        $this->results = $results;

        // dd($results);
    }

    public function downloadReport(){
        // dd('here');
        // return redirect()->route('export', ['results' => $this->results]);
        return Excel::download(new ItemMovementExport($this->results),'ItemMovement.xlsx');
    }

    public function sortBy($column){
        // dd($this->sort_column);
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
