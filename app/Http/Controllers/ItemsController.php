<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralFunctions;

class ItemsController extends Controller
{
    use GeneralFunctions;
    
    public function index(Request $request){
        if ($this->checkCompanySession($request)==false){return redirect(route('setcompany'));}

        return view('pages.items.index');
    }
}
