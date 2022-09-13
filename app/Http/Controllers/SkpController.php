<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// use Illuminate\Validation\ValidationException;
class SkpController extends Controller
{
    public function checkLevel()
    {
        $level = session()->get('user.level_jabatan');
        return $level;
    }

    public function datatable_skp_tahunan()
    {
        $type = request('type');
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = array();
        $level = $this->checkLevel();

        if ($type == 'tahunan') {
            if ($level == 1 || $level == 2) {
                $data = Http::withToken($token)->get($url . "/skp/list/kepala?tahun=" . session('tahun_penganggaran') . "&type=tahunan");
            } else {
                $data = Http::withToken($token)->get($url . "/skp/list/pegawai?tahun=" . session('tahun_penganggaran') . "&type=tahunan");
            }
        } else {
            if ($level == 1 || $level == 2) {
                $data = Http::withToken($token)->get($url . "/skp/list/kepala?tahun=" . session('tahun_penganggaran') . "&type=bulanan&bulan=" . request('bulan'));
            } else {
                $data = Http::withToken($token)->get($url . "/skp/list/pegawai?tahun=" . session('tahun_penganggaran') . "&type=bulanan&bulan=" . request('bulan'));
            }
        }

        return $data;
    }

    public function index($params)
    {
        $page_title = 'SKP';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $level = $this->checkLevel();

        $jadwalList = Http::withToken($token)->get($url . "/jadwal/list/");
        $jadwal = array();

        if (!$jadwalList['data']) {
            $jadwal[] = '';
            // $jadwal[$index]['startDate'] = '';
            // $jadwal[$index]['endDate'] = '';
        } else {
            foreach ($jadwalList['data'] as $key => $value) {
                $date = strtotime(date("Y-m-d"));
                $startDate = strtotime($value['tanggal_awal']);
                $endDate = strtotime($value['tanggal_akhir']);
                if ((($date >= $startDate) && ($date <= $endDate))) {
                    $jadwal[] = $value['sub_tahapan'];
                    // $jadwal[$index]['startDate'] = $value['tanggal_awal'];
                    // $jadwal[$index]['endDate'] = $value['tanggal_akhir'];
                }
            }
            // return $jadwal;
        }

        if ($params == 'tahunan') {
            if ($level == 1 || $level == 2) {
                return view('pages.skp.index2', compact('page_title', 'page_description', 'breadcumb'));
            } else {
                return view('pages.skp.index', compact('page_title', 'page_description', 'breadcumb'));
            }
        } else {
            $nama_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            if ($level == 1 || $level == 2) {
                return view('pages.skp.skp_bulanan.index2', compact('page_title', 'page_description', 'breadcumb', 'nama_bulan', 'jadwal'));
            } else {
                return view('pages.skp.skp_bulanan.index', compact('page_title', 'page_description', 'breadcumb', 'nama_bulan', 'jadwal'));
            }
        }
    }

