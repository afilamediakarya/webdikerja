<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function index()
    {
        $page_title = 'Informasi';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Aktivitas'];

        return view('pages.admin.informasi.index', compact('page_title', 'page_description','breadcumb'));
    }
}
