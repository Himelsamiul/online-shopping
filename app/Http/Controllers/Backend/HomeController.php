<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
    {
        public function home(){
          return view('backend.pages.dashboard');
        }
       
}
