<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;
class JabatanController extends Controller
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
        $pegawai = Http::withToken($token)->get($url."/jabatan/pegawaiBySatuanKerja")->collect();
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

        return view('pages.admin.jabatan.index', compact('page_title', 'page_description','breadcumb', 'kelas', 'dinas', 'pegawai'));
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

        $response = Http::withToken($token)->post($url."/jabatan/store", $filtered);
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
        $response = Http::withToken($token)->get($url."/jabatan/show/".$id);
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

        $response = Http::withToken($token)->post($url."/jabatan/update/".$id, $filtered);
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
        $response = Http::withToken($token)->delete($url."/jabatan/delete/".$id);
        if($response->successful()){
            return response()->json(['success'=> 'Meghapus Data']);
        }
     
        return response()->json(['error'=> 'Error Hapus Data']);
    }



    public function kelas(Request $request)
    {
        $page_title = 'Jabatan';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Jabatan'];

        if($request->ajax()){
            $url = env('API_URL');
            $token = $request->session()->get('user.access_token');
            $response = Http::withToken($token)->get($url."/kelas_jabatan/list");
            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }else{
                return 'err';
            }
        }

        return view('pages.admin.jabatan.kelas-jabatan', compact('page_title', 'page_description','breadcumb'));
    }

    public function store_kelas(Request $request)
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

        $response = Http::withToken($token)->post($url."/kelas_jabatan/store", $filtered);
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

    public function show_kelas(Request $request, $id){
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/kelas_jabatan/show/".$id);
        if($response->successful()){
            return response()->json(['success'=> $response->json()]);
        }else{
            return response()->json(['failed'=> $response->json()]);
        }
        
    }

    public function update_kelas(Request $request, $id)
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

        $response = Http::withToken($token)->post($url."/kelas_jabatan/update/".$id, $filtered);
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

    public function delete_kelas(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->delete($url."/kelas_jabatan/delete/".$id);
        if($response->successful()){
            return response()->json(['success'=> 'Meghapus Data']);
        }
     
        return response()->json(['error'=> 'Error Hapus Data']);
    }


    public function getAtasan(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        // $response = Http::withToken($token)->get($url."/jabatan/get-option-jabatan-atasan/2");

        $response = Http::withToken($token)->get($url."/jabatan/get-option-jabatan-atasan/".$id);
        // return $response->body();
        // dd($response->body());
        if($response->successful()){
            return response()->json(['success'=> $response->json()]);
        }else{
            return response()->json(['failed'=> $response->json()]);
        }
    }

}
