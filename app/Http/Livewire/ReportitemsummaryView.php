<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Traits\InventoryMovement;
use App\Exports\ItemSummaryExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ReportitemsummaryView extends Component
{
    public $item_id='';

    public $results=[];

    use InventoryMovement;
    
    public function render()
    {
        return view('livewire.reportitemsummary-view');
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

}
