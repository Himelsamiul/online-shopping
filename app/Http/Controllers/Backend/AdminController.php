<?php

namespace App\Http\Controllers\Backend;


use DB;
use App\Models\Unit;
use App\Models\Order;
use App\Models\Review;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

        // Check if "remember me" was selected
        $remember = $request->has('remember');

        // Attempt login with "remember" flag
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); // Prevent session fixation
            return redirect()->intended(route('dashboard'));
        }

        // Authentication failed
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
        $category = Category::count();
        $unit = Unit::count();
        $product = Product::count();
        $customerCount = Customer::count();
        $orderCount = Order::count();
        $reviewCount = Review::count();
        $contactCount = Contact::count();

        // Paid amounts
        $totalPaidAmountSSL = Order::where('payment_method', 'sslcommerz')
            ->where('payment_status', 'Paid')
            ->sum('total_amount');

        $totalCollectedAmountCOD = Order::where('payment_method', 'cash_on_delivery')
            ->where('payment_status', 'Paid')
            ->sum('collected_amount');

        $totalPendingAmountCOD = Order::where('payment_method', 'cash_on_delivery')
            ->where('payment_status', 'Unpaid')
            ->sum(DB::raw('total_amount - IFNULL(collected_amount, 0)'));

        // New metrics
        $totalOrderAmount = Order::sum('total_amount');
        $totalCollection = $totalPaidAmountSSL + $totalCollectedAmountCOD;

        return view('backend.pages.dashboard', compact(
            'category',
            'unit',
            'product',
            'customerCount',
            'orderCount',
            'reviewCount',
            'contactCount',
            'totalPaidAmountSSL',
            'totalCollectedAmountCOD',
            'totalPendingAmountCOD',
            'totalOrderAmount',
            'totalCollection'
        ));
    }



    public function showCustomers()
    {
        // Fetch all customers from the database
        $customers = Customer::all();

        // Return the customer list view and pass the customers data
        return view('backend.pages.customerlist', compact('customers'));
    }

    // In CustomerController.php
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully.');
    }
}
