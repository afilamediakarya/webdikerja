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
        $atasan = Http::withToken($token)->get($url . "/atasan/option-atasan")->collect();
        $pangkat = Http::withToken($token)->get($url . "/pegawai/get-option-pangkat-golongan")->collect();
        $agama = Http::withToken($token)->get($url . "/pegawai/get-option-agama")->collect();
        $status_kawin = Http::withToken($token)->get($url . "/pegawai/get-option-status-kawin")->collect();
        $pendidikan = Http::withToken($token)->get($url . "/pegawai/get-option-pendidikan-terakhir")->collect();
        $status_pegawai = Http::withToken($token)->get($url . "/pegawai/get-option-status-pegawai")->collect();
        $eselon = Http::withToken($token)->get($url . "/pegawai/get-option-status-eselon")->collect();
        $jabatan_data = Http::withToken($token)->get($url . "/jabatan/list")->collect();

        $pegawai_id = session()->get('user.current.id_pegawai');


        $data_ = Http::withToken($token)->get($url . "/pegawai/show/" . $pegawai_id)['data'];

        $jabatan = collect($jabatan_data['data'])->filter(function ($item) use ($request) {

            // if($item['id'] == $request->session()->get('user_details.id_satuan_kerja')){
            if ($item['id_satuan_kerja'] == '1') {
                return $item;
            }
        })->values();
        // $datadinas = $request->session()->get('user_details.nama_satuan_kerja');
        $datadinas = [
            "id" => $request->session()->get('user_details.id_satuan_kerja'),
            "nama_satuan_kerja" => $request->session()->get('user_details.nama_satuan_kerja'),
        ];
        $dinas = collect([$datadinas]);
        // dd($dinas);
        $page_title = 'Akun';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Detail Akun'];
        return view(
            'pages.akun.index',
            compact(
                'page_title',
                'page_description',
                'breadcumb',
                'atasan',
                'pangkat',
                'agama',
                'status_kawin',
                'pendidikan',
                'status_pegawai',
                'eselon',
                'jabatan',
                'dinas',
                'data_'
            )
        );
    }

    public function update_atasan(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url . "/atasan/store", [
            'id_penilai' => $id
        ])->json();
        if ($response['status'] == true) {
            session(['atasan' => $response['data']['penilai']]);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'data' => $response->json()]);
        }
    }

    public function bantuan()
    {
        $page_title = 'Bantuan';
        $page_description = 'Bantuan, FAQ & Kontak';
        $breadcumb = ['Faq & Kontak'];
        return view('pages.akun.bantuan', compact('page_title', 'page_description', 'breadcumb'));
    }

    public function change_password(Request $request)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $data = $request->all();

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

        $response = Http::withToken($token)->post($url . "/change-password", $filtered);
        if ($response->successful()) {
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json(['success' => 'Berhasil Ubah Password']);
            } else {
                return response()->json(['invalid' => $response->json()]);
            }
        } else {
            return response()->json(['failed' => $response->json()]);
        }
    }
}
