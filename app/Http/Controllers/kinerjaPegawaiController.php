<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class kinerjaPegawaiController extends Controller
{
    public function index(){
        $data['judul'] = "Laporan Kinerja TI";
        return view('pages.kinerja_pegawai.index', $data);
    }
}
