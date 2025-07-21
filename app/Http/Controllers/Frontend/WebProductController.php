<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebProductController extends Controller
{
 public function product($categoryId = null)
{
    if ($categoryId) {
        // Fetch active products of specific category
        $products = Product::where('category_id', $categoryId)
                           ->where('status', 'active')
                           ->get();
    } else {
        // Fetch all active products
        $products = Product::where('status', 'active')->get();
    }

    return view('frontend.pages.products', compact('products'));
}


    public function singleProduct($id)
    {
        $product = Product::findOrFail($id); // Fetch the product or show 404
        return view('frontend.pages.single_product', compact('product'));
    }

    public function storeReview(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:255',
        ]);
    
        $customerId = Auth::guard('customerGuard')->id();
    
        Review::create([
            'product_id' => $id,
            'customer_id' => $customerId,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);
    
        return redirect()->back()->with('success', 'Thanks for your review!');
    }
    
}
