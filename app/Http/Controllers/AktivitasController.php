<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class AktivitasController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Aktivitas';
        $page_description = 'Daftar Aktivitas';
        $breadcumb = ['Daftar Aktivitas'];
        if($request->ajax()){
            $url = env('API_URL');
            $token = $request->session()->get('user.access_token');
            $response = Http::withToken($token)->get($url."/aktivitas/list");
            if ($response->successful() && isset($response->object()->data)) {
                return $response->json();
            }else{
                return 'err';
            }
        }


        return view('pages.aktivitas.index', compact('page_title', 'page_description','breadcumb'));
    }

    public function aktivitas(Request $request)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->get($url."/aktivitas/list");
        if ($response->successful() && isset($response->object()->data)) {
            $data = $response->object()->data;
            $dataArr = [];
            foreach ($data as $key => $value) {
                $temp = [];
                $temp['title'] = $value->nama_aktivitas; 
                $temp['start'] = $value->tanggal; 
                $temp['description'] = $value->keterangan; 
                $temp['end'] = $value->tanggal; 
                $temp['className'] = 'fc-event-light fc-event-solid-primary'; 
                $dataArr[] = $temp; 
            }
            return collect($dataArr);
        }else{
            return 'err';
        }
    }
}
