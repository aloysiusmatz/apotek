<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_do_d extends Model
{
    use HasFactory;

    protected $table = 't_do_d';

    protected $fillable = [
        'id',
        'item_sequence',
        'locbatch_split',
        'item_id',
        'location_id',
        'batch',
        'qty'
    ];
}
