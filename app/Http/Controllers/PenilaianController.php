<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $page_title = 'Penilaian';
        $page_description = 'Daftar Pegawai yang dinilai';
        $breadcumb = ['Daftar Pegawai yang dinilai'];



        return view('pages.penilaian.index', compact('page_title', 'page_description','breadcumb'));
    }


    public function create(){
        $page_title = 'Penilaian';
        $page_description = 'Daftar Pegawai yang dinilai';
        $breadcumb = ['Daftar Pegawai yang dinilai', 'tambah Realisasi'];

        return view('pages.realisasi.add', compact('page_title', 'page_description','breadcumb'));

        
    }
}
