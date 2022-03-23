<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    //
    public function index()
    {
        $page_title = 'Jabatan';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Jabatan'];

        return view('pages.admin.jabatan.index', compact('page_title', 'page_description','breadcumb'));
    }

    public function kelas()
    {
        $page_title = 'Kelas Jabatan';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Kelas Jabatan'];

        return view('pages.admin.jabatan.kelas-jabatan', compact('page_title', 'page_description','breadcumb'));
    }
}
