<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

/**
 * 
 */
trait InventoryMovement
{
    public function getEndingInv($item_id, $company_id, $location_id, $batch){
        
        $ending_inv = DB::table('t_invstock')
                        ->where('item_id',$item_id)
                        ->where('company_id', $company_id)
                        ->where('location_id',$location_id)
                        ->where('batch',$batch)
                        ->where('category', 'ending')
                        ->orderBy('year','desc')
                        ->orderBy('period','desc')
                        ->limit(1)
                        ->get();
        
        if(count($ending_inv)==0){
            $ending['qty'] = 0;
            $ending['year'] = '';
            $ending['period'] = '';
        }else{
            $ending['qty'] = $ending_inv->first()->qty;
            $ending['year'] = $ending_inv->first()->year;
            $ending['period'] = $ending_inv->first()->period;
        }

        return $ending;
    }

    public function getMonthEndingInv($item_id, $company_id, $period , $year,$location_id, $batch){
        $ending_inv = DB::table('t_invstock')
                        ->where('item_id',$item_id)
                        ->where('company_id', $company_id)
                        ->where('period', $period)
                        ->where('year', $year)
                        ->where('location_id',$location_id)
                        ->where('batch',$batch)
                        ->where('category', 'ending')
                        ->get();

        if(count($ending_inv)==0){
            $ending['qty'] = 0;
            $ending['year'] = '';
            $ending['period'] = '';
        }else{
            $ending['qty'] = $ending_inv->first()->qty;
            $ending['year'] = $ending_inv->first()->year;
            $ending['period'] = $ending_inv->first()->period;
        }

        return $ending;
    }

    public function latestPriceHistory($item_id, $company_id){
        $latest = DB::table('t_pricehist')
                    ->where('item_id', $item_id)
                    ->where('company_id', $company_id)
                    ->latest()->get();
        
        if(count($latest)>0){
            $result['found'] = true;
            $result['qty'] = $latest->first()->qty;
            $result['amount'] = $latest->first()->amount;
            $result['total_qty'] = $latest->first()->total_qty;
            $result['total_amount'] = $latest->first()->total_amount;
            $result['cogs'] = $latest->first()->cogs;
        }else{
            $result['found'] = false;
            $result['qty'] = 0;
            $result['amount'] = 0;
            $result['total_qty'] = 0;
            $result['total_amount'] = 0;
            $result['cogs'] = 0;
        }

        return $result;
    }
}