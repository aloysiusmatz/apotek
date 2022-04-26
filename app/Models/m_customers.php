<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_customers extends Model
{
    use HasFactory;

    protected $table = 'm_customers';

    protected $fillable = [
        'company_id',
        'show_id',
        'tax_id',
        'name',
        'address',
        'city',
        'country',
        'phone',
        'alt_phone1',
        'alt_phone2'
        ];
}
