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
    $category = Category::count();
    $unit = Unit::count();
    $product = Product::count();
    $customerCount = Customer::count();
    $orderCount = Order::count();
    $reviewCount = Review::count();
    $contactCount = Contact::count();

    // Sum of total amounts for Paid orders
    $totalPaidAmount = Order::where('payment_status', 'Paid')->sum('total_amount');

    // Sum of total amounts for Pending orders
    $totalPendingAmount = Order::where('payment_status', 'Pending')->sum('total_amount');

    return view('backend.pages.dashboard', compact(
        'category',
        'unit',
        'product',
        'customerCount',
        'orderCount',
        'reviewCount',
        'contactCount',
        'totalPaidAmount',
        'totalPendingAmount'
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
