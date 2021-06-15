<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_invstock extends Model
{
    use HasFactory;
    protected $table = 't_invstock';

    protected $fillable = [
        'item_id',
        'company_id',
        'period',
        'year',
        'location_id',
        'batch',
        'category',
        'qty'
    ];

}
