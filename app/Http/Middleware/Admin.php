<?php



namespace App\Http\Middleware;  

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and is an admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // Proceed to the next step if user is admin
        }

        // Redirect to admin login page if not an admin
        return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page.');
    }
}



