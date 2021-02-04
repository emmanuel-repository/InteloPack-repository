<?php

namespace App\Http\Controllers;

class SpaController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }
    
    public function index()
    {
        return view('layouts.spa_main');
    }
}
