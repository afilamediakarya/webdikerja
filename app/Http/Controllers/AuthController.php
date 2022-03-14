<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        {
            // return 'hei';
            $page_title = 'Login';
            $page_description = 'Some description for the page';
    
            return view('pages.auth.login', compact('page_title', 'page_description'));
        }
    }
}
