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
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        if ($request->ajax()) {
            $response = Http::withToken($token)->get($url . "/pegawai/list");
            $data = $response->json();
            return $data;
        }

        $page_title = 'Pegawai';
        $page_description = 'Daftar Pegawai';
        $breadcumb = ['Daftar Pegawai'];
        $pangkat = Http::withToken($token)->get($url . "/pegawai/get-option-pangkat-golongan")->collect();
        $agama = Http::withToken($token)->get($url . "/pegawai/get-option-agama")->collect();
        $status_kawin = Http::withToken($token)->get($url . "/pegawai/get-option-status-kawin")->collect();
        $pendidikan = Http::withToken($token)->get($url . "/pegawai/get-option-pendidikan-terakhir")->collect();
        $status_pegawai = Http::withToken($token)->get($url . "/pegawai/get-option-status-pegawai")->collect();
        $eselon = Http::withToken($token)->get($url . "/pegawai/get-option-status-eselon")->collect();
        $jabatan_data = Http::withToken($token)->get($url . "/jabatan/list")->collect();
        $role = session()->get('user.role');

        $jabatan = collect($jabatan_data['data'])->filter(function ($item) use ($request) {
            // if($item['id'] == $request->session()->get('user_details.id_satuan_kerja')){
            if ($item['id_satuan_kerja'] == '1') {
                return $item;
            }
        })->values();
        // dd($jabatan);

        if ($role == 'super_admin') {
            $datadinas = Http::withToken($token)->get($url . "/satuan_kerja/list");
            $dinas = $datadinas->collect('data');
        } else {
            $dinas = session()->get('user.current.pegawai.id_satuan_kerja');
            // $datadinas = Http::withToken($token)->get($url . "/satuan_kerja/show/" . session()->get('user.current.pegawai.id_satuan_kerja'));
            // $dinas = $datadinas->collect('data');
        }

        return view('pages.admin.pegawai.index', compact('page_title', 'page_description', 'breadcumb', 'dinas', 'pangkat', 'agama', 'status_kawin', 'pendidikan', 'status_pegawai', 'eselon', 'jabatan', 'role'));
    }

    public function pegawai_by_satuan_kerja(Request $request, $id_dinas)
    {
        // return "ok";
        // $id_satker = request('satker');
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = array();

        $data = Http::withToken($token)->get($url . "/pegawai/listBySatuanKerja/" . $id_dinas);

        return $data;
    }

    public function store(Request $request)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $data = $request->all();
        // return $data;
        if ($request->tempat_lahir != null && $request->tgl_lahir != null) {
            $data['tempat_tanggal_lahir'] = $request->tempat_lahir . ',' . $request->tgl_lahir;
        }
        $filtered = array_filter(
            $data,
            function ($key) {
                if (!in_array($key, ['_token', 'id'])) {
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        // return $filtered;

        $response = Http::withToken($token)->post($url . "/pegawai/store", $filtered);
        if ($response->successful()) {
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json([
                    'success' => 'Berhasil Menambah Data',
                    'data' => $response->json()
                ]);
            } else {
                return response()->json(['invalid' => $response->json()]);
            }
        } else {
            return response()->json(['failed' => $response->json()]);
        }
    }

    public function show(Request $request, $id)
    {
        // return $id;
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->get($url . "/pegawai/show/" . $id);
        if ($response->successful()) {
            return array('success' => true, 'data' => $response->object()->data);
        } else {
            return response()->json(['failed' => $response->json()]);
        }
    }

    public function update(Request $request, $id)
    {
        // return $id;
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $data = $request->all();
        // return $data;
        // if ($request->tempat_lahir != null && $request->tgl_lahir != null) {
        //     $data['tempat_tanggal_lahir'] = $request->tempat_lahir.','.$request->tgl_lahir;
        // }
        $filtered = array_filter(
            $data,
            function ($key) {
                if (!in_array($key, ['_token', 'id'])) {
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        // $d

        $response = Http::withToken($token)->post($url . "/pegawai/update/" . $id, $filtered);
        if ($response->successful()) {
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json([
                    'success' => 'Berhasil Menambah Data',
                    'data' => $response->json()
                ]);
            } else {
                return response()->json(['invalid' => $response->json()]);
            }
        } else {
            return $response->body();
            return response()->json(['failed' => $response->body()]);
        }
    }

    public function delete(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->delete($url . "/pegawai/delete/" . $id);
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->json()
            ]);
        }

        return response()->json(['error' => true]);
    }

    public function reset_password(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url . "/pegawai/reset-password/" . $id);

        // return $response;
        if ($response->successful()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => true]);
    }
}
