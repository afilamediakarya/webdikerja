<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class MasterController extends Controller
{
   public function harilibur(Request $request){

      $page_title = 'Master';
      $page_description = 'Daftar Hari Libur';
      $breadcumb = ['Daftar Hari libur'];

      if($request->ajax()){
          $url = env('API_URL');
          $token = $request->session()->get('user.access_token');
          $response = Http::withToken($token)->get($url."/harilibur/list");
          if ($response->successful()) {
              $data = $response->json();
              return $data;
          }else{
              return 'err';
          }
      }

      return view('pages.admin.master.harilibur', compact('page_title', 'page_description','breadcumb'));
   }

   public function store_harilibur(Request $request){
      $url = env('API_URL');
      $token = $request->session()->get('user.access_token');
      $response = Http::withToken($token)->post($url."/harilibur/store", [
          'nama_libur' => $request->nama_libur,
          'start_end' => date("Y-m-d", strtotime($request->start_end)),
          'end_date' => date("Y-m-d", strtotime($request->end_date)),
      ]);
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

   public function show_harilibur(Request $request, $id){
  
      $url = env('API_URL');
      $token = $request->session()->get('user.access_token');
      $response = Http::withToken($token)->get($url."/harilibur/show/".$id);

      if($response->successful()){
          return response()->json(['success'=> $response->json()]);
      }else{
          return response()->json(['failed'=> $response->json()]);
      }   
  }

  public function update_harilibur(Request $request, $id){

         $url = env('API_URL');
         $token = $request->session()->get('user.access_token');
         $response = Http::withToken($token)->post($url."/harilibur/update/".$id, [
            'nama_libur' => $request->nama_libur,
            'start_end' => date("Y-m-d", strtotime($request->start_end)),
            'end_date' => date("Y-m-d", strtotime($request->end_date)),
         ]);
         if($response->successful()){
            $data = $response->object();
            if (isset($data->status)) {
               return response()->json(['success'=> 'Berhasil Update Data']);
            } else {
               return response()->json(['invalid'=> $response->json()]);
            }
         }else{
            return $response->body();
            return response()->json(['failed'=> $response->body()]);
         }
  }
}
