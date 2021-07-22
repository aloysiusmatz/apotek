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
        'print'
    ];
}
