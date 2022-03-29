<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class PegawaiController extends Controller
{
    //

    public function index(Request $request)
    {
        if($request->ajax()){
            $url = env('API_URL');
            $token = $request->session()->get('user.access_token');
            $response = Http::withToken($token)->get($url."/pegawai/list");
            $data = $response->json();
            return $data;
        }

        $page_title = 'Aktivitas';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Aktivitas'];

        return view('pages.admin.pegawai.index', compact('page_title', 'page_description','breadcumb'));
    }

    public function store(Request $request)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $data = $request->all();
        $data['id_satuan_kerja'] = 1;
        if ($request->tempat_lahir != null && $request->tgl_lahir != null) {
            $data['tempat_tanggal_lahir'] = $request->tempat_lahir.','.$request->tgl_lahir;
        }
        $filtered = array_filter(
            $data,
            function ($key){
                if(!in_array($key,['_token', 'id'])){
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        $response = Http::withToken($token)->post($url."/pegawai/store", $filtered);
        if($response->successful()){
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json(['success'=> 'Berhasil Menambah Data']);
            } else {
                return response()->json(['invalid'=> $response->json()]);
            }
        }else{
            return response()->json(['failed'=> $response->json()]);
        }
        
    }

    public function show(Request $request, $id){
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/pegawai/show/".$id);
        if($response->successful()){
            return array('success'=> true, 'data'=>$response->object()->data);
        }else{
            return response()->json(['failed'=> $response->json()]);
        }
        
    }

    public function update(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $data = $request->all();
        $data['id_satuan_kerja'] = 1;
        if ($request->tempat_lahir != null && $request->tgl_lahir != null) {
            $data['tempat_tanggal_lahir'] = $request->tempat_lahir.','.$request->tgl_lahir;
        }
        $filtered = array_filter(
            $data,
            function ($key){
                if(!in_array($key,['_token', 'id'])){
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        $response = Http::withToken($token)->post($url."/pegawai/update/".$id, $filtered);
        if($response->successful()){
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json(['success'=> 'Berhasil Menambah Data']);
            } else {
                return response()->json(['invalid'=> $response->json()]);
            }
        }else{
            return $response->body();
            return response()->json(['failed'=> $response->body()]);
        }
        
    }

    public function delete(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->delete($url."/pegawai/delete/".$id);
        if($response->successful()){
            return response()->json(['success'=> true]);
        }
     
        return response()->json(['error'=> true]);
    }
    
    
}
