<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {

        $roles = explode('|', $role); 
        if (in_array($request->session()->get('user.role') , $roles)) {
            return $next($request);
        }
        return back()->with('auth', 'Gak punya Akses');
    }
}
