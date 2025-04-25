<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WebpageController extends Controller
{
    // Show the homepage
    public function webpage()
    {
        $products = Product::all();
        $category = Category::all();
        return view('frontend.pages.home',compact('category','products'));
    }

    // Show the registration form
    public function form_reg()
    {
        return view('frontend.pages.Customer_reg');
    }

    // Handle user registration
    public function reg(Request $request)
    {
        // Validate input
        $checkValidation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:customers,email', // Ensure the email is unique
            'password' => 'required|min:6',
           'phone' => 'required|digits:11|starts_with:01',
// You can customize phone validation as needed
            'address' => 'required',
        ]);

        // If validation fails
        if ($checkValidation->fails()) {
            // Handle specific validation errors
            if ($checkValidation->errors()->has('email')) {
                notify()->error('The email has already been taken.');
            } else {
                // Handle other validation errors
                notify()->error('Something went wrong.');
            }

            return redirect()->back()->withErrors($checkValidation)->withInput();
        }

        // Process image upload
        $fileNameCustomer = '';
        if ($request->hasFile('image')) {
            // Generate a filename based on the current timestamp
            $fileNameCustomer = date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension();

            // Store the image in the public storage
            $request->file('image')->storeAs('customer', $fileNameCustomer);
        }

        // Create the customer record
        Customer::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
            'phoneno' => $request->phone,
            'address' => $request->address,
            'image' => $fileNameCustomer,
        ]);

        // Notify user of successful registration
        notify()->success('Registration Successful.');

        // Redirect to login page
        return redirect()->route('login');
    }

    // Show login form
    public function login()
    {
        return view('frontend.pages.Customer_login');
    }

    // Handle login success
    public function loginsuccess(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6', // Adjust as needed
        ]);
    
        // Prepare the credentials
        $credentials = $request->only('email', 'password');
    
        // Attempt to log the user in using the customerGuard
        if (auth()->guard('customerGuard')->attempt($credentials)) {
            notify()->success('Login successful');
            return redirect()->route('webpage')->with('success', 'Login successful');
        }
    
        // If login failed
        notify()->error('Invalid login credentials');
        return redirect()->back()->withInput();
    }
    
    // Handle logout functionality
    public function logoutsuccess()
    {
        // Log out using the customer guard
        auth('customerGuard')->logout();
    
        // Clear the session data
        session()->flush();
    
        // Redirect to homepage or login page
        return redirect()->route('webpage')->with('success', 'Logout successful');
    }
    
}
