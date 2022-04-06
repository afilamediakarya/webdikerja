<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $url = env('API_URL');
        $page_title = 'Jabatan';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Jabatan'];
        $token = $request->session()->get('user.access_token');
        $datadinas = Http::withToken($token)->get($url."/satuan_kerja/list");
        $dinas = $datadinas->collect('data');


        if($request->ajax()){
            $response = Http::withToken($token)->get($url."/admin/list");
            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }else{
                return 'err';
            }
        }

        return view('pages.admin.admin.index', compact('page_title', 'page_description','breadcumb', 'dinas'));
    }

    public function getPegawai(Request $request, $id){
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/admin/option-pegawai-satuankerja/".$id);
        if($response->successful()){
            return response()->json(['success'=> $response->json()]);
        }else{
            return response()->json(['failed'=> $response->json()]);
        }
    }

    public function update(Request $request, $id){
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/admin/change-role/".$id);
        if($response->successful()){
            return response()->json(['success'=> $response->json()]);
        }else{
            return response()->json(['failed'=> $response->json()]);
        }
    }

    public function delete(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->delete($url."/admin/change-role/".$id);
        return $response->body();
        if($response->successful()){
            return response()->json(['success'=> 'Meghapus Data']);
        }
        return response()->json(['error'=> 'Error Hapus Data']);
    }
}
