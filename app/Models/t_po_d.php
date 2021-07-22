<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_po_d extends Model
{

    use HasFactory;
    public $timestamps = true;
    
    protected $table = 't_po_d';

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
