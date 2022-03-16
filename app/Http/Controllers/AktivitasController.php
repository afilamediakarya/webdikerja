<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AktivitasController extends Controller
{
    public function index()
    {
        $page_title = 'Aktivitas';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Aktivitas'];



        return view('pages.aktivitas.index', compact('page_title', 'page_description','breadcumb'));
    }
}
