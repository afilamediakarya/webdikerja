<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SkpController extends Controller
{
    public function index()
    {
        $page_title = 'SKP';
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


        return view('pages.skp.index', compact('page_title', 'page_description','breadcumb'));
    }


    public function create(){
        $page_title = 'SKP';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai', 'tambah skp'];

        return view('pages.skp.add', compact('page_title', 'page_description','breadcumb'));

        
    }
}
