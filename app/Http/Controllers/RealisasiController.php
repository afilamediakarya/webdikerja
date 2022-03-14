<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RealisasiController extends Controller
{
    public function index()
    {
        $page_title = 'Realisasi';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai'];

        $DUMMY_DATA = 
        [
            [
                "no" => "A",
                "jenis" => "Kinerja Utama"
            ],[
                "no" => "B",
                "jenis" => "Kinerja Tambahan"
            ],

        ];

        $data = (object) $DUMMY_DATA;
        // dd($data);


        return view('pages.realisasi.index', compact('page_title', 'page_description','breadcumb'));
    }


    public function create(){
        $page_title = 'Realisasi';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai', 'tambah Realisasi'];

        return view('pages.realisasi.add', compact('page_title', 'page_description','breadcumb'));

        
    }
}
