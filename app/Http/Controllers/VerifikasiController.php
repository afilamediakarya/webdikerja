<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifikasiController extends Controller
{
    public function pendidikanFormal()
    {
        $page_title = 'Verifikasi';
        $page_description = 'Pendidikan Formal';
        $breadcumb = ['Pendidikan Formal'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $listPendidikanFormal = Http::withToken($token)->get($url . "/verifikasi/pendidikan-formal/");

        return $listPendidikanFormal;

        if ($listPendidikanFormal["code"] !== "200") {

            $listPendidikanFormal = [
                "nama" => "Nama pegawai",
                "nip" => "NIP pegawai",
                "nama_jabatan" => "Jabatan pegawai",
                "nama_satuan_kerja" => "Satuan Kerja pegawai",
            ];
        } else {
            $listPendidikanFormal = $listPendidikanFormal["data"];
        }

        return view('pages.Verfikasi.pendidikan-formal', compact('page_title', 'page_description', 'breadcumb', 'personalData', 'listPendidikanFormal'));
    }
}
