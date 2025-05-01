<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class WebProductController extends Controller
{
    public function product($categoryId = null)
    {
        if ($categoryId) {
            // Fetch products of specific category
            $products = Product::where('category_id', $categoryId)->get();
        } else {
            // Fetch all products
            $products = Product::all();
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
        $request->validate([

            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:255',
        ]);
    
        Review::create([
        'rating' => $request->rating,
        'review' => $request->review,
        ]);
    
        return redirect()->back()->with('success', 'Thanks for your review!');
    }

    
}
