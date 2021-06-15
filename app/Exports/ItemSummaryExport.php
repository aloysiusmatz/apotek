<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ItemSummaryExport implements FromView
{
    
    public function __construct($results){
        $this->results = $results;
    }

    public function view(): View
    {
        // dd($this->results);
        // return DB::select($this->my_query);
        return view('pages.reports.itemssummary.export', [
            'results' => $this->results
            ]);
    }
}
