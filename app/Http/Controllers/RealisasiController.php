<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class RealisasiController extends Controller
{

    public function checkLevel(){
        $level = session()->get('user.level_jabatan');
        return $level;
    }

    public function index()
    {
        $page_title = 'Realisasi';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        

        $level = $this->checkLevel();
        if ($level == 1 || $level == 2) {
            return view('pages.realisasi.index2', compact('page_title', 'page_description','breadcumb'));
        } else {
            $nama_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            return view('pages.realisasi.index', compact('page_title', 'page_description','breadcumb','nama_bulan'));
        }
    }

    public function checkKuantitasRealisasi($bulan,$params){
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = Http::withToken($token)->get($url."/realisasi_skp/realisasiKuantitas/".$bulan.'/'.$params);
        return $data['data'];
    }


    public function create($params,$rencana,$bulan){
        $page_title = 'Realisasi';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai', 'tambah Realisasi'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $dataById = Http::withToken($token)->get($url."/skp/show/".$params);
        // return $dataById;
        $data = $dataById['data'];
        $kuantitas = $this->checkKuantitasRealisasi($bulan,$params);
        // return $kuantitas;
    
        return view('pages.realisasi.add', compact('page_title', 'page_description','breadcumb','data','rencana','bulan','kuantitas'));
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
