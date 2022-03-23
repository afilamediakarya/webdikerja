<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SatkerController extends Controller
{
    //
    public function index()
    {
        $page_title = 'Satuan Kerja';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Satuan Kerja'];

        return view('pages.admin.satker.index', compact('page_title', 'page_description','breadcumb'));
    }
}
