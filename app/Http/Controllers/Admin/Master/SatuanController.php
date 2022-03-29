<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Master';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Satuan'];

        if($request->ajax()){
            $url = env('API_URL');
            $token = $request->session()->get('user.access_token');
            $response = Http::withToken($token)->get($url."/satuan/list");
            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }else{
                return 'err';
            }
        }

        return view('pages.admin.master.satuan', compact('page_title', 'page_description','breadcumb'));
    }

    public function store(Request $request)
    {
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

        $response = Http::withToken($token)->post($url."/satuan/store", $filtered);
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
        $response = Http::withToken($token)->get($url."/satuan/show/".$id);
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
        $filtered = array_filter(
            $data,
            function ($key){
                if(!in_array($key,['_token', 'id'])){
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        $response = Http::withToken($token)->post($url."/satuan/update/".$id, $filtered);
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
        $response = Http::withToken($token)->delete($url."/satuan/delete/".$id);
        if($response->successful()){
            return response()->json(['success'=> 'Meghapus Data']);
        }
     
        return response()->json(['error'=> 'Error Hapus Data']);
    }
}
