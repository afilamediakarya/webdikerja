<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class InformasiController extends Controller
{
    //
    public function index(Request $request)
    {
        $page_title = 'Informasi';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Informasi'];
        $url_img = env('IMG_URL');
        $satuan_kerja_list = '';
        $role = session()->get('user.role');

        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
     
        if ($role == 'super_admin') {
            $satuan_kerja_list = Http::withToken($token)->get($url."/satuan_kerja/list")['data'];
        }

        // return $satuan_kerja_list;

        $satuan_kerja = session()->get('user.current.pegawai.id_satuan_kerja');
        if($request->ajax()){
            $response = Http::withToken($token)->get($url."/informasi/list");
            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }else{
                return 'err';
            }
        }

        return view('pages.admin.informasi.index', compact('page_title', 'page_description','breadcumb','satuan_kerja','url_img','role','satuan_kerja_list'));
    }

    public function store(Request $request)
    {

        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $data = $request->all();
        if ($request->file('gambar')) {
            $filtered = array_filter(
                $data,
                function ($key){
                    if(!in_array($key,['_token', 'id', 'gambar'])){
                        return $key;
                    };
                },
                ARRAY_FILTER_USE_KEY
            );
            $image = $request->file('gambar');
            $response = Http::withToken($token)->attach('gambar', file_get_contents($image), $request->gambar->getClientOriginalName())->post($url."/informasi/store", $filtered);
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
            $response = Http::withToken($token)->post($url."/informasi/store", $filtered);
        }
        if($response->successful()){
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json(['success'=> 'Berhasil Menambah Data']);
            } else {
                return response()->json(['invalid'=> $response->json()]);
            }
        }else{
            return response()->json(['failed'=> $response->body()]);
        }
        
    }

    public function show(Request $request, $id){
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/informasi/show/".$id);
        if($response->successful()){
            return response()->json(['success'=> $response->json()]);
        }else{
            return response()->json(['failed'=> $response->json()]);
        }
        
    }

    public function update(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $data = $request->all();
        if ($request->file('gambar')) {
            $filtered = array_filter(
                $data,
                function ($key){
                    if(!in_array($key,['_token', 'id', 'gambar'])){
                        return $key;
                    };
                },
                ARRAY_FILTER_USE_KEY
            );
            $image = $request->file('gambar');
            $response = Http::withToken($token)->attach('gambar', file_get_contents($image), $request->gambar->getClientOriginalName())->post($url."/informasi/update/".$id, $filtered);
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
            $response = Http::withToken($token)->post($url."/informasi/update/".$id, $filtered);
        }
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
        $response = Http::withToken($token)->delete($url."/informasi/delete/".$id);
        if($response->successful()){
            return response()->json(['success'=> 'Meghapus Data']);
        }
     
        return response()->json(['error'=> 'Error Hapus Data']);
    }
}
