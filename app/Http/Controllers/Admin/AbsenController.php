<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsenController extends Controller
{

    public function datatable_()
    {
        //  return $satuan_kerja.' / '.$tanggal.' / '.$valid;
        $satuan_kerja = request('satuan_kerja');
        $tanggal = request('tanggal');
        $valid = request('valid');
        $status = request('status');

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url . "/absen/list-filter-absen?satuan_kerja=" . $satuan_kerja . "&tanggal=" . $tanggal . "&valid=" . $valid . '&status=' . $status);
        $data = $response->json();
        return $data;
    }

    public function index()
    {
        $url = env('API_URL');
        $page_title = 'Absen';
        $page_description = 'Daftar Kehadiran Pegawai';
        $breadcumb = ['Daftar Kehadiran Pegawai'];
        $token = session()->get('user.access_token');
        $role = session()->get('user.role');

        if ($role == 'super_admin') {
            $satker = Http::withToken($token)->get($url . "/satuan_kerja/list");
            $satker = $satker->collect('data');
            return view('pages.admin.absen.index', compact('satker', 'url', 'page_title', 'page_description', 'breadcumb', 'role'));
        } else {
            $satker = session()->get('user.current.id_satuan_kerja');
            return view('pages.admin.absen.index_opd', compact('url', 'page_title', 'page_description', 'breadcumb', 'role', 'satker'));
        }
    }

    public function checkAbsen($id_pegawai, $tanggal)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $result = Http::withToken($token)->get($url . "/absen/check-absen-admin/" . $id_pegawai . "/" . $tanggal);
        return $result;
    }

    public function store(Request $request)
    {

        if ($request->jenis == 'checkin') {
            $validated = $request->validate([
                'satuan_kerja' => 'required',
                'jenis' => 'required',
                'pegawai' => 'required',
                'status' => 'required',
                'tanggal' => 'required',
                'waktu_absen' => 'required',
            ]);
        } else {
            $validated = $request->validate([
                'satuan_kerja' => 'required',
                'jenis' => 'required',
                'pegawai' => 'required',
                'tanggal' => 'required',
                'waktu_absen' => 'required',
            ]);
        }

        $checkAbsen = $this->checkAbsen($request->pegawai, $request->tanggal);

        if ($request->jenis == 'checkin') {
            if ($checkAbsen['checkin'] !== true) {
                return $this->create_absen($request);
            } else {
                return response()->json(['fails' => 'Maaf pegawai tersebut sudah absen masuk']);
            }
        } else {
            if ($checkAbsen['checkout'] !== true) {
                if ($checkAbsen['checkin'] !== true) {
                    return response()->json(['fails' => 'Maaf pegawai tersebut belum absen masuk']);
                } else {
                    return $this->create_absen($request);
                }
            } else {
                return response()->json(['fails' => 'Maaf pegawai tersebut sudah absen pulang']);
            }
        }
    }

    public function create_absen($request)
    {

        $filtered = array();
        $users_id = session()->get('user.current.id');
        $validate_ = 0;
        $status = '';

        if ($request->jenis == 'checkout') {
            $checkAbsen = $this->checkAbsen($request->pegawai, $request->tanggal);
            if ($checkAbsen['status'] == 'hadir' || $checkAbsen['status'] == 'apel') {
                $validate_ = 1;
            } else {
                $validate_ = 0;
            }
            $status = 'hadir';
        } else {
            $status = $request->status;

            if ($status == 'hadir' || $status == 'apel') {
                $validate_ = 1;
            } elseif ($status == 'dinas luar' || $status == 'izin' || $status == 'sakit') {
                $validate_ = 0;
            }
        }

        $filtered = [
            'id_pegawai' => $request->pegawai,
            'waktu_absen' => $request->waktu_absen,
            'tanggal_absen' => $request->tanggal,
            'status' => $status,
            'jenis' => $request->jenis,
            'location_auth' => 'invalid',
            'face_auth' => 'invalid',
            'tahun' => date('Y'),
            'user_update' => $users_id,
            'validation' => $validate_
        ];

        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $response = Http::withToken($token)->post($url . "/absen/store", $filtered);

        if ($response->successful()) {
            return response()->json(['success' => $response->json()]);
        } else {
            return response()->json(['failed' => $response->json()]);
        }
    }

    public function show($pegawai, $tanggal, $valid)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url . "/absen/show/" . $pegawai . "/" . $tanggal . "/" . $valid);
        if ($response->successful()) {
            return response()->json(['success' => $response['data']]);
        } else {
            return response()->json(['failed' => $response->json()]);
        }
    }

    public function update(Request $request, $params)
    {

        $validated = $request->validate([
            'satuan_kerja' => 'required',
            'pegawai' => 'required',
            'status' => 'required',
            'tanggal' => 'required',
            'waktu_absen_masuk' => 'required',
            'waktu_absen_pulang' => 'required',
        ]);


        $checkAbsen = $this->checkAbsen($request->pegawai, $request->tanggal);
        if ($checkAbsen['checkout'] == false) {
            return response()->json(['fails' => 'Maaf pegawai tersebut belum absen pulang']);
        } else {
            $filtered = array();
            $users_id = session()->get('user.current.id');
            $validate_ = 0;
            if ($request->status == 'hadir' || $request->status == 'apel') {
                $validate_ = 1;
            } elseif ($request->status == 'dinas luar' || $request->status == 'izin' || $request->status == 'sakit') {
                $validate_ = 0;
            }
            $filtered = [
                'id_pegawai' => $request->pegawai,
                'waktu_absen' => $request->waktu_absen,
                'tanggal_absen' => $request->tanggal,
                'status' => $request->status,
                'location_auth' => 'invalid',
                'face_auth' => 'invalid',
                'tahun' => date('Y'),
                'user_update' => $users_id,
                'validation' => $validate_,
                'waktu_absen_masuk' => $request->waktu_absen_masuk,
                'waktu_absen_pulang' => $request->waktu_absen_pulang,
            ];

            $url = env('API_URL');
            $token = session()->get('user.access_token');

            $response = Http::withToken($token)->post($url . "/absen/update/" . $params, $filtered);
            if ($response->successful()) {
                return response()->json(['success' => $response->json()]);
            } else {
                return response()->json(['failed' => $response->json()]);
            }
        }
    }

    public function change_validation(Request $request)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
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

        $response = Http::withToken($token)->post($url . "/absen/change-validation", $filtered);

        if ($response->successful()) {
            return response()->json(['success' => $response->json()]);
        } else {
            return response()->json(['failed' => $response->json()]);
        }
    }
}
