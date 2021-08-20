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
                session()->put('default_tax', $companies->default_tax);
                session()->put('decimal_display', $companies->decimal_display);
                session()->put('thousands_separator', $companies->thousands_separator);
                session()->put('decimal_separator', $companies->decimal_separator);
                session()->put('qty_decimal', $companies->qty_decimal);
                session()->put('database_decimal_separator', '.');
                session()->put('currency_symbol', $companies->currency_symbol);
            }
            
        }
        return $check;
    }

    public function currencyFormatInput($price_string){
        return str_replace(session()->get('decimal_separator'),session()->get('database_decimal_separator'), $price_string);
    }

    public function currencyFormatOutput($price_string){
        return str_replace(session()->get('database_decimal_separator'), session()->get('decimal_separator'), $price_string);
    }

    public function qtyFormatInput($qty_string){
        return str_replace(session()->get('decimal_separator'),session()->get('database_decimal_separator'), $qty_string);
    }

    public function qtyFormatOutput($qty_string){
        return str_replace(session()->get('database_decimal_separator'), session()->get('decimal_separator'), $qty_string);
    }

}
