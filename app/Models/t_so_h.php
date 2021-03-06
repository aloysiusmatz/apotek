<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_so_h extends Model
{
    use HasFactory;

    protected $table = 't_so_h';

    protected $fillable = [
        'id',
        'company_id',
        'so_show_id',
        'delivery_date',
        'customer_id',
        'customer_desc',
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
