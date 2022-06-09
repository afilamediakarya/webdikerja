<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// use Illuminate\Validation\ValidationException;
class SkpController extends Controller
{

    public function checkLevel(){
        $level = session()->get('user.level_jabatan');
        return $level;
    }

    public function index()
    {
        $page_title = 'SKP';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $level = $this->checkLevel();
        if ($level == 1 || $level == 2) {
            $data = Http::withToken($token)->get($url."/skp/list/kepala")['data'];
       
            return view('pages.skp.index2', compact('page_title', 'page_description','breadcumb','data'));   
        } else {
            $data = Http::withToken($token)->get($url."/skp/list/pegawai");
            
            return view('pages.skp.index', compact('page_title', 'page_description','breadcumb','data'));
        }

    }

    public function getSasaranKinerjaAtasan(){
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = Http::withToken($token)->get($url."/skp/get-option-sasaran-kinerja");
        // return $data->json();
        return $data['data'];
    }

    public function getSatuan(){
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = Http::withToken($token)->get($url."/skp/get-option-satuan");

        return $data->json();
    }

    public function create(){
        $page_title = 'SKP';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai', 'tambah skp'];
        $sasaran_kinerja_atasan = $this->getSasaranKinerjaAtasan();
        $satuan = $this->getSatuan();
        $level = $this->checkLevel();

        if ($level == 1 || $level == 2) {
            return view('pages.skp.add_', compact('page_title', 'page_description','breadcumb','satuan'));   
        } else {
            return view('pages.skp.add', compact('page_title', 'page_description','breadcumb','sasaran_kinerja_atasan','satuan'));
        }
    }

    public function edit($params){
        $page_title = 'SKP';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Daftar Sasaran Kinerja Pegawai', 'update skp'];
        $sasaran_kinerja_atasan = $this->getSasaranKinerjaAtasan(); 
        $satuan = $this->getSatuan();
        $total_sum = [];

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $dataById = Http::withToken($token)->get($url."/skp/show/".$params);
        $data = $dataById['data'];
        foreach($data['aspek_skp'] as $key => $value){
            $nilai = 0;
            foreach ($value['target_skp'] as $k => $v) {
                $total_sum[$key] = $nilai+= $v['target'];
            }
        }

        $level = $this->checkLevel();
  
        if ($level == 1 || $level == 2) {
            return view('pages.skp.edit_', compact('page_title', 'page_description','breadcumb','sasaran_kinerja_atasan','satuan','data','total_sum'));   
        } else {
            return view('pages.skp.edit', compact('page_title', 'page_description','breadcumb','sasaran_kinerja_atasan','satuan','data','total_sum'));
        }

        
    }

    public function customValidate($params){
        // return $params;
        $result = [];
        $cek = [];

        if (is_null($params->rencana_kerja)) {
            $result['rencana_kerja'][] = 'Rencana Kerja is field required';
        }

        if (is_null($params->jenis_kinerja)) {
            $result['jenis_kinerja'][] = 'Jenis Kinerja is field required';
        }

        if (is_null($params->sasaran_kinerja)) {
            $result['sasaran_kinerja'][] = 'Sasaran Kinerja is field required';
        }

        foreach ($params->indikator_kerja_individu as $key => $ikis) {
           if (is_null($ikis)) {
               $result['indikator_kerja_individu_'.$key][] = 'Indikator Kerja Individu is field required';
            }
        }

        foreach ($params->target_kualitas as $key => $targetKualitas) {
            if (is_null($targetKualitas)) {
                $result['target_kualitas_'.$key][] = 'Nilai Kinerja is field required';
             }
         }

         foreach ($params->target_kuantitas as $key => $targetKualitas) {
            if (is_null($targetKualitas)) {
                $result['target_kuantitas_'.$key][] = 'Nilai Kinerja is field required';
             }
         }

         foreach ($params->target_waktu as $key => $targetKualitas) {
            if (is_null($targetKualitas)) {
                $result['target_waktu_'.$key][] = 'Nilai Kinerja is field required';
             }
         }

        // return $params->satuan;

        if (empty($params->satuan)) {
            return 'kosong';
            for ($i=0; $i < 3; $i++) { 
                $result['satuan_'.$i][] = 'Satuan is field required';
            }
        }else{
           
           if (count($params->satuan) < 3) {
            foreach ($params->satuan as $k => $v) {
                for ($i=0; $i < 3; $i++) { 
                    if ($i !== $k) {
                        // $cek[$i] = $i;
                        $result['satuan_'.$i][] = 'Satuan is field required';
                    }
                }
            }
           }
        }

        // return $cek;

        return $result;

        
    }   

