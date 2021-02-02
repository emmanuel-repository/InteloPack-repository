<?php

namespace App\Http\Controllers;

class SpaController extends Controller {
    
    public function index()
    {
        return view('layouts.spa_main');
    }
}
