<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index()
    {
        $page_title = 'Admin';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Admin'];

        return view('pages.admin.admin.index', compact('page_title', 'page_description','breadcumb'));
    }
}
