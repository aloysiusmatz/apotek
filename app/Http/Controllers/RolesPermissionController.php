<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolesPermissionController extends Controller
{
    public function index(){
        return view('developer.rolespermission.rolespermission-list');
    }
}
