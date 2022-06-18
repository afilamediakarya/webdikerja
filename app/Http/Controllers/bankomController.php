<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class bankomController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Bankom';
        $page_description = 'Daftar Bankom';
        $breadcumb = ['Daftar Bankom'];
        $url_img = env('IMG_URL');
        $role = session()->get('user.role');

        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        
        $satuan_kerja = session()->get('user.current.pegawai.id_satuan_kerja');
        if($request->ajax()){
            $response = Http::withToken($token)->get($url."/bankom/list");
         
            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }else{
                return 'err';
            }
        }

        return view('pages.bankom.index', compact('page_title', 'page_description','breadcumb','url_img','role','satuan_kerja'));
    }
}
