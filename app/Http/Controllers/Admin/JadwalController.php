<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class JadwalController extends Controller
{
    public function datatable(){
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/jadwal/list");
        if ($response->successful()) {
            $data = $response->json();
            return $data;
        }else{
            return 'err';
        }
    }

    public function index(Request $request)
    {
        $page_title = 'Jadwal';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Jadwal Kegiatan'];

        return view('pages.admin.jadwal.index', compact('page_title', 'page_description','breadcumb'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahapan' => 'required|string',
            'sub_tahapan' => 'required|string',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);  
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url."/jadwal/store", [
            'tahapan' => $request->tahapan,
            'sub_tahapan' => $request->sub_tahapan,
            'tanggal_awal' => date("Y-m-d", strtotime($request->tanggal_awal)),
            'tanggal_akhir' => date("Y-m-d", strtotime($request->tanggal_akhir)),
            'tahun' => session('tahun_penganggaran')
        ]);
        
        if($response->successful()){
            return response()->json(['success'=> $response->json()]);
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
        $validated = $request->validate([
            'tahapan' => 'required|string',
            'sub_tahapan' => 'required|string',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);  
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url."/jadwal/update/".$request->id, [
            'tahapan' => $request->tahapan,
            'sub_tahapan' => $request->sub_tahapan,
            'tanggal_awal' => date("Y-m-d", strtotime($request->tanggal_awal)),
            'tanggal_akhir' => date("Y-m-d", strtotime($request->tanggal_akhir)),
            'tahun' => session('tahun_penganggaran')
        ]);
        
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
        $response = Http::withToken($token)->delete($url."/jadwal/delete/".$id);
        if($response->successful()){
            return response()->json(['success'=> 'Meghapus Data']);
        }
     
        return response()->json(['error'=> 'Error Hapus Data']);
    }
}
