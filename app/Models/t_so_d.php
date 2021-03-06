<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_so_d extends Model
{
    use HasFactory;

    protected $table = 't_so_d';

    protected $fillable = [
        'id',
        'item_sequence',
        'item_id',
        'qty',
        'price_unit',
        'discount',
        'tax',
        'final_delivery'
    ];
}
