<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class RealisasiController extends Controller
{
    public function index()
    {
        $page_title = 'Realisasi';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = Http::withToken($token)->get($url."/skp/list");

        return view('pages.realisasi.index', compact('page_title', 'page_description','breadcumb','data'));
    }


    public function create($params,$rencana,$bulan){
        $page_title = 'Realisasi';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai', 'tambah Realisasi'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $dataById = Http::withToken($token)->get($url."/skp/show/".$params);
        $data = $dataById['data'];

        // foreach($data['aspek_skp'] as $key => $value){
        //    if (!empty($value['realisasi_skp'])) {
        //        for ($i=0; $i < count($value['realisasi_skp']); $i++) { 
        //           if ($value['realisasi_skp'][$i]['bulan'] == $bulan) {
        //               return $value['realisasi_skp'][$i]['realisasi_bulanan'];
        //           }
        //        }
        //    }
        // }
        // return $data;
        return view('pages.realisasi.add', compact('page_title', 'page_description','breadcumb','data','rencana','bulan'));
    }

    public function store(Request $request){
        // return $request->all();
        $url = env('API_URL');
        $token = session()->get('user.access_token');
    
        $response = Http::withToken($token)->post($url."/realisasi_skp/store", [
            'id_aspek_skp' => $request->id_aspek_skp,
            'realisasi_bulanan' => $request->realisasi,
            'bulan' => $request->bulan
        ]);
        return $response;
    }
}
