<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_itmove_d extends Model
{
    use HasFactory;

    protected $table = 't_itmove_d';

    protected $fillable = [
        'id',
        'item_id',
        'from_loc',
        'to_loc',
        'from_batch',
        'to_batch',
        'qty',
        'amount'
    ];
}
