<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    //
    public function index()
    {
        $page_title = 'Jadwal';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Jadwal Kegiatan'];

        return view('pages.admin.jadwal.index', compact('page_title', 'page_description','breadcumb'));
    }
}
