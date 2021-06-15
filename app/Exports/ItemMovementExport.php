<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ItemMovementExport implements FromView
{
    
    public function __construct($results){
        $this->results = $results;
    }

    public function view(): View
    {
        // dd($this->results);
        // return DB::select($this->my_query);
        return view('pages.reports.itemsmovement.export', [
            'results' => $this->results
            ]);
    }
}
