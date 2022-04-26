<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_do_h extends Model
{
    use HasFactory;
    protected $table = 't_do_h';

    protected $fillable = [
        'company_id',
        'do_show_id',
        'so_id',
        'delivery_date',
        'ship_to_address',
        'ship_to_city',
        'ship_to_country',
        'ship_to_postal_code',
        'ship_to_phone1',
        'ship_to_phone2',
        'deleted',
        'print',
        'note'
    ];
}
