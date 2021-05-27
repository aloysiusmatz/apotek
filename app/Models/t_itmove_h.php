<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_itmove_h extends Model
{
    use HasFactory;

    protected $table = 't_itmove_h';
    
    protected $fillable = [
        'posting_date',
        'company_id',
        'movement_id',
        'desc',
        'user_id'
    ];
}
