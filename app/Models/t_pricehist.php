<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_pricehist extends Model
{
    use HasFactory;

    protected $table = 't_pricehist';

    protected $fillable = [
        'posting_date',
        'movement_id',
        'movement_key',
        'item_id',
        'company_id',
        'qty',
        'amount',
        'total_qty',
        'total_amount',
        'cogs'
    ];
}
