<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class WebProductController extends Controller
{
    public function product()
    {
        $products = Product::all();
        return view('frontend.pages.products',compact('products'));
    }

}
