<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class JadwalController extends Controller
{
    //
    public function index(Request $request)
    {
        $page_title = 'Jadwal';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Jadwal Kegiatan'];

        if($request->ajax()){
            $url = env('API_URL');
            $token = $request->session()->get('user.access_token');
            $response = Http::withToken($token)->get($url."/jadwal/list");
            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }else{
                return 'err';
            }
        }

        return view('pages.admin.jadwal.index', compact('page_title', 'page_description','breadcumb'));
    }

    public function store(Request $request)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url."/jadwal/store", [
            'nama_kegiatan' => $request->nama_kegiatan,
            'nama_sub_kegiatan' => $request->nama_sub_kegiatan,
            'tanggal_awal' => date("Y-m-d", strtotime($request->tanggal_awal)),
            'tanggal_akhir' => date("Y-m-d", strtotime($request->tanggal_akhir)),
        ]);
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
        $response = Http::withToken($token)->get($url."/jadwal/show/".$id);
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
        $response = Http::withToken($token)->post($url."/jadwal/update/".$id, [
            'nama_kegiatan' => $request->nama_kegiatan,
            'nama_sub_kegiatan' => $request->nama_sub_kegiatan,
            'tanggal_awal' => date("Y-m-d", strtotime($request->tanggal_awal)),
            'tanggal_akhir' => date("Y-m-d", strtotime($request->tanggal_akhir)),
        ]);
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
        $response = Http::withToken($token)->delete($url."/jadwal/delete/".$id);
        if($response->successful()){
            return response()->json(['success'=> 'Meghapus Data']);
        }
     
        return response()->json(['error'=> 'Error Hapus Data']);
    }
}
