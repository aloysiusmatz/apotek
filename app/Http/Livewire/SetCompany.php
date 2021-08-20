<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\companies;

class SetCompany extends Component
{
    
    public $selection_company = 0;
    public $companydatas=[];

    public function render()
    {
        $query = "select a.company_id, b.company_code from user_has_companies a, companies b
                where a.company_id = b.id 
                and a.user_id = '".Auth::id()."
                order by a.company_id'
                ";

        $companydatas = DB::select($query);
        $this->companydatas = $companydatas;
        
        if(count($companydatas) >= 1){
            $this->selection_company = $companydatas[0]->company_id;
        }

        return view('livewire.set-company');
    }

    public function setCompanySess(){
        $data = companies::find($this->selection_company);

        session()->put('company_id', $this->selection_company);
        session()->put('company_code', $data->company_code);
        session()->put('default_tax', $data->default_tax);
        session()->put('decimal_display', $data->decimal_display);
        session()->put('thousands_separator', $data->thousands_separator);
        session()->put('decimal_separator', $data->decimal_separator);
        session()->put('qty_decimal', $data->decimal_separator);
        session()->put('database_decimal_separator', '.');
        session()->put('currency_symbol', $data->currency_symbol);
        
        return redirect()->to(route('items'));
    }
}
