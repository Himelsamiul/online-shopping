<?php

namespace App\Http\Controllers\Backend;

use view;
use notify;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function loginForm()
    {
        return view('admin.pages.login');
    }
    public function loginPost(Request $request)
    {
        //  dd($request->all());
        $validate = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]
        );

        if ($validate->fails()) {
           
            return redirect()->back()->withErrors($validate);
        }

        $credentials = $request->only('email', 'password'); 
        //  dd($credentials);
        $login=auth()->guard('admin')->attempt($credentials);
        if ($login) {
            return redirect()->route('home');
        }
        notify()->success('Logged in sucessfully');
        return redirect()->back()->with('message', 'Invalid user email or password');
    }

    public function logout()
    {

        auth()->logout();
        notify()->success('Logged out sucessfully');
        return redirect()->route('admin.login');
    }

    public function list()
    {
        $users = Admin::all();
        return view('admin.pages.user.list', compact('users'));
    }

    public function createform()
    {
        return view('admin.pages.user.form');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'user_name' => 'required',
            'role' => 'required',
            'user_email' => 'required|email',
            'user_password' => 'required|min:6',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('myError', $validate->getMessageBag());
        }

        $fileName = null;
        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $fileName = date('Ymdhis') . '.' . $file->getClientOriginalExtension();

            $file->storeAs('/', $fileName);
        }


        Admin::create([
            'name' => $request->user_name,
            'role' => $request->role,
            'image' => $fileName,
            'email' => $request->user_email,
            'password' => bcrypt($request->user_password),
        ]);

        return redirect()->route('user.list')->with('message', 'User created successfully.');
    }
      
}
