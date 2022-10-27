<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use function GuzzleHttp\Promise\all;

class ProfileController extends Controller
{
    public function index()
    {
        $page_title = 'Profile';
        $page_description = '
        Profile Pegawai';
        $breadcumb = ['Profile Pegawai'];

        $url = env('API_URL');
        $image_url = env('IMG_URL');
        $token = session()->get('user.access_token');

        $personalData = Http::withToken($token)->get($url . "/profile/personal-data/");
        $listPendidikan = Http::withToken($token)->get($url . "/profile/get-list-pendidikan/")->collect();
        $listGolongan = Http::withToken($token)->get($url . "/profile/get-list-golongan/")->collect();
        $listUnitkerja = Http::withToken($token)->get($url . "/profile/get-list-unitkerja/")->collect();
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

        return view('pages.Profile.index', compact('page_title', 'page_description', 'breadcumb', 'personalData', 'listPendidikan', 'listGolongan', 'listUnitkerja','image_url'));
    }

    // pendidikan formal
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

        $imagePath = $request->file('foto_ijazah')->store('public/ijazah');

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
        $filtered["foto_ijazah"] = substr($imagePath,14);
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

        if (request('foto_ijazah')) {
            Storage::delete(request('document'));
            $imagePath = $request->file('foto_ijazah')->store('public/ijazah');
            $filtered["foto_ijazah"] = substr($imagePath,14);
        }

        $response = Http::withToken($token)
            ->post($url . "/profile/update-pendidikan-formal/$id", $filtered);
        // $image = $request->file('foto_ijazah');
        // $response = Http::withToken($token)->attach('foto_ijazah', file_get_contents($image), $request->foto_ijazah->getClientOriginalName())->post($url . "/profile/update-pendidikan-formal/$id", $filtered);

        // return $response;

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
            Storage::delete($response['data']['document_formal']);

