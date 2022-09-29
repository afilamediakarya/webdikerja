<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function index()
    {
        $page_title = 'Profile';
        $page_description = 'Daftar Profile Pegawai';
        $breadcumb = ['Daftar Profile Pegawai'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');

        return view('pages.Profile.index', compact('page_title', 'page_description', 'breadcumb'));
    }
}
