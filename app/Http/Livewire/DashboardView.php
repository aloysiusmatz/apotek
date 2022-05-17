<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Traits\InventoryMovement;

class DashboardView extends Component
{
    use InventoryMovement;

    public $already_expired=[];
    public $nearly_expired=[];

    public function mount(){
        $this->getAllStockItem();
    }

    public function render()
    {
        return view('livewire.dashboard-view');
    }

    public function getAllStockItem(){
        $datas = $this->getAllEndingInvAllLocBatch(session()->get('company_id'));

        $date = Carbon::now();
        $current_date_string = $date->isoFormat('YMMDD');

        $buffer_date = $date->addDays(60);
        $buffer_date_string = $buffer_date->isoFormat('YMMDD');

        // dd($begin_date_string);
        $index1 = -1;
        $index2 = -1;
        foreach ($datas as $data) {
            
            if ($data['batch']==0){

            }elseif (intval($data['batch'])>=intval($current_date_string) && intval($data['batch'])<=intval($buffer_date_string)) {
                $index1++;
                $this->nearly_expired[$index1] = $data;
            }elseif (intval($data['batch'])<intval($current_date_string) ) {
                $index2++;
                $this->already_expired[$index2] = $data;
            }
            
        }
        // dd($this->nearly_expired,$this->already_expired);

    }
}
