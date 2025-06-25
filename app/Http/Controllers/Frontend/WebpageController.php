<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WebpageController extends Controller
{
    // Show the homepage
    public function webpage()
    {
        $products = Product::all();
        $category = Category::all();
        return view('frontend.pages.home', compact('category', 'products'));
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
public function destroy($id)
{
    $customer = Customer::findOrFail($id); // You can use your actual model name
    $customer->delete();

    return redirect()->back()->with('success', 'Customer deleted successfully!');
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
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');

    // Attempt login with remember me
    if (auth()->guard('customerGuard')->attempt($credentials, true)) {
        notify()->success('Login successful');
        return redirect()->route('webpage')->with('success', 'Login successful');
    }

    // Login failed
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


    public function profile()
    {
        $customer = auth()->guard('customerGuard')->user();  // Get the currently authenticated customer
        // Fetch orders of the customer
        $orders = Order::where('customer_id', $customer->id)->get();
        return view('frontend.pages.profile', compact('customer', 'orders'));  // Pass the customer and orders to the view
    }



    // Show the Edit Profile Form
    public function editProfile()
    {
        $customer = auth()->guard('customerGuard')->user();

        return view('frontend.pages.edit_profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = auth()->guard('customerGuard')->user();
        $customerModel = Customer::find($customer->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phoneno' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $customerModel->name = $request->name;
        $customerModel->phoneno = $request->phoneno;
        $customerModel->address = $request->address;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($customerModel->image && file_exists(storage_path('app/customer/' . $customerModel->image))) {
                unlink(storage_path('app/customer/' . $customerModel->image));
            }

            // Process new upload
            $fileNameCustomer = date('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('customer', $fileNameCustomer);

            $customerModel->image = $fileNameCustomer;
        }

        $customerModel->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }


    public function downloadReceipt($id)
    {
        // Fetch the order based on the ID
        $order = Order::findOrFail($id);

        // Check if the order belongs to the authenticated customer
        if ($order->customer_id !== auth()->guard('customerGuard')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Decode the cart_data stored in the order (assuming it's in JSON format)
        $cartItems = json_decode($order->cart_data, true); // This could be a list of product ids, quantities, etc.

        // Calculate the total after discount (adjust based on your model and logic)
        $totalAfterDiscount = $order->total - $order->discount; // Assuming you have 'total' and 'discount' fields

        // Pass the necessary data to the view
        return view('frontend.pages.receipt', [
            'order' => $order,
            'cartItems' => $cartItems,
            'totalAfterDiscount' => $totalAfterDiscount,
        ]);
    }
}
