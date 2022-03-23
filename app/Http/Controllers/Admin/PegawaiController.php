<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    //

    public function index()
    {
        $page_title = 'Aktivitas';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Aktivitas'];

        return view('pages.admin.pegawai.index', compact('page_title', 'page_description','breadcumb'));
    }
    
    public function add()
    {
        $page_title = 'Aktivitas';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Aktivitas'];

        return view('pages.admin.pegawai.add', compact('page_title', 'page_description','breadcumb'));
    }
}
