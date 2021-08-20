<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_po_h extends Model
{
    use HasFactory;
    
    public $timestamps = true;

    protected $table = 't_po_h';

    protected $fillable = [
        'id',
        'company_id',
        'po_show_id',
        'delivery_date',
        'vendor_id',
        'payment_terms',
        'grand_total',
        'deleted',
        'print',
        'ship_to_address',
        'ship_to_city',
        'ship_to_country',
        'ship_to_postal_code',
        'ship_to_phone1',
        'ship_to_phone2',
        'shipping_value',
        'others_value',
        'note'
    ];
}
