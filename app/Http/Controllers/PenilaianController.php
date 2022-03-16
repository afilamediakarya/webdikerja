<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index($type)
    {
        $page_title = 'Penilaian '.ucfirst($type);
        $page_description = 'Daftar Pegawai yang dinilai';
        $breadcumb = ['Daftar Pegawai yang dinilai'];



        return view('pages.penilaian.index', compact('page_title', 'page_description','breadcumb', 'type'));
    }


    public function create($type, $id){
        $page_title = 'Penilaian';
        $page_description = 'Daftar Pegawai yang dinilai';
        $breadcumb = ['Daftar Pegawai yang dinilai', 'tambah Realisasi'];

        return view('pages.penilaian.'.$type, compact('page_title', 'page_description','breadcumb'));

        
    }
}
