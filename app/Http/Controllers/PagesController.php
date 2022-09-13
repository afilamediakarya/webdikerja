<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PagesController extends Controller
{

    public function index_()
    {
        if (session()->has('user')) {
            return redirect('/');
        } else {
            return redirect('/login');
        }
    }

    public function getDataDashboard($params)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = '';

        if ($params == 'pegawai') {
            $response = Http::withToken($token)->get($url . "/dashboard/pegawai?bulan=" . session('bulan'));
        } elseif ($params == 'admin') {
            $response = Http::withToken($token)->get($url . "/dashboard/admin_opd");
        } else {
            $response = Http::withToken($token)->get($url . "/dashboard/super_admin");
        }
        return $response;
    }

    public function index($type)
    {
        // return $type;
        $page_title = 'Dashboard';
        $page_description = 'Some description for the page';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai'];
        $nama_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulan = (!request('bulan')) ? (int)date("m") : request('bulan');

        if ($type == 'pegawai') {
            session(['bulan' => $bulan]);
            $data = $this->getDataDashboard($type);
            // return $data;

            session()->forget('bulan');
            return view('pages.dashboard.index', compact('page_title', 'page_description', 'breadcumb', 'data', 'nama_bulan', 'bulan'));
        } elseif ($type == 'admin') {
            $data = $this->getDataDashboard($type);
            return view('pages.dashboard.admin', compact('page_title', 'page_description', 'breadcumb', 'data', 'nama_bulan', 'bulan'));
        } else {
            $data = $this->getDataDashboard($type);
            return view('pages.dashboard.super_admin', compact('page_title', 'page_description', 'breadcumb', 'data', 'nama_bulan', 'bulan'));
        }
    }

    public function pegawai_dinilai()
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url . "/dashboard/pegawai/level");
        return $response;
    }
}
