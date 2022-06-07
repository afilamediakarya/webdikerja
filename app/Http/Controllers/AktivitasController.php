<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class AktivitasController extends Controller
{

    public function getSatuan(){
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/skp/get-option-satuan");
        if ($response->successful()) {
            return $response->json();
        }else{
            return 'err';
        }

        return $response;  
    }

    public function getSasaranKinerja(){
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/aktivitas/get-option-sasaran-kinerja");
        if ($response->successful()) {
            return $response->json();
        }else{
            return 'err';
        }

        return $response;
    }

    public function index(Request $request)
    {
        $page_title = 'Aktivitas';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Aktivitas'];
        if($request->ajax()){
            $url = env('API_URL');
            $token = $request->session()->get('user.access_token');
            $response = Http::withToken($token)->get($url."/aktivitas/list");
            $sasaran_kinerja = Http::withToken($token)->get($url."/aktivitas/get-option-sasaran-kinerja");
            if ($response->successful() && isset($response->object()->data)) {
                return $response->json();
            }else{
                return 'err';
            }
        }

        $sasaran_kinerja = $this->getSasaranKinerja();
        $satuan = $this->getSatuan();

        return view('pages.aktivitas.index', compact('page_title', 'page_description','breadcumb','sasaran_kinerja','satuan'));
    }

    public function aktivitas(Request $request)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/aktivitas/list");
        if ($response->successful() && isset($response->object()->data)) {
            $data = $response->object()->data;
            $dataArr = [];
            foreach ($data as $key => $value) {
                $temp = [];
                $temp['title'] = $value->nama_aktivitas; 
                $temp['id'] = $value->id; 
                $temp['start'] = "$value->tanggal $value->waktu_awal"; 
                $temp['description'] = $value->keterangan; 
                $temp['end'] = "$value->tanggal $value->waktu_awal"; 
                $temp['className'] = 'fc-event-light fc-event-solid-primary'; 
                $dataArr[] = $temp; 
            }
            return collect($dataArr);
        }else{
            return 'err';
        }
    }

    public function detail($params){
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/aktivitas/show/".$params);
        return $response;
    }

    public function store(Request $request){
       
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = $request->all();
        $filtered = array_filter(
            $data,
            function ($key){
                if(!in_array($key,['_token', 'id'])){
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        $response = Http::withToken($token)->post($url."/aktivitas/store", $filtered);
        // return $response;
        if($response->successful()){
            return response()->json(['success'=> 'Berhasil Menambah Data']);
        }else{
            return response()->json(['invalid'=> $response->json()]);
        }
    }

    public function update(Request $request,$id){
      
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = $request->all();
        $filtered = array_filter(
            $data,
            function ($key){
                if(!in_array($key,['_token', 'id'])){
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        $response = Http::withToken($token)->post($url."/aktivitas/update/".$id, $filtered);
        // return $response;
        if($response->successful()){
            return response()->json(['success'=> 'Berhasil Update Data']);
        }else{
            return response()->json(['invalid'=> $response->json()]);
        }
    }

}
