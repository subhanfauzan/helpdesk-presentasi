<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cobaController extends Controller
{
    public function index(){
        return view('pages.coba.index');
    }
}
