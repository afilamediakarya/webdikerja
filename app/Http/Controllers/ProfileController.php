<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $page_title = 'Profile';
        $page_description = '
        Profile Pegawai';
        $breadcumb = ['Profile Pegawai'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $personalData = Http::withToken($token)->get($url . "/profile/personal-data/");
        $listPendidikan = Http::withToken($token)->get($url . "/profile/get-list-pendidikan/")->collect();
        // return $listPendidikan;
        if ($personalData["code"] !== "200") {

            $personalData = [
                "nama" => "Nama pegawai",
                "nip" => "NIP pegawai",
                "nama_jabatan" => "Jabatan pegawai",
                "nama_satuan_kerja" => "Satuan Kerja pegawai",
            ];
        } else {
            $personalData = $personalData["data"];
        }

        return view('pages.Profile.index', compact('page_title', 'page_description', 'breadcumb', 'personalData', 'listPendidikan'));
    }

    public function listPendidikanFormal()
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url . "/profile/list-pendidikan-formal");
        if ($response->successful()) {
            $data = $response->json();
            return $data;
        } else {
            return 'err';
        }
    }

    public function getPendidikanFormal(Request $request, $id)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $data = Http::withToken($token)->get($url . "/profile/get-pendidikan-formal/" . $id);

        return $data;
    }

    public function storePendidikanFormal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto_ijazah' => 'required|max:10000|mimes:jpeg,bmp,png,gif,svg,pdf',
        ]);

        if ($validator->fails()) {
            return response()->json(['invalid' => $validator->errors()]);
        }

        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');

        $data = $request->all();

        $imagePath = $request->file('foto_ijazah')->store('ijazah');

        $filtered = array_filter(
            $data,
            function ($key) {
                if (!in_array($key, ['_token', 'id'])) {
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        $filtered["foto_ijazah"] = $imagePath;

        $response = Http::withToken($token)
            ->post($url . "/profile/store-pendidikan-formal", $filtered);

        if ($response->successful()) {
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json([
                    'success' => 'Berhasil Menambah Data',
                    'data' => $data
                ]);
            } else {
                return response()->json(['invalid' => $response->json()]);
            }
        } else {
            return response()->json(['failed' => $response->json()]);
        }
    }

    public function updatePendidikanFormal(Request $request)
    {
        $id = request('id');
        $imagePath = '';

        $validator = Validator::make($request->all(), [
            'foto_ijazah' => 'max:10000|mimes:jpeg,bmp,png,gif,svg,pdf',
        ]);

        if ($validator->fails()) {
            return response()->json(['invalid' => $validator->errors()]);
        }

        if (request('foto_ijazah')) {
            Storage::delete(request('document'));
            $imagePath = $request->file('foto_ijazah')->store('ijazah');
        }

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

        $filtered["foto_ijazah"] = $imagePath;

        $response = Http::withToken($token)
            ->post($url . "/profile/update-pendidikan-formal/$id", $filtered);

        if ($response->successful()) {
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json([
                    'success' => 'Berhasil Mengubah Data',
                    'data' => $data
                ]);
            } else {
                return response()->json(['invalid' => $response->json()]);
            }
        } else {
            return response()->json(['failed' => $response->json()]);
        }
    }

    public function deletePendidikanFormal(Request $request, $id)
    {

        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');

        $response = Http::withToken($token)->delete($url . "/profile/delete-pendidikan-formal/$id");
        $data = $response->object();

        if ($response->successful()) {
            // delete file
            Storage::delete($response['data']['document']);

            return response()->json([
                'success' => 'Meghapus Data',
                'data' => $data
            ]);
        }

        return response()->json(['error' => 'Error Hapus Data']);
    }
}