    public function store(Request $request){
      
       $validated = $this->customValidate($request);


        if (count($validated) > 0 ) {
            return response()->json($validated,422);   
        }else{
            $result = [];
                $aspek = [];
                $target_bulan = [$request->target_kualitas,$request->target_kuantitas,$request->target_waktu];
                $type_aspek = ['kuantitas','kualitas','waktu'];
                $current_user = session()->get('user.current');

                for ($i=0; $i < count($request->indikator_kerja_individu); $i++) { 
                
                $aspek[$i] = [
                        'iki' => $request->indikator_kerja_individu[$i],
                        'satuan' => $request->satuan[$i],
                        'target' => $target_bulan[$i],
                        'type_aspek' => $type_aspek[$i]
                ];
                }

                // 
                $result = [
                    'type_skp' => $request['type_skp'],
                    'id_satuan_kerja' =>$current_user['pegawai']['id_satuan_kerja'],
                    'id_skp_atasan' => $request['sasaran_kinerja'],
                    'jenis' => $request['jenis_kinerja'],
                    'rencana_kerja' => $request['rencana_kerja'],
                    'tahun' => date('Y'),
                    'aspek' => $aspek,
                    'type_skp' => $request['type_skp'],
                ];

                // return $result;

                $url = env('API_URL');
                $token = session()->get('user.access_token');
            
                $response = Http::withToken($token)->post($url."/skp/store", $result);
                return $response;
                if($response->successful()){
                    return response()->json(['success'=> $response->json()]);
                }else{
                    return response()->json(['failed'=> $response->json()]);
                }
        }
     
       if ($validated == 'success') {
        
       }elseif($validated !== 'success'){
           return 'tidak';
        //    return $validated;
       }

        
    }

    public function validate_skp_kepala($params){

        $result = [];

        if (is_null($params->jenis_kinerja)) {
            $result['jenis_kinerja'][] = 'Jenis kinerja is field required';
        }

        if (is_null($params->sasaran_kinerja)) {
            $result['rencana_kerja'][] = 'rencana kerja is field required';
        }

        $row_count = count($params->indikator_kerja_individu);

        for ($i=0; $i < $row_count; $i++) { 
            if (is_null($params->indikator_kerja_individu[$i])) {
                $result['indikator_kerja_individu_'.$i][] = 'Indikator Kerja Individu is field required';
            }

            if (!empty($params->satuan)) {
                if (!isset($params->satuan[$i])) {
                    $result['satuan_'.$i][] = 'Satuan is field required';
                }
            }else{
                $result['satuan_'.$i][] = 'Satuan is field required';
            }
    
        }

        // return $row_count;


        return $result;
    }


    public function store_kepala(Request $request){
        // return $request->all();

        $validated = $this->validate_skp_kepala($request);

        // return $validated;

        if (count($validated) > 0 ) {
            return response()->json($validated,422);   
        }else{
            $result = [];
            $current_user = session()->get('user.current');
            $result = [
                'id_satuan_kerja' =>$current_user['pegawai']['id_satuan_kerja'],
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
        
            $response = Http::withToken($token)->post($url."/skp/store",$result);
            return $response;
        }    

      
    }

    public function update($params,Request $request){
      
        $validated = $this->customValidate($request);
 
         if (count($validated) > 0 ) {
             return response()->json($validated,422);   
         }else{
             $result = [];
                 $aspek = [];
                 $target_bulan = [$request->target_kualitas,$request->target_kuantitas,$request->target_waktu];
                 $type_aspek = ['kuantitas','kualitas','waktu'];
                 $current_user = session()->get('user.current');
 
                 for ($i=0; $i < count($request->indikator_kerja_individu); $i++) { 
                 
                 $aspek[$i] = [
                         'iki' => $request->indikator_kerja_individu[$i],
                         'satuan' => $request->satuan[$i],
                         'target' => $target_bulan[$i],
                         'type_aspek' => $type_aspek[$i]
                 ];
                 }
 
                 // 
                 $result = [
                     'id_satuan_kerja' =>$current_user['pegawai']['id_satuan_kerja'],
                     'id_skp_atasan' => $request['sasaran_kinerja'],
                     'jenis' => $request['jenis_kinerja'],
                     'rencana_kerja' => $request['rencana_kerja'],
                     'tahun' => date('Y'),
                     'aspek' => $aspek,
                     'type_skp' => $request['type_skp'],
                 ];
 
                 // return $result;
 
                 $url = env('API_URL');
                 $token = session()->get('user.access_token');
             
                 $response = Http::withToken($token)->post($url."/skp/update/".$params, $result);
                 return $response;
                 if($response->successful()){
                     return response()->json(['success'=> $response->json()]);
                 }else{
                     return response()->json(['failed'=> $response->json()]);
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
        }elseif($validated !== 'success'){
            return 'tidak';
         //    return $validated;
        }
 
         
    }
    
    public function update_kepala($params,Request $request){
        // return $request;
        $result = [];
        $indikator_kerja_individu = [];
        $satuan = [];
        $target_ = [];
        foreach($request->indikator_kerja_individu as $iki => $iki_){
            $indikator_kerja_individu[] = $iki_;
            $satuan[] = $request->satuan[$iki];
            $target_[] = $request->target_[$iki];
        }
        $current_user = session()->get('user.current');
        $result = [
            'id_satuan_kerja' =>$current_user['pegawai']['id_satuan_kerja'],
            'indikator_kerja_individu' => $indikator_kerja_individu,
            'jenis_kinerja' => $request->jenis_kinerja,
            'rencana_kerja' => $request->rencana_kerja,
            'satuan' => $satuan,
            'target_' => $target_,
            'type_skp' => $request->type_skp,
            'tahun' => date('Y'),
        ];
        // return $result;
        $url = env('API_URL');
        $token = session()->get('user.access_token');
    
        $response = Http::withToken($token)->post($url."/skp/update/".$params, $result);
        return $response;
    }

    public function delete($params){
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = Http::withToken($token)->delete($url."/skp/delete/".$params);
        return $response;
    }
}