    public function getSasaranKinerjaAtasan()
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = Http::withToken($token)->get($url . "/skp/get-option-sasaran-kinerja");
        // return $data->json();
        return $data['data'];
    }

    public function getSatuan()
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = Http::withToken($token)->get($url . "/skp/get-option-satuan");

        return $data->json();
    }

    public function create()
    {
        $page_title = 'SKP';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai', 'tambah skp'];
        $sasaran_kinerja_atasan = $this->getSasaranKinerjaAtasan();
        $satuan = $this->getSatuan();
        $level = $this->checkLevel();
        // return $level;
        if ($level == 1 || $level == 2) {
            return view('pages.skp.add_', compact('page_title', 'page_description', 'breadcumb', 'satuan'));
        } else {
            return view('pages.skp.add', compact('page_title', 'page_description', 'breadcumb', 'sasaran_kinerja_atasan', 'satuan'));
        }
    }

    public function get_sasaran_kinerja()
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $sasaran_kinerja = Http::withToken($token)->get($url . "/aktivitas/get-option-sasaran-kinerja?tahun=" . session('tahun_penganggaran'));
        return $sasaran_kinerja->json();
    }

    public function create_target()
    {
        $bulan = request('bulan');
        $page_title = 'SKP';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai', 'tambah Target SKP'];

        $level = $this->checkLevel();
        $get_sasaran_kinerja = $this->get_sasaran_kinerja();
        $level = $this->checkLevel();
        return view('pages.skp.skp_bulanan.add', compact('page_title', 'page_description', 'breadcumb', 'get_sasaran_kinerja', 'level', 'bulan'));
    }

    public function edit($params)
    {
        $type = request('type');
        $page_title = 'SKP';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai', 'update skp'];
        $sasaran_kinerja_atasan = $this->getSasaranKinerjaAtasan();

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $dataById = Http::withToken($token)->get($url . "/skp/show/" . $params);
        $data = $dataById['data'];

        $level = $this->checkLevel();

        if ($type == 'tahunan') {
            return view('pages.skp.edit', compact('page_title', 'page_description', 'breadcumb', 'sasaran_kinerja_atasan', 'data', 'level'));
        } else {
            $bulan = request('bulan');
            $get_sasaran_kinerja = $this->get_sasaran_kinerja();
            return view('pages.skp.skp_bulanan.edit', compact('page_title', 'page_description', 'breadcumb', 'get_sasaran_kinerja', 'data', 'level', 'bulan'));
        }
    }

    public function customValidate($params)
    {

        $result = [];
        $cek = [];

        // check if jenis_kinerja == utama, set sasaran_kinerja is required
        // if ($params->jenis_kinerja == "utama") {
        //     if (is_null($params->sasaran_kinerja)) {
        //         $result['sasaran_kinerja'][] = 'Sasaran Kinerja is field required';
        //     }
        // }

        if (is_null($params->rencana_kerja)) {
            $result['rencana_kerja'][] = 'Rencana Kerja is field required';
        }

        if ($params->type_skp == 'pegawai') {
            if (is_null($params->jenis_kinerja)) {
                $result['jenis_kinerja'][] = 'Jenis Kinerja is field required';
            } else {
                if ($params->jenis_kinerja == 'utama') {
                    if (is_null($params->sasaran_kinerja)) {
                        $result['sasaran_kinerja'][] = 'Sasaran Kinerja is field required';
                    }
                }
            }
        } else {
            if (is_null($params->jenis_kinerja)) {
                $result['jenis_kinerja'][] = 'Jenis Kinerja is field required';
            }

            if (isset($params->indikator_kerja_individu_add)) {
                foreach ($params->indikator_kerja_individu_add as $key => $ikis) {
                    if (is_null($ikis)) {
                        $result['indikator_kerja_individu_add_' . $key][] = 'Indikator Kerja Individu is field required';
                    }
                }
            }

            if (isset($params->satuan_add)) {
                foreach ($params->satuan_add as $key => $ikis) {
                    if (is_null($ikis)) {
                        $result['satuan_add_' . $key][] = 'Satuan is field required';
                    }
                }
            }

            if ($params->target_add) {
                foreach ($params->target_add as $key => $ikis) {
                    if (is_null($ikis)) {
                        $result['target_add_' . $key][] = 'Target is field required';
                    }
                }
            }
        }


        foreach ($params->indikator_kerja_individu as $key => $ikis) {
            if (is_null($ikis)) {
                $result['indikator_kerja_individu_' . $key][] = 'Indikator Kerja Individu is field required';
            }
        }

        foreach ($params->satuan as $key => $ikis) {
            if (is_null($ikis)) {
                $result['satuan_' . $key][] = 'Satuan is field required';
            }
        }

        foreach ($params->target as $key => $ikis) {
            if (is_null($ikis)) {
                $result['target_' . $key][] = 'Target is field required';
            } elseif ($ikis <= 0) {
                $result['target_' . $key][] = 'Require minimal 1 target';
            }
        }



        // return $cek;

        return $result;
    }

    public function store(Request $request)
    {


        $validated = $this->customValidate($request);

        if (count($validated) > 0) {
            return response()->json($validated, 422);
        } else {
            $result = [];
            $aspek = [];
            $current_user = session()->get('user.current');

            for ($i = 0; $i < count($request->indikator_kerja_individu); $i++) {

                $aspek[$i] = [
                    'iki' => $request->indikator_kerja_individu[$i],
                    'satuan' => $request->satuan[$i],
                    'target' => $request->target[$i],
                    'type_aspek' => $request->type_aspek[$i]
                ];
            }



            // 
            $result = [
                'type_skp' => $request['type_skp'],
                'id_satuan_kerja' => $current_user['pegawai']['id_satuan_kerja'],
                'id_skp_atasan' => $request['sasaran_kinerja'],
                'jenis' => $request['jenis_kinerja'],
                'rencana_kerja' => $request['rencana_kerja'],
                'tahun' => date('Y'),
                'aspek' => $aspek,
                'type_skp' => $request['type_skp']
            ];

            // return $result;

            $url = env('API_URL');
            $token = session()->get('user.access_token');

            $response = Http::withToken($token)->post($url . "/skp/store", $result);
            if ($response->successful()) {
                return response()->json(['success' => $response->json()]);
            } else {
                return response()->json(['failed' => $response->json()]);
            }
        }

        if ($validated == 'success') {
        } elseif ($validated !== 'success') {
            return 'tidak';
        }
    }

    public function validate_skp_kepala($params)
    {

        $result = [];
        $tes = [];

        if (is_null($params->jenis_kinerja)) {
            $result['jenis_kinerja'][] = 'Jenis kinerja is field required';
        }

        if (is_null($params->rencana_kerja)) {
            $result['rencana_kerja'][] = 'rencana kerja is field required';
        }

        // return $params->indikator_kerja_individu;
        $row_count = count($params->indikator_kerja_individu);

        // return $params->target_;

        foreach ($params->indikator_kerja_individu as $k => $val) {
            if (is_null($val)) {
                $result['indikator_kerja_individu_' . $k][] = 'Indikator Kerja Individu is field required';
            }

            if (!empty($params->satuan)) {
                if (!isset($params->satuan[$k])) {
                    $result['satuan_' . $k][] = 'Satuan is field required';
                }
            } else {
                $result['satuan_' . $k][] = 'Satuan is field required';
            }
        }

        // return $params->target_;

        if (!empty($params->target_)) {
            foreach ($params->target_ as $key => $value) {
                // return $value;
                foreach ($value as $x => $v) {
                    if (is_null($v)) {
                        $result['target_' . $key . '_' . $x] = 'Target is field required';
                    } elseif ($v <= 0) {
                        $result['target_' . $key . '_' . $x] = 'Require minimal 1 target';
                    }
                }
            }
        }

        // for ($i=0; $i < $row_count; $i++) { 
        //     if (is_null($params->indikator_kerja_individu[$i])) {
        //         $result['indikator_kerja_individu_'.$i][] = 'Indikator Kerja Individu is field required';
        //     }

        //     if (!empty($params->satuan)) {
        //         if (!isset($params->satuan[$i])) {
        //             $result['satuan_'.$i][] = 'Satuan is field required';
        //         }
        //     }else{
        //         $result['satuan_'.$i][] = 'Satuan is field required';
        //     }

        //    if (!empty($params->target_)) {
        //     foreach ($params->target_ as $key => $value) {
        //         // return $value;
        //         foreach ($value as $x => $v) {
        //             if (is_null($v)) {
        //                 // $tes[] =  'row ='.$i.' nilai ='.$x;
        //                 $result['target_'.$i.'_'.$x] = 'Target is field required';
        //             }
        //         }

        //     }

        //    }

        // }

        // return $tes;


        return $result;
    }


    public function store_kepala(Request $request)
    {
        // return $request->all();

        $validated = $this->validate_skp_kepala($request);

        // return $validated;

        if (count($validated) > 0) {
            return response()->json($validated, 422);
        } else {
            $result = [];
            $current_user = session()->get('user.current');
            $result = [
                'id_satuan_kerja' => $current_user['pegawai']['id_satuan_kerja'],
                'indikator_kerja_individu' => $request->indikator_kerja_individu,
                'jenis_kinerja' => $request->jenis_kinerja,
                'rencana_kerja' => $request->rencana_kerja,
                'satuan' => $request->satuan,
                'target_' => $request->target_,
                'type_skp' => $request->type_skp,
                'tahun' => date('Y'),
            ];

            // return $result;

            $url = env('API_URL');
            $token = session()->get('user.access_token');

            $response = Http::withToken($token)->post($url . "/skp/store", $result);
            return $response;
        }
    }

    public function update($params, Request $request)
    {
        // return $request;

        $validated = $this->customValidate($request);

        if (count($validated) > 0) {
            return response()->json($validated, 422);
        } else {

            $result = [];
            $aspek = [];
            $aspek_additional = [];
            $current_user = session()->get('user.current');

            for ($i = 0; $i < count($request->indikator_kerja_individu); $i++) {

                $aspek[$i] = [
                    'iki' => $request->indikator_kerja_individu[$i],
                    'satuan' => $request->satuan[$i],
                    'target' => $request->target[$i],
                    'type_aspek' => $request->type_aspek[$i],
                    'id' => $request->id_aspek[$i],
                    'id_target' => $request->id_target[$i],
                ];
            }

            if (isset($request->indikator_kerja_individu_add)) {
                foreach ($request->indikator_kerja_individu_add as $mk => $iki_add) {
                    $aspek_additional[] = [
                        'iki' => $iki_add,
                        'satuan' => $request->satuan_add[$mk],
                        'target' => $request->target_add[$mk],
                        'type_aspek' => $request->type_aspek_add[$mk]
                    ];
                }
            }


            $result = [
                'type_skp' => $request['type_skp'],
                'id_satuan_kerja' => $current_user['pegawai']['id_satuan_kerja'],
                'id_skp_atasan' => $request['sasaran_kinerja'],
                'jenis' => $request['jenis_kinerja'],
                'rencana_kerja' => $request['rencana_kerja'],
                'tahun' => date('Y'),
                'aspek' => $aspek,
                'type_skp' => $request['type_skp'],
                'aspek_additional' => $aspek_additional
            ];

            $url = env('API_URL');
            $token = session()->get('user.access_token');


            $response = Http::withToken($token)->post($url . "/skp/update/" . $params, $result);

            if ($response->successful()) {
                return response()->json(['success' => $response->json()]);
            } else {
                return response()->json(['failed' => $response->json()]);
            }
        }

        if ($validated == 'success') {
            //    return 'ya';
            // $result = [];
            // $aspek = [];
            // $target_bulan = [$request->target_kualitas,$request->target_kuantitas,$request->target_waktu];
            // $type_aspek = ['kuantitas','kualitas','waktu'];
            // $current_user = session()->get('user.current');

            // for ($i=0; $i < count($request->iki); $i++) { 

            // $aspek[$i] = [
            //         'iki' => $request->indikator_kerja_individu[$i],
            //         'satuan' => $request->satuan[$i],
            //         'target' => $target_bulan[$i],
            //         'type_aspek' => $type_aspek[$i]
            // ];
            // }

            // // 
            // $result = [
            //     'id_satuan_kerja' =>$current_user['pegawai']['id_satuan_kerja'],
            //     'id_skp_atasan' => $request['sasaran_kinerja'],
            //     'jenis' => $request['jenis_kinerja'],
            //     'rencana_kerja' => $request['rencana_kerja'],
            //     'tahun' => date('Y'),
            //     'aspek' => $aspek
            // ];

            // // return $result;

            // $url = env('API_URL');
            // $token = session()->get('user.access_token');

            // $response = Http::withToken($token)->post($url."/skp/store", $result);
            // return $response;
            // if($response->successful()){
            //     return response()->json(['success'=> $response->json()]);
            // }else{
            //     return response()->json(['failed'=> $response->json()]);
            // } 
        } elseif ($validated !== 'success') {
            return 'tidak';
            //    return $validated;
        }
    }

    public function update_kepala($params, Request $request)
    {


        $validated = $this->validate_skp_kepala($request);

        if (count($validated) > 0) {
            return response()->json($validated, 422);
        } else {
            $result = [];
            $indikator_kerja_individu = [];
            $satuan = [];
            $target_ = [];
            foreach ($request->indikator_kerja_individu as $iki => $iki_) {
                $indikator_kerja_individu[] = $iki_;
                $satuan[] = $request->satuan[$iki];
                $target_[] = $request->target_[$iki];
            }
            $current_user = session()->get('user.current');
            $result = [
                'id_satuan_kerja' => $current_user['pegawai']['id_satuan_kerja'],
                'indikator_kerja_individu' => $indikator_kerja_individu,
                'jenis_kinerja' => $request->jenis_kinerja,
                'rencana_kerja' => $request->rencana_kerja,
                'satuan' => $satuan,
                'target_' => $target_,
                'type_skp' => $request->type_skp,
                'tahun' => date('Y'),
            ];

            $url = env('API_URL');
            $token = session()->get('user.access_token');

            $response = Http::withToken($token)->post($url . "/skp/update/" . $params, $result);
            return $response;
        }
    }

    public function show($params)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->get($url . "/skp/show/" . $params . "?bulan=" . request('bulan'));
        return $response;
    }

    public function store_target(Request $request)
    {
        $result = array();
        if (is_null($request->rencana_kerja)) {
            $result['rencana_kerja'][] = 'Rencana Kerja is field required';
        }

        if (isset($request->target)) {
            foreach ($request->target as $key => $ikis) {
                if (is_null($ikis)) {
                    $result['target_' . $key][] = 'Target is field required, ';
                } elseif ($ikis <= 0) {
                    $result['target_' . $key][] = 'Require minimal 1 target';
                }
            }
        }

        if (count($result) > 0) {
            return response()->json($result, 422);
        } else {
            $url = env('API_URL');
            $token = session()->get('user.access_token');
            $data = $request->all();
            // return $data;

            $response = Http::withToken($token)->post($url . "/skp/store-bulanan/", $data);
            if ($response->successful()) {
                return response()->json(['success' => $response->json()]);
            } else {
                return response()->json(['failed' => $response->json()]);
            }
        }
    }

    public function update_target($params, Request $request)
    {
        $result = array();
        if (isset($request->target)) {
            foreach ($request->target as $key => $ikis) {
                if (is_null($ikis)) {
                    $result['target_' . $key][] = 'Target is field required';
                }
            }
        }

        if (count($result) > 0) {
            return response()->json($result, 422);
        } else {
            $url = env('API_URL');
            $token = session()->get('user.access_token');
            $data = $request->all();

            $response = Http::withToken($token)->post($url . "/skp/update-bulanan/" . $params, $data);
            if ($response->successful()) {
                return response()->json(['success' => $response->json()]);
            } else {
                return response()->json(['failed' => $response->json()]);
            }
        }
    }

    public function delete($params)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $type = request('type');
        if ($type == 'tahunan') {
            $response = Http::withToken($token)->delete($url . "/skp/delete/" . $params . "?type=" . $type);
        } else {
            $response = Http::withToken($token)->delete($url . "/skp/delete/" . $params . "?type=" . $type . "&bulan=" . request('bulan'));
        }
        return $response;
    }
}
