<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebpageController extends Controller
{
    public function webpage()
    {
        return view('frontend.master');
    }
}
