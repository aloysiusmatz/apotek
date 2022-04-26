<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrintPurchaseOrderController extends Controller
{
    public function POPrint($po_show_id){

        DB::beginTransaction();
        
        $query = "
        select tpd.id as 'po_number', tpd.item_sequence , tpd.item_id , tpd.qty , tpd.price_unit, tpd.final_delivery as 'dlv', tpd.discount, tpd.tax,
        tph.po_show_id, tph.delivery_date, tph.vendor_id, tph.payment_terms, tph.grand_total, date(tph.created_at) as 'created_at', tph.ship_to_address, tph.ship_to_city, tph.ship_to_country, tph.ship_to_postal_code, tph.ship_to_phone1, tph.ship_to_phone2, tph.shipping_value, tph.others_value, tph.note,
        mi.name as 'item_name', mi.show_id as 'item_show_id', mi.unit as 'item_unit',
        mv.show_id as 'vendor_show_id', mv.name as 'vendor_name',mv.address as 'vendor_address', mv.city as 'vendor_city', mv.country as 'vendor_country', mv.phone as 'vendor_phone1', mv.alt_phone1 as 'vendor_phone2'
        from t_po_d tpd, t_po_h tph, m_items mi, m_vendors mv 
        WHERE 
        tpd.id = tph.id and
        tpd.item_id = mi.id and
        tph.vendor_id = mv.id and 
        tph.po_show_id = '".$po_show_id."' and
        tph.company_id = '".session()->get('company_id')."' and
        tph.deleted = 0
        for share
        ";

        $select = DB::select($query);

        $modal3_datas=[];
        $index=0;
        foreach ($select as $data) {
            $modal3_datas[$index] = (array) $data;
            $modal3_datas[$index]['subtotal'] = ($data->qty*$data->price_unit)*((100-$data->discount)/100)*((100+$data->tax)/100);
            $index++;
        }

        $companies = DB::table('companies')
                        ->where('id', session()->get('company_id'));
        $companies = (array) $companies->first();
        
        //add print counter
        
        $update = "update t_po_h
        set print = print+1
        where po_show_id='".$po_show_id."' and company_id='".session()->get('company_id')."'";
        DB::update($update);
        DB::commit();

        return view('pages.print.print-po',[
            'modal3_datas' => $modal3_datas,
            'modal3_companies' => $companies
        ]);
    }
}
