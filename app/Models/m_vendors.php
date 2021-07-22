<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_vendors extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'show_id',
        'name',
        'address',
        'phone',
        'alt_phone1',
        'alt_phone2'
    ];
}
