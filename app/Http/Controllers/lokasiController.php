<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class lokasiController extends Controller
{

    public function getSatuanKerja(){
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/satuan_kerja/list");
        return $response['data'];
    }

    public function index(Request $request){
        $page_title = 'Master';
        $page_description = 'Daftar Lokasi';
        $breadcumb = ['Daftar Lokasi'];
        $url = env('API_URL');
        $token = session()->get('user.access_token');

        if($request->ajax()){
            $response = Http::withToken($token)->get($url."/lokasi/list");
            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }else{
                return 'err';
            }
        }

        $satuan_kerja = $this->getSatuanKerja();
        return view('pages.admin.master.lokasi',compact('page_title', 'page_description','breadcumb','satuan_kerja'));
    }

    public function store(Request $request){
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
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

        $response = Http::withToken($token)->post($url."/lokasi/store", $filtered);
        // return $response;
        if($response->successful()){
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json(['success'=> 'Berhasil Menambah Data']);
            } else {
                return response()->json(['invalid'=> $response->json()]);
            }
        }else{
            return response()->json(['invalid'=> $response->json()]);
        }
    }

    public function show($params){
        // return $params;
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/lokasi/show/".$params);
   
        if($response->successful()){
            return response()->json(['success'=> $response->json()]);
        }else{
            return response()->json(['failed'=> $response->json()]);
        }
    }

    public function update(Request $request,$id){
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
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

        $response = Http::withToken($token)->post($url."/lokasi/update/".$id, $filtered);
        // return $response;
        if($response->successful()){
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json(['success'=> 'Berhasil Menambah Data']);
            } else {
                return response()->json(['invalid'=> $response->json()]);
            }
        }else{
            return response()->json(['invalid'=> $response->json()]);
        }
    }

    public function delete(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->delete($url."/lokasi/delete/".$id);
        if($response->successful()){
            return response()->json(['success'=> 'Meghapus Data']);
        }
     
        return response()->json(['error'=> 'Error Hapus Data']);
    }


}
