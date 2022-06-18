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

    public function store(Request $request){
        $request->validate([
            'nama_pelatihan' => 'required|string',
            'jenis_pelatihan' => 'required',
            'jumlah_jp' => 'required|numeric',
            'waktu_pelaksanaan' => 'required',
            'sertifikat' => 'required|mimes:pdf|max:2048'
        ]);
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $data = $request->all();
        if ($request->file('sertifikat')) {
            $filtered = array_filter(
                $data,
                function ($key){
                    if(!in_array($key,['_token', 'id', 'sertifikat'])){
                        return $key;
                    };
                },
                ARRAY_FILTER_USE_KEY
            );
            $image = $request->file('sertifikat');
            $response = Http::withToken($token)->attach('sertifikat', file_get_contents($image), $request->sertifikat->getClientOriginalName())->post($url."/bankom/store", $filtered);
        } else {
            $filtered = array_filter(
                $data,
                function ($key){
                    if(!in_array($key,['_token', 'id'])){
                        return $key;
                    };
                },
                ARRAY_FILTER_USE_KEY
            );
            $response = Http::withToken($token)->post($url."/bankom/store", $filtered);
        }
        
        if($response->successful()){
            return response()->json(['status'=> 'Berhasil Menambah Data']);
        }else{
            return response()->json(['status'=> 'Berhasil Menambah Data']);
        }
    }

    public function show($params){
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/bankom/show/".$params);
        return $response;
    }

    public function update($params,Request $request){
        $request->validate([
            'nama_pelatihan' => 'required|string',
            'jenis_pelatihan' => 'required',
            'jumlah_jp' => 'required|numeric',
            'waktu_pelaksanaan' => 'required',
            'sertifikat' => 'mimes:pdf|max:2048'
        ]);
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $data = $request->all();
        if ($request->file('sertifikat')) {
            $filtered = array_filter(
                $data,
                function ($key){
                    if(!in_array($key,['_token', 'id', 'sertifikat'])){
                        return $key;
                    };
                },
                ARRAY_FILTER_USE_KEY
            );
            $image = $request->file('sertifikat');
            $response = Http::withToken($token)->attach('sertifikat', file_get_contents($image), $request->sertifikat->getClientOriginalName())->post($url."/bankom/update/".$params, $filtered);
        } else {
            $filtered = array_filter(
                $data,
                function ($key){
                    if(!in_array($key,['_token', 'id'])){
                        return $key;
                    };
                },
                ARRAY_FILTER_USE_KEY
            );
            $response = Http::withToken($token)->post($url."/bankom/update/".$params, $filtered);
        }
        
        if($response->successful()){
            return response()->json(['status'=> 'Berhasil Menambah Data']);
        }else{
            return response()->json(['status'=> 'Berhasil Menambah Data']);
        }
    }

    public function delete(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->delete($url."/bankom/delete/".$id);
      
        return $response;
    }
}