            return response()->json([
                'success' => 'Meghapus Data',
                'data' => $data
            ]);
        }

        return response()->json(['error' => 'Error Hapus Data']);
    }
    // end pendidikan formal

    // pendidikan non fromal
    public function listPendidikanNonFormal()
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url . "/profile/list-pendidikan-nonformal");
        if ($response->successful()) {
            $data = $response->json();
            return $data;
        } else {
            return 'err';
        }
    }

    public function storePendidikanNonFormal(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'foto_ijazah' => 'required|max:10000|mimes:jpeg,bmp,png,gif,svg,pdf',
        ]);

        if ($validator->fails()) {
            return response()->json(['invalid' => $validator->errors()]);
        }

        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');

        $data = $request->all();
        $imagePath = $request->file('foto_ijazah')->store('public/ijazah');

        $filtered = array_filter(
            $data,
            function ($key) {
                if (!in_array($key, ['_token', 'id'])) {
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        // $image = $request->file('foto_ijazah');
        // $response = Http::withToken($token)->attach('foto_ijazah', file_get_contents($image), $request->foto_ijazah->getClientOriginalName())->post($url."/profile/store-pendidikan-nonformal", $filtered);

        $filtered["foto_ijazah"] = substr($imagePath,14);
        $response = Http::withToken($token)
        ->post($url . "/profile/store-pendidikan-nonformal", $filtered);

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

    public function getPendidikanNonFormal(Request $request, $id)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $data = Http::withToken($token)->get($url . "/profile/get-pendidikan-nonformal/" . $id);

        return $data;
    }

    public function updatePendidikanNonFormal(Request $request)
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
            $imagePath = $request->file('foto_ijazah')->store('public/ijazah');
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

        $filtered["foto_ijazah"] = substr($imagePath,14);
        $response = Http::withToken($token)
            ->post($url . "/profile/update-pendidikan-nonformal/$id", $filtered);


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

    public function deletePendidikanNonFormal(Request $request, $id)
    {

        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');

        $response = Http::withToken($token)->delete($url . "/profile/delete-pendidikan-nonformal/$id");
        $data = $response->object();

        if ($response->successful()) {
            // delete file
            Storage::delete($response['data']['document_nonformal']);

            return response()->json([
                'success' => 'Meghapus Data',
                'data' => $data
            ]);
        }

        return response()->json(['error' => 'Error Hapus Data']);
    }
    // end pendidikan non formal

    // kepangkatan
    public function listKepangkatan()
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url . "/profile/list-kepangkatan");
        if ($response->successful()) {
            $data = $response->json();
            return $data;
        } else {
            return 'err';
        }
    }

    public function storeKepangkatan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sk_pangkat' => 'required|max:10000|mimes:jpeg,bmp,png,gif,svg,pdf',
        ]);

        if ($validator->fails()) {
            return response()->json(['invalid' => $validator->errors()]);
        }

        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');

        $data = $request->all();

        // $imagePath = $request->file('sk_pangkat')->store('sk');
        $imagePath = $request->file('sk_pangkat')->store('public/sk_pangkat');

        $filtered = array_filter(
            $data,
            function ($key) {
                if (!in_array($key, ['_token', 'id'])) {
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );
        $filtered["bulan_kerja"] = date('m', strtotime(request('bulan_kerja')));
        $filtered["gaji_pokok"] = intval(preg_replace('/([^0-9\/+]+)/', '', request('gaji_pokok')));

        $filtered["sk_pangkat"] = substr($imagePath,17);
        $response = Http::withToken($token)
            ->post($url . "/profile/store-kepangkatan", $filtered);

        // $image = $request->file('sk_pangkat');
        // $response = Http::withToken($token)->attach('sk_pangkat', file_get_contents($image), $request->sk_pangkat->getClientOriginalName())->post($url."/profile/store-kepangkatan", $filtered);

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

    public function getKepangkatan(Request $request, $id)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $data = Http::withToken($token)->get($url . "/profile/get-kepangkatan/" . $id);

        return $data;
    }

    public function updateKepangkatan(Request $request)
    {
        $id = request('id');
        $imagePath = '';

        $validator = Validator::make($request->all(), [
            'sk_pangkat' => 'max:10000|mimes:jpeg,bmp,png,gif,svg,pdf',
        ]);

        if ($validator->fails()) {
            return response()->json(['invalid' => $validator->errors()]);
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

        if (request('sk_pangkat')) {
            Storage::delete(request('document'));
            $imagePath = $request->file('sk_pangkat')->store('public/sk_pangkat');
            $filtered["sk_pangkat"] = substr($imagePath,17);
        }

        $filtered["bulan_kerja"] = date('m', strtotime(request('bulan_kerja')));
        $filtered["gaji_pokok"] = intval(preg_replace('/([^0-9\/+]+)/', '', request('gaji_pokok')));


        $response = Http::withToken($token)
            ->post($url . "/profile/update-kepangkatan/$id", $filtered);

        // $image = $request->file('sk_pangkat');
        // $response = Http::withToken($token)->attach('sk_pangkat', file_get_contents($image), $request->sk_pangkat->getClientOriginalName())->post($url."/profile/update-kepangkatan/$id", $filtered);

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

    public function deleteKepangkatan(Request $request, $id)
    {

        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');

        $response = Http::withToken($token)->delete($url . "/profile/delete-kepangkatan/$id");
        $data = $response->object();

        if ($response->successful()) {
            // delete file
            Storage::delete($response['data']['document_kepangkatan']);

            return response()->json([
                'success' => 'Meghapus Data',
                'data' => $data
            ]);
        }

        return response()->json(['error' => 'Error Hapus Data']);
    }
    // end kepangkatan

    // jabatan
    public function listJabatan()
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url . "/profile/list-jabatan");
        if ($response->successful()) {
            $data = $response->json();
            return $data;
        } else {
            return 'err';
        }
    }

    public function storeJabatan(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'sk_jabatan' => 'required|max:10000|mimes:jpeg,bmp,png,gif,svg,pdf',
        ]);

        if ($validator->fails()) {
            return response()->json(['invalid' => $validator->errors()]);
        }

        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');

        $data = $request->all();

        // $imagePath = $request->file('sk_jabatan')->store('sk');
        $imagePath = $request->file('sk_jabatan')->store('public/sk_jabatan');

        $filtered = array_filter(
            $data,
            function ($key) {
                if (!in_array($key, ['_token', 'id'])) {
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        $filtered["sk_jabatan"] = substr($imagePath,18);

        $response = Http::withToken($token)
            ->post($url . "/profile/store-jabatan", $filtered);

        // $image = $request->file('sk_jabatan');
        // $response = Http::withToken($token)->attach('sk_jabatan', file_get_contents($image), $request->sk_jabatan->getClientOriginalName())->post($url."/profile/store-jabatan", $filtered);

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

    public function getJabatan(Request $request, $id)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $data = Http::withToken($token)->get($url . "/profile/get-jabatan/" . $id);

        return $data;
    }

    public function updateJabatan(Request $request)
    {
        $id = request('id');
        $imagePath = '';

        $validator = Validator::make($request->all(), [
            'sk_jabatan' => 'max:10000|mimes:jpeg,bmp,png,gif,svg,pdf',
        ]);

        if ($validator->fails()) {
            return response()->json(['invalid' => $validator->errors()]);
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

        if (request('sk_jabatan')) {
            Storage::delete(request('sk_jabatan'));
            $imagePath = $request->file('sk_jabatan')->store('public/sk_jabatan');
            $filtered["sk_jabatan"] = substr($imagePath,18);
        }

        $response = Http::withToken($token)
            ->post($url . "/profile/update-jabatan/$id", $filtered);

        // $image = $request->file('sk_jabatan');
        // $response = Http::withToken($token)->attach('sk_jabatan', file_get_contents($image), $request->sk_jabatan->getClientOriginalName())->post($url."/profile/update-jabatan/$id", $filtered);

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

    public function deleteJabatan(Request $request, $id)
    {

        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');

        $response = Http::withToken($token)->delete($url . "/profile/delete-jabatan/$id");
        $data = $response->object();

        if ($response->successful()) {
            // delete file
            Storage::delete($response['data']['document_jabatan']);

            return response()->json([
                'success' => 'Meghapus Data',
                'data' => $data
            ]);
        }

        return response()->json(['error' => 'Error Hapus Data']);
    }
    // end jabatan
}
