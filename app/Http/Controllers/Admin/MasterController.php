<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    //
    public function faq()
    {
        $page_title = 'Master';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Frequently Ask Questions'];

        return view('pages.admin.master.faq', compact('page_title', 'page_description','breadcumb'));
    }

    public function satuan()
    {
        $page_title = 'Master';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Satuan'];

        return view('pages.admin.master.satuan', compact('page_title', 'page_description','breadcumb'));
    }

    public function perilaku()
    {
        $page_title = 'Master';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Perilaku'];

        return view('pages.admin.master.perilaku', compact('page_title', 'page_description','breadcumb'));
    }
}
