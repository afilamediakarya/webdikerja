<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class AkunController extends Controller
{
    //
    public function index(Request $request)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $atasan = Http::withToken($token)->get($url."/atasan/option-atasan")->collect();
        $pangkat = Http::withToken($token)->get($url."/pegawai/get-option-pangkat-golongan")->collect();
        $agama = Http::withToken($token)->get($url."/pegawai/get-option-agama")->collect();
        $status_kawin = Http::withToken($token)->get($url."/pegawai/get-option-status-kawin")->collect();
        $pendidikan = Http::withToken($token)->get($url."/pegawai/get-option-pendidikan-terakhir")->collect();
        $status_pegawai = Http::withToken($token)->get($url."/pegawai/get-option-status-pegawai")->collect();
        $eselon = Http::withToken($token)->get($url."/pegawai/get-option-status-eselon")->collect();
        $jabatan_data = Http::withToken($token)->get($url."/jabatan/list")->collect();
        $jabatan = collect($jabatan_data['data'])->filter(function($item) use($request){
            // if($item['id'] == $request->session()->get('user_details.id_satuan_kerja')){
            if($item['id_satuan_kerja'] == '1'){
                return $item;
            }
        })->values();
        // dd($atasan);
        $datadinas = $request->session()->get('user_details.satuan_kerja');
        $dinas = collect([$datadinas]);
        $page_title = 'Akun';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Detail Akun'];
        return view('pages.akun.index', 
                compact(
                    'page_title', 
                    'page_description',
                    'breadcumb', 
                    'atasan', 
                    'pangkat', 'agama', 'status_kawin', 'pendidikan', 'status_pegawai', 'eselon', 'jabatan', 'dinas'));
    }

    public function update_atasan(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url."/atasan/store", [
            'id_penilai' => $id
        ])->json();
        if($response['status'] == true){
            session(['atasan' => $response['data']['penilai']]);
            return response()->json(['success'=> true]);
        }else{
            return response()->json(['success'=> false, 'data'=> $response->json()]);
        }
    }

}
