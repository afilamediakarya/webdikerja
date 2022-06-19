<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;

class PenilaianController extends Controller
{
    public function index($type)
    {
        $page_title = 'Penilaian '.ucfirst($type);
        $page_description = 'Daftar Pegawai yang dinilai';
        $breadcumb = ['Daftar Pegawai yang dinilai'];
        return view('pages.penilaian.index', compact('page_title', 'page_description','breadcumb', 'type'));
    }

    public function getData($type){
        $result = [];
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = '';
        if ($type == 'skp') {
            $response = Http::withToken($token)->get($url."/review_skp/list");
        }else{
            $response = Http::withToken($token)->get($url."/review_realisasi/list");
        }
   
        if ($response->successful()) {
            $data = $response->json();
            return $data;
        }else{
            return 'err';
        }
    }

    public function getSkpPegawai($params,$type,$bulan){
        // return $type;
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = '';

        if ($type == 'realisasi') {
            $response = Http::withToken($token)->get($url."/review_realisasi/skpbyId/".$params."/".$bulan);
            return $response;
        }else{
            $response = Http::withToken($token)->get($url."/review_skp/skpbyId/".$params);
        }
        return $response['data'];
    }

    public function create($type, $id){
        $page_title = 'Penilaian';
        $page_description = 'Daftar Pegawai yang dinilai';
        $breadcumb = ['Daftar Pegawai yang dinilai', 'tambah Realisasi'];
        $skp = $this->getSkpPegawai($id,$type,NULL);
        // return $skp;
        return view('pages.penilaian.'.$type, compact('page_title', 'page_description','breadcumb','skp'));
    }

    public function createRealisasi($type, $id, $bulan){
        $page_title = 'Penilaian';
        $page_description = 'Daftar Pegawai yang dinilai';
        $breadcumb = ['Daftar Pegawai yang dinilai', 'tambah Realisasi'];
        $skp = $this->getSkpPegawai($id,$type,$bulan);
        
        return view('pages.penilaian.'.$type, compact('page_title', 'page_description','breadcumb','skp','bulan'));
    }

    public function postReviewSkp(Request $request){
        $data = $request->all();
        // return $data;
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url."/review_skp/store/", $data);
        return $response;
    }

    public function postReviewRealisasiSkp(Request $request){
        $data = $request->all();
        // return $data;
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url."/review_realisasi/store/", $data);
        return $response;
    }
}
