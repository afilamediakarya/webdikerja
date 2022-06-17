<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth;
class AuthController extends Controller
{
    public function index(Request $request){

            
            if ($request->session()->has('user')) {
                return redirect('/');
            }
            $page_title = 'Login';
            $page_description = 'Some description for the page';
            return view('pages.auth.login', compact('page_title', 'page_description'));
    }

    public function indexes(){
        
        $current_user = session()->has('user');
       
        if ($current_user > 0) {
           $role = session()->get('user.role');
           if ($role == 'admin_opd') {
               return redirect('/dashboard/admin');
           }else{
            return redirect('/dashboard/pegawai');
           }
            // return redirect('/');
        }else{
            return redirect('/login');
        }
    }

    public function setLogin(Request $request){
        $url = env('API_URL');
            $response = Http::post($url."/login", [
                'username' => $request->username,
                'password' => $request->password
            ]);


            if($response->status() == 200){
                $data = $response->json();
                // return $data;
                session(['user' => $response->json()]);
                session(['user_details' => $response->json()['current']['pegawai']]);
                session(['atasan' => $response->json()['check_atasan']]);
                session(['tahun' => date("Y")]);
                if ($data['role'] == 'admin_opd') {
                    return redirect('/dashboard/admin');    
                }elseif($data['role'] == 'pegawai'){
                    return redirect('/dashboard/pegawai'); 
                }else{
                    return redirect('/dashboard/super_admin');
                }
                
            }else{
                return redirect()->back()->with('error', 'data Salah');
            }

    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/login');
    }

    public function aborts(){
        return abort(404);
    }
}
