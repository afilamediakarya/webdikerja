<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;
class AxiosController extends Controller
{
    //
    public function index(Request $request)
    {
        $url = env('API_URL');
        $page_title = 'Jabatan';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Jabatan'];
        $token = $request->session()->get('user.access_token');
        $datakelas = Http::withToken($token)->get($url."/kelas_jabatan/get-option-kelas-jabatan");
        $kelas = $datakelas->json();
        $datadinas = Http::withToken($token)->get($url."/satuan_kerja/list");
        $dinas = $datadinas->collect('data');
        // return $request->session()->get('user_details.satuan_kerja');
        // dd($dinas);
        if($request->session()->get('user.role') == 'admin_opd'){
            $collection = $dinas->map(function ($val) use($request) {
                return $val;
            })->reject(function ($val) use($request) {
                return $val['id'] <> $request->session()->get('user_details.id_satuan_kerja') ;
            });
            $dinas = $collection;
        }


        if($request->ajax()){
            $response = Http::withToken($token)->get($url."/jabatan/list");
            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }else{
                return 'err';
            }
        }

        return view('pages.admin.jabatan.index', compact('page_title', 'page_description','breadcumb', 'kelas', 'dinas'));
    }

    public function atasan_jabatan(Request $request, $id, $satuan)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        // $response = Http::withToken($token)->get($url."/jabatan/get-option-jabatan-atasan/2");

        $response = Http::withToken($token)->get($url."/jabatan/get-option-jabatan-atasan/".$id."/".$satuan);
        // return $response->body();
        if($response->successful()){
            return response()->json(['success'=> $response->json()]);
        }else{
            return response()->json(['failed'=> $response->json()]);
        }
    }

}
