<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
    public function absen()
    {
        $page_title = 'Laporan';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Absen'];


        return view('pages.laporan.absen', compact('page_title', 'page_description','breadcumb'));
    }

    public function skp()
    {
        $page_title = 'Laporan';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['SKP'];


        return view('pages.laporan.skp', compact('page_title', 'page_description','breadcumb'));
    }


    public function aktivitas()
    {
        $page_title = 'Laporan';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Aktivitas'];


        return view('pages.laporan.aktivitas', compact('page_title', 'page_description','breadcumb'));
    }

}
