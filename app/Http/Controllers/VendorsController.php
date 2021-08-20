<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralFunctions;

class VendorsController extends Controller
{
    use GeneralFunctions;
    
    public function index(){
        if ($this->checkCompanySession()==false){return redirect(route('setcompany'));}

        return view('pages.vendors.index');
    }
}
