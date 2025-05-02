<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function list()
    {
        $review = Review::with(['product', 'customer'])->get();
        return view('backend.pages.review', compact('review'));
    }
}
