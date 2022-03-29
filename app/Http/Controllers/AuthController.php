<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Auth;
class AuthController extends Controller
{
    public function index(Request $request){

            // return 'hei';
            $page_title = 'Login';
            $page_description = 'Some description for the page';
            return view('pages.auth.login', compact('page_title', 'page_description'));
    }

    public function setLogin(Request $request){
        $url = env('API_URL');
            $response = Http::post($url."/login", [
                'username' => $request->username,
                'password' => $request->password
            ]);

            if($response->status() == 200){
                $data = $response->json();
                session(['user' => $response->json()]);
                return redirect('/');
            }else{
                return redirect()->back()->with('error', 'data Salah');
            }

    }
}
