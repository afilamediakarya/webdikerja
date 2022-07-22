<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsenController extends Controller
{

    public function datatable_($satuan_kerja,$tanggal,$valid){
        //  return $satuan_kerja.' / '.$tanggal.' / '.$valid;
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/absen/list-filter-absen/".$satuan_kerja."/".$tanggal."/".$valid);
        // return $response;
        $data = $response->json();
        return $data;
    }

    public function index(){
        $url = env('API_URL');
        $page_title = 'Absen';
        $page_description = 'Daftar Absen Pegawai';
        $breadcumb = ['Daftar Absen Pegawai'];
        $token = session()->get('user.access_token');
        $satker = Http::withToken($token)->get($url."/satuan_kerja/list");
        $satker = $satker->collect('data');
        return view('pages.admin.absen.index',compact('satker','url','page_title','page_description','breadcumb'));
    }

    public function store(Request $request){   
        // return $request->all();
        $validated = $request->validate([
            'satuan_kerja' => 'required',
            'jenis' => 'required',
            'pegawai' => 'required',
            'status' => 'required',
            'tanggal' => 'required',
            'waktu_absen' => 'required',
        ]);   
        
        $filtered = array();
        $users_id = session()->get('user.current.id');
        $validate_ = 0;

        if ($request->jenis == 'hadir' || $request->jenis == 'apel') {
            $validate_ = 1;
        }elseif ($request->jenis == 'dinas luar' || $request->jenis == 'izin' || $request->jenis == 'sakit') {
            $validate_ = 0;
        }

        $filtered = [
            'id_pegawai' => $request->pegawai,
            'waktu_absen' => $request->waktu_absen,
            'tanggal_absen' => $request->tanggal,
            'status' => $request->status,
            'jenis' => $request->jenis,
            'location_auth' => 'invalid',
            'face_auth' => 'invalid',
            'tahun' => date('Y'),
            'user_update' => $users_id,
            'validation' => $validate_
        ];

        $url = env('API_URL');
        $token = session()->get('user.access_token');
    
        $response = Http::withToken($token)->post($url."/absen/store", $filtered);
        if($response->successful()){
            return response()->json(['success'=> $response->json()]);
        }else{
            return response()->json(['failed'=> $response->json()]);
        }
    }

    public function show($pegawai, $tanggal, $valid){
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/pegawai/show/".$id);
        if($response->successful()){
            return array('success'=> true, 'data'=>$response->object()->data);
        }else{
            return response()->json(['failed'=> $response->json()]);
        }
    }
}
