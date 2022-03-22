<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AkunController extends Controller
{
    //
    public function index()
    {
        $page_title = 'Akun';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Detail Akun'];


        return view('pages.akun.index', compact('page_title', 'page_description','breadcumb'));
    }

    public function edit()
    {
        $page_title = 'Akun';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Edit Profil'];


        return view('pages.akun.edit', compact('page_title', 'page_description','breadcumb'));
    }

}
