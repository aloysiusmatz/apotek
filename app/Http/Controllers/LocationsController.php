<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralFunctions;

class LocationsController extends Controller
{
    use GeneralFunctions;

    public function index(){
        if ($this->checkCompanySession()==false){return redirect(route('setcompany'));}

        return view('pages.locations.index');
    }
    
}
