<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function doLogin(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Get credentials (only email and password)
        $credentials = $request->only('email', 'password');

        // Attempt login
        if (Auth::attempt($credentials)) {
            // If login is successful
            // notify()->success('Login successful');
            return redirect()->route('home');
        }

        // If login fails
        // notify()->error('Invalid credentials');
        return redirect()->back();
    }

    public function signout()
    {
        // Logout the user
        Auth::logout();
        // notify()->success('Logout successful');
        return view('backend.pages.login');  // Adjust as per your login page view
    }
}
