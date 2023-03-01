<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;

class PenilaianController extends Controller
{
    public function index($type)
    {
        $page_title = 'Penilaian ' . ucfirst($type);
        $page_description = 'Daftar Pegawai yang dinilai';
        $breadcumb = ['Daftar Pegawai yang dinilai'];
        $nama_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        if ($type == 'realisasi' || $type == 'skp') {
           return view('pages.penilaian.index', compact('page_title', 'page_description', 'breadcumb', 'type', 'nama_bulan'));
        }elseif($type == 'kinerja'){
            $page_title = 'Review Aktivitas';
            $page_description = 'Daftar kinerja pegawai';
            $breadcumb = ['Daftar kinerja pegawai'];
            return view('pages.penilaian.review_aktivitas', compact('page_title', 'page_description', 'breadcumb','type','nama_bulan'));
        }else{
             $url = env('API_URL');
            $token = session()->get('user.access_token');
            $pegawai = request('pegawai');
            $bulan = request('bulan');
            $page_title = 'Penilaian';
            $page_description = 'Daftar Review kinerja';
            $breadcumb = ['Review Aktivitas', 'Review kinerja | '.request('nama')];
            $sasaran_kinerja = Http::withToken($token)->get($url."/aktivitas/get-option-sasaran-kinerja?pegawai=".$pegawai)->json();
            $masterAktivitas = Http::withToken($token)->get($url."/master_aktivitas/option")->json();
            return view('pages.penilaian.realisasi_aktivitas',compact('page_title','page_description','breadcumb','bulan','pegawai','sasaran_kinerja','masterAktivitas'));
        }

        
    }

    public function create_penilaian_kinerja(){
        $pegawai = request('pegawai');
        $bulan = request('bulan');
        $page_title = 'Penilaian';
        $page_description = 'Daftar Review kinerja';
        $breadcumb = ['Review Aktivitas', 'Review kinerja'];
        return view('pages.penilaian.realisasi_aktivitas',compact('page_title','page_description','breadcumb','bulan'));
    }

    public function getData($type)
    {
        $result = [];
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = '';
        if ($type == 'skp') {
            $response = Http::withToken($token)->get($url . "/review_skp/list?tahun=" . session('tahun_penganggaran'));
        }elseif ($type == 'kinerja') {
            // return $url . "/aktivitas/review_aktivitas_list?bulan=" . request('bulan');
            $response = Http::withToken($token)->get($url . "/aktivitas/review_aktivitas_list?bulan=" . request('bulan'));
        }elseif($type == 'realisasi') {
            $response = Http::withToken($token)->get($url . "/review_realisasi/list?tahun=" . session('tahun_penganggaran') . "&bulan=" . request('bulan'));
        }else{
            $response = Http::withToken($token)->get($url . "/aktivitas/list-by-review?tahun=" . session('tahun_penganggaran') . "&bulan=" . request('bulan') . "&pegawai=" . request("pegawai"));
        }

        if ($response->successful()) {
            $data = $response->json();
            return $data;
        } else {
            return 'err';
        }
    }

    public function checkLevel()
    {
        $level = session()->get('user.level_jabatan');
        return $level;
    }

    public function checkLevelByIdPegawai($id_pegawai)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $level = Http::withToken($token)->get($url . "/laporan/skp/cekLevel/" . $id_pegawai);
        return $level;
    }

    public function datatable()
    {

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = '';
        $type = request('type');
        $level = $this->checkLevel();

        if ($type == 'realisasi') {
            $data = Http::withToken($token)->get($url . "/review_realisasi/skpbyId/" . request('id_pegawai') . "?type=pegawai&bulan=" . request('bulan') . "&tahun=" . session('tahun_penganggaran'));
        }elseif ($type == 'kinerja') {
           $data = Http::withToken($token)->get($url . "/aktivitas/review_aktivitas_list/" . request('id_pegawai') . "?&bulan=" . request('bulan'));
        }
         else {
            $data = Http::withToken($token)->get($url . "/review_skp/skpbyId/" . request('id_pegawai') . "?&tahun=" . session('tahun_penganggaran'));
        }
        return $data;
    }

    public function create()
    {
        $id_pegawai = request('id_pegawai');
        $level = json_decode($this->checkLevelByIdPegawai($id_pegawai))->level_jabatan;
        $bulan = request('bulan');
        $page_title = 'Penilaian';
        $page_description = 'Daftar Pegawai yang dinilai';
        $breadcumb = ['Daftar Pegawai yang dinilai', 'Tambah Realisasi'];
        return view('pages.penilaian.' . request('type'), compact('page_title', 'page_description', 'breadcumb', 'id_pegawai', 'level', 'bulan'));
    }

    public function realisasi_kinerja(){
        // $id_pegawai = request('id_pegawai');
        // $level = json_decode($this->checkLevelByIdPegawai($id_pegawai))->level_jabatan;
        $bulan = request('bulan');
        $page_title = 'Penilaian';
        $page_description = 'Daftar Pegawai yang dinilai';
        $breadcumb = ['Daftar Pegawai yang dinilai', 'Tambah Realisasi'];
        return view('pages.penilaian.' . request('type'), compact('page_title', 'page_description', 'breadcumb', 'bulan'));
    }

    public function createRealisasi($type, $id, $bulan)
    {
        $page_title = 'Penilaian';
        $page_description = 'Daftar Pegawai yang dinilai';
        $breadcumb = ['Daftar Pegawai yang dinilai', 'tambah Realisasi'];
        $skp = $this->getSkpPegawai($id, $type, $bulan);

        return view('pages.penilaian.' . $type, compact('page_title', 'page_description', 'breadcumb', 'skp', 'bulan'));
    }

    public function postReviewSkp(Request $request)
    {
        $data = $request->all();
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url . "/review_skp/store/", $data);
        return $response;
    }

    public function postReviewAktivitas(Request $request){
        $data = $request->all();
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url . "/aktivitas/review_aktivitas/", $data);
        return $response;
    }

    public function postReviewRealisasiSkp(Request $request)
    {
        $data = $request->all();
        // return $data;
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url . "/review_realisasi/store/", $data);
        return $response;
    }
}
