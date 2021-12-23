<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SalesorderView extends Component
{

    public $error_list=[];
    public $success_message='';

    public function render()
    {
        return view('livewire.salesorder-view');
    }
}
