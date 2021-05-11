<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovementKeyController extends Controller
{
    public function index(){
        // return 'halo';
        return view('developer.movementkey.index');
    }
    
}
