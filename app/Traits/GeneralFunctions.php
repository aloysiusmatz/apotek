<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\user_has_companies;
use App\Models\companies;

/**
 * 
 */
trait GeneralFunctions
{
    public function checkCompanySession(){
        $check = false;
        
        if ( session()->get('company_code') ) {
            $check = true;
        }else{
            $data = user_has_companies::where('user_id',Auth::id())->get();
            if ($data->count() > 1){
                $check = false;
            }elseif( $data->count() == 1 ){
                $check = true;
                $companies = companies::find($data->first()->company_id);

                session()->put('company_id', $data->first()->company_id);
                session()->put('company_code', $companies->company_code);
            }
            
        }
        return $check;
    }
}
