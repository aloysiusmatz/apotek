<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class companies extends Model
{
    use HasFactory;

    public function companies_active(){
        return $this->hasOne('App\Models\companies_active', 'id');
    }
}
