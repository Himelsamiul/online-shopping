<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::with('category', 'unit')->paginate(5); // Paginate with 10 items per page
    return view('backend.pages.product.list', compact('products'));
    }
    
    
    // Show product creation form
    public function create()
    {
        // Fetch all categories and units from the database
        $categories = Category::all();
        $units = Unit::all();

        // Pass categories and units to the view
        return view('backend.pages.product.create', compact('categories', 'units'));
    }

    // Store the new product
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', // Ensure category_id exists in categories table
            'unit_id' => 'required|exists:units,id', // Ensure unit_id exists in units table
            'status' => 'required|in:active,inactive', // Validate status field
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image file
            'quantity' => 'required|numeric|min:1'
        ]);
    
        
        //image handel korlam
        $fileName = '';
        if ($request->hasFile('image')) {
            // Generate the file name (timestamp + original extension)
            $fileName = $request->file('image')->getClientOriginalName();
            
            // Store the image directly in the public directory (public/image/category)
            $path = $request->file('image')->move(public_path('image/product'), $fileName);
        }
    
        // Create the product with the validated data
        Product::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'category_id' => $validatedData['category_id'],
            'unit_id' => $validatedData['unit_id'],
            'status' => $validatedData['status'], // Store the status
            'image' => $fileName,  // Store image path
            'quantity' => $validatedData['quantity'], // Default quantity value
        ]);
    
        // Redirect back to product creation page with success message
        return redirect()->route('products.list')->with('success', 'Product created successfully');
    }
    
}
