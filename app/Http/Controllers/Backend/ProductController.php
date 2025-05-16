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
    // Fetch products with their category and unit relationships, and paginate by 5
    $products = Product::with('category', 'unit')->paginate(5);

    // Calculate the total number of products
    $totalProducts = $products->sum('quantity');

    // Calculate the total price of all products (price * quantity)
    $totalAmount = $products->sum(function ($product) {
        return $product->price * $product->quantity;
    });

    // Return the view with products, totalProducts, and totalAmount
    return view('backend.pages.product.list', compact('products', 'totalProducts', 'totalAmount'));
}

    // Show product creation form
    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('backend.pages.product.create', compact('categories', 'units'));
    }

    // Store the new product
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'previous_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'quantity' => 'required|numeric|min:1'
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('image/product'), $fileName);
        }

        Product::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'previous_price' => $validatedData['previous_price'],
            'category_id' => $validatedData['category_id'],
            'unit_id' => $validatedData['unit_id'],
            'status' => $validatedData['status'],
            'image' => $fileName,
            'quantity' => $validatedData['quantity'],
        ]);

        return redirect()->route('products.list')->with('success', 'Product created successfully');
    }

    // Show the edit form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $units = Unit::all();
        return view('backend.pages.product.edit', compact('product', 'categories', 'units'));
    }

    // Update product
   // ProductController.php

   public function update(Request $request, $id)
   {
       // Validation for nullable image
       $request->validate([
           'name' => 'required|string|max:255',
           'description' => 'required|string|max:500',
           'price' => 'required|numeric',
           'previous_price' => 'nullable|numeric|min:0',
           'category_id' => 'required|exists:categories,id',
           'unit_id' => 'required|exists:units,id',
           'quantity' => 'required|numeric',
           'status' => 'required|in:active,inactive',
           'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image is nullable
       ]);
   
       // Find the product
       $product = Product::findOrFail($id);
   
       // Update the product fields
       $product->name = $request->name;
       $product->description = $request->description;
       $product->price = $request->price;
       $product->previous_price = $request->previous_price;
       $product->category_id = $request->category_id;
       $product->unit_id = $request->unit_id;
       $product->quantity = $request->quantity;
       $product->status = $request->status;
   
       // Check if a new image is uploaded
       if ($request->hasFile('image')) {
           // If a new image is uploaded, delete the old image from storage
           if ($product->image && file_exists(public_path('image/product/'.$product->image))) {
               unlink(public_path('image/product/'.$product->image)); // Delete old image
           }
   
           // Store the new image
           $imageName = time().'.'.$request->image->extension();
           $request->image->move(public_path('image/product'), $imageName);
           $product->image = $imageName; // Save the new image name
       } elseif ($request->has('remove_image') && $request->remove_image == 'true') {
           // If the image is removed
           if ($product->image && file_exists(public_path('image/product/'.$product->image))) {
               unlink(public_path('image/product/'.$product->image)); // Delete old image
           }
           $product->image = 'no_image.jpg'; // Set the image as 'no_image.jpg' (or any placeholder)
       }
   
       // Save the updated product
       $product->save();
   
       return redirect()->route('products.list')->with('success', 'Product updated successfully.');
   }
   

    
    // Show product details
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.pages.product.show', compact('product'));
    }

    // Delete product
    public function delete($id)
{
    $product = Product::findOrFail($id);

    // Check if the image exists and is not the default placeholder
    if ($product->image && $product->image !== 'no_image.jpg') {
        $imagePath = public_path('image/product/' . $product->image);
        
        if (file_exists($imagePath)) { 
            unlink($imagePath); // Delete only if it exists
        }
    }

    // Delete product record from the database
    $product->delete();

    return redirect()->route('products.list')->with('success', 'Product deleted successfully.');
}


// app/Http/Controllers/ProductController.php



    // Search function
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        
        // Search for products that match the search term
        $products = Product::where('name', 'like', '%' . $searchTerm . '%')
                           ->orWhere('description', 'like', '%' . $searchTerm . '%')
                           ->get();

        // Return the results to a view
        return view('frontend.pages.search', compact('products', 'searchTerm'));
    }
}


