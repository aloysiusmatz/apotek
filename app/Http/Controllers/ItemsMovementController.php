<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemsMovementController extends Controller
{
    public function index(){
        return view('pages.itemsmovement.index');
    }
}
