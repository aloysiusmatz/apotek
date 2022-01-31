<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;


class SalesorderView extends Component
{

    public $error_list=[];
    public $success_message='';
    public $additem_query='';
    public $search_item_result=[];


    public function render()
    {
        if($this->additem_query!=''){
            $this->searchAddItemQuery($this->additem_query);
        }else{
            $this->search_item_result=[];
        }

        return view('livewire.salesorder-view');
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
        // $new_item_sequence = $this->so_item[$index-1]['item_sequence']+1;
        // $this->so_item[$index]['id'] = '';
        // $this->so_item[$index]['item_sequence'] = $new_item_sequence;
        // $this->so_item[$index]['item_id'] = $item_id;
        // $this->so_item[$index]['qty'] = 0;
        // $this->so_item[$index]['price_unit'] = 0;
        // $this->so_item[$index]['discount'] = 0;
        // $this->so_item[$index]['tax'] = session()->get('default_tax');
        // $this->so_item[$index]['final_delivery'] = 0; 
        // $this->so_item[$index]['created_at'] = '';
        // $this->so_item[$index]['updated_at'] = '';
        // $this->so_item[$index]['item_show_id'] = $m_items->show_id;
        // $this->so_item[$index]['item_name'] = $m_items->name;
        // $this->so_item[$index]['deleted'] = 0;

        // $this->modal2_poitem_qty[$new_item_sequence] = 0;
        // $this->modal2_poitem_price[$new_item_sequence] = 0;
        // $this->modal2_poitem_disc[$new_item_sequence] = 0;
        // $this->modal2_poitem_tax[$new_item_sequence] = session()->get('default_tax');

        // $this->searchAddItemReset();
    }
}
