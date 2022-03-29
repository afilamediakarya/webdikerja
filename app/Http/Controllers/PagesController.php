<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        // return 'hei';
        $page_title = 'Dashboard';
        $page_description = 'Some description for the page';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai'];

        return view('pages.dashboard.index', compact('page_title', 'page_description','breadcumb'));
    }

}
