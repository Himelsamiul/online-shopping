<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // Show the login page
    public function login()
    {
        return view('backend.pages.login');
    }

    public function doLogin(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('dashboard'));  // Redirect to intended page or default to dashboard
        }

        // If authentication fails, redirect back with an error
        return redirect()->back()->withErrors([
            'email' => 'Invalid credentials or account not found.',
        ]);
    }

    // Logout the user
    public function signout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Logout successful');
    }

    public function home()
    {
        // Fetch data for dashboard
        $category = Category::count();
        $unit = Unit::count();
        $product = Product::count();
        $customerCount = Customer::count();
        $orderCount = Order::count();
        $reviewCount = Review::count();
        $contactCount = Contact::count();
        // Return dashboard view with data
        return view('backend.pages.dashboard', compact('category', 'unit', 'customerCount','product','orderCount','reviewCount','contactCount'));
    }

    public function showCustomers()
    {
        // Fetch all customers from the database
        $customers = Customer::all();

        // Return the customer list view and pass the customers data
        return view('backend.pages.customerlist', compact('customers'));
    }
}
