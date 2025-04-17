<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WebpageController extends Controller
{
    public function webpage()
    {
        return view('frontend.pages.home');
    }
    public function form_reg()
    {
        return view('frontend.pages.Customer_reg');
    }


    public function reg(Request $request)
    {



        $checkValidation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'address' => 'required',



        ]);

        if ($checkValidation->fails()) {
            if ($checkValidation->errors()->has('email')) {
                notify()->error('The email has already been taken.');
            }else {
                // Notify the user about other validation errors
                notify()->error('Something went wrong.');
            }
            // notify()->error($checkValidation->getMessageBag());
            // notify()->error('somethings went wrong');
            return redirect()->back()->with('myError', $checkValidation->getMessageBag());
        }

        $fileNameCustomer = '';

        if ($request->hasFile('image'))  //name of image form
        {
            //generate name i.e: 20240416170933.jpeg
            $fileNameCustomer = date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension();

            //2.3: store it into public folder
            $request->file('image')->storeAs('/customer', $fileNameCustomer);
            //public/uploads/category/20244394343.png



        }


        Customer::Create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
            'phoneno' => $request->phone,
            'address' => $request->address,
            'image' => $fileNameCustomer,
        ]);

        notify()->success('registration Successfully.');

        return redirect()->route('customer.login');
    }
    public function login()
    {
        return view('frontend.pages.Customer_login');
    }


    public function loginsuccess(Request $request)
    {


        //dd($request->all());


        $usterInput = ['email' => $request->email, 'password' => $request->password];
        $checkLogin = auth()->guard('customerGuard')->attempt($usterInput);

        if ($checkLogin) {
            //dd("login done");

            notify()->success('Login successfull');

            return redirect()->route('home');
        }



        // dd("login done");
        notify()->error('invalid user');
        return redirect()->back();

        //notify()->success('customer login Successfully.');

        // return redirect()->route('customer.login');



    }


    public function logoutsuccess()
    {

        auth('customerGuard')->logout();
        return view('frontend.pages.home');
    }


}

