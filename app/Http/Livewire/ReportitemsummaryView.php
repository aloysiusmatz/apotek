<?php

namespace App\Http\Livewire;

use App\Models\m_items;
use Livewire\Component;
use App\Traits\InventoryMovement;
use App\Exports\ItemSummaryExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportitemsummaryView extends Component
{
    public $item_id='';

    public $results=[];
    public $sort_column=[];
    public $sort_column_modals=[];

    public $showDetailModal=false;
    public $modal_title='';
    public $modal_datas=[];
    public $modal_unit='';
    public $show_avail_only=true;
    public $modal_index=-1;

    public $showDetail2Modal=false;
    public $modal2_title='';
    public $modal2_datas=[];
    public $modal2_period='';

    public $showDetail3Modal=false;
    public $modal3_title='';
    public $modal3_datas=[];
    public $modal3_period='';

    use InventoryMovement;
    
    public function render()
    {
        $this->initSort();
        // dd($this->results);
        return view('livewire.reportitemsummary-view');
    }

    public function initSort(){
        if (count($this->sort_column)==0) {
            $this->sort_column[0]['order']='asc';
            $this->sort_column[0]['column']='show_id';

            $this->sort_column[1]['order']='asc';
            $this->sort_column[1]['column']='name';

            $this->sort_column[2]['order']='asc';
            $this->sort_column[2]['column']='total_qty';

            $this->sort_column[3]['order']='asc';
            $this->sort_column[3]['column']='unit';

            $this->sort_column[4]['order']='asc';
            $this->sort_column[4]['column']='total_amount';

            $this->sort_column[5]['order']='asc';
            $this->sort_column[5]['column']='cogs_unit';
        }

        if (count($this->sort_column_modals)==0) {
            $this->sort_column_modals[0]['order']='asc';
            $this->sort_column_modals[0]['column']='location_name';

            $this->sort_column_modals[1]['order']='asc';
            $this->sort_column_modals[1]['column']='batch';

            $this->sort_column_modals[2]['order']='asc';
            $this->sort_column_modals[2]['column']='qty';

        }
    }

    public function closeNotif(){
        session()->forget('message');    
    }

    public function search(){
        $this->results=[];

        $query = "select id, show_id, name, unit, total_qty, total_amount from m_items where ";

        if ($this->item_id!='') {
            $query = $query."(show_id like '%".$this->item_id."%' or name like '%".$this->item_id."%' ) and";
        }

        $query = $query." company_id='".session()->get('company_id')."' ";

        $m_items = DB::select($query);

        $index=0;
        foreach ($m_items as $m_item) {
            $this->results[$index] = (array) $m_item;
            if ($m_item->total_qty!=0) {
                $this->results[$index]['cogs_unit'] = $m_item->total_amount / $m_item->total_qty;
            }else{
                $this->results[$index]['total_qty'] = 0;
                $this->results[$index]['total_amount'] = 0;
                $this->results[$index]['cogs_unit'] = 0;
            }
            
            $index++;
        }
        
    }

    public function downloadReport(){
        return Excel::download(new ItemSummaryExport($this->results),'ItemSummary.xlsx');
    }

    public function clearFilter(){
        $this->item_id = '';
    }

    public function showDetail($item_id){
        $m_item = m_items::find($item_id);
        
        $this->modal_datas=[];
        $this->showDetailModal = true;
        $this->modal_title = $m_item->show_id.' - '.$m_item->name;
        $this->modal_unit = $m_item->unit;

        $modal_datas = $this->getEndingInvAllLocBatch($item_id, session()->get('company_id'));
        
        $this->modal_datas = $modal_datas;
        // dd($modal_datas);
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

    public function sortModalsBy($column){
        
        if ($this->sort_column_modals[$column]['order']=='asc') {
            $column_to_sort = array_column($this->modal_datas,$this->sort_column_modals[$column]['column']);
            
            array_multisort($column_to_sort,SORT_ASC,$this->modal_datas);
            $this->sort_column_modals[$column]['order']='desc';

        }else{
            $column_to_sort = array_column($this->modal_datas,$this->sort_column_modals[$column]['column']);
            
            array_multisort($column_to_sort,SORT_DESC,$this->modal_datas);
            $this->sort_column_modals[$column]['order']='asc';
        }
        
    }

    public function showModal2($index){
        if ($index<0) {
            return false;
        }
        $this->showDetailModal = false;
        $this->showDetail2Modal = true;
        $this->modal_index = $index;

        $modal2_datas = $this->getMonthlyMovement(
            $this->modal_datas[$index]['item_id'],
            $this->modal_datas[$index]['company_id'],
            $this->modal_datas[$index]['period'],
            $this->modal_datas[$index]['year'],
            $this->modal_datas[$index]['location_id'],
            $this->modal_datas[$index]['batch']
        );

        $this->modal2_title = $this->modal_title.' - '.$this->modal_datas[$index]['location_name'].' - '.$this->modal_datas[$index]['batch'];
        if ($this->modal_datas[$index]['period']<10) {
            $op = '-0';
        }else{
            $op = '-';
        }
        $this->modal2_period = $this->modal_datas[$index]['year'].$op.$this->modal_datas[$index]['period'];
        $this->modal2_datas = $modal2_datas;
        // dd($this->modal2_datas);
    }

    public function refreshModal2($index){
        $period = date_create($this->modal2_period);
        $month = date_format($period,'m');
        $year = date_format($period, 'Y');
        
        $modal2_datas = $this->getMonthlyMovement(
            $this->modal_datas[$index]['item_id'],
            $this->modal_datas[$index]['company_id'],
            $month,
            $year,
            $this->modal_datas[$index]['location_id'],
            $this->modal_datas[$index]['batch']
        );

        $this->modal2_datas = $modal2_datas;
    }

    public function closeModal2(){
        $this->showDetailModal = true;
        $this->showDetail2Modal = false;
    }

    public function showModal3($item_id, $company_id){
        $this->showDetailModal = false;
        $this->showDetail3Modal = true;
        $this->modal3_title = $this->modal_title;

        $latest = $this->latestPriceHistory($item_id, $company_id);
        if($latest['found']){
            $period = date_create($latest['posting_date']);
            $month = date_format($period,'m');
            $year = date_format($period, 'Y');
    
            $modal3_datas = $this->getMonthlyPriceHistory(
                $item_id,
                $company_id,
                $month,
                $year,
            );
            // dd($modal3_datas);
            $this->modal3_datas = $modal3_datas;
            $this->modal3_period = $year.'-'.$month;
        }
        
    }

    public function refreshModal3(){
        $period = date_create($this->modal3_period);
        $month = date_format($period,'m');
        $year = date_format($period, 'Y');

        $modal3_datas = $this->getMonthlyPriceHistory(
            $this->modal_datas[0]['item_id'],
            $this->modal_datas[0]['company_id'],
            $month,
            $year,
        );

        $this->modal3_datas = $modal3_datas;
    }

    public function closeModal3(){
        $this->showDetailModal = true;
        $this->showDetail3Modal = false;
    }

}
